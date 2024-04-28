<?php

namespace App\Http\Controllers\Api;

use Midtrans\Snap;
use App\Models\Campaign;
use App\Models\Donation;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DonationController extends Controller
{
    public function __construct()
    {
        \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('services.midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('services.midtrans.is3ds');
    }

    public function index()
    {
        $donations = Donation::with('campaign')->where('donatur_id', auth()->guard('api')->user()->id)->latest()->paginate(5);

        return response()->json([
            'success' => true,
            'message' => 'List Data Donations : '.auth()->guard('api')->user()->name,
            'data' => $donations
        ], 200);
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $length = 10;
            $random = '';

            for($i = 0; $i < $length; $i++) {
                $random .= rand(0,1) ? rand(0, 9) : chr(rand(ord('a'), ord('z')));
            }

            $no_invoice = 'TRX-'.Str::upper($random);

            // get data campaign
            $campaign = Campaign::where('slug', $request->campaignSlug)->first();

            $donation = Donations::create([
                'no_invoice' => $no_invoice,
                'campaign_id' => $campaign->id,
                'donatur_id' => auth()->guard('api')->user()->id,
                'amount' => $request->amount,
                'pray' => $request->pray,
                'status' => 'pending'
            ]);


            // make transaction to midtrans and then save the snap token
            $payload = [
                'transaction_details' => [
                    'order_id' => $donation->invoice,
                    'gross_amount' => $donation->amount,
                ],
                'customer_details' => [
                    'first_name' => auth()->guard('api')->user()->name,
                    'email' => auth()->guard('api')->user()->email,
                ]
            ];

            // create snap token
            $snapToken = Snap::getSnapToken($payload);
            $donation->snap_token = $snapToken;
            $donation->save();

            $this->response['snap_token'] = $snapToken;
        });

        return response()->json([
            'success' => true,
            'message' => 'Donation Berhasil Dibuat',
            $this->response
        ]);
    }

    public function notificationHandler(Request $request)
    {
        $payload = $request->getContent();
        $notification = json_decode($payload);

        $validateSignatureKey = hash("sha512", $notification->order_id . $notification->status_code . $notification->gross_amount . config('services.midtrans.serverKey'));
   
        if($notification->signature_key !== $validateSignatureKey) {
            return response(['message' => 'Invalid Signature'], 403);
        }

        $transaction = $notification->transaction_status;
        $type = $notification->paymentType;
        $orderId = $notification->order_id;
        $fraud = $notification->fraud_status;

        // data donation
        $data_donation = Donation::where('invoice', $orderId)->first();

        if ($transaction == 'capture') {
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card') {

              if($fraud == 'challenge') {
                
                /**
                *   update invoice to pending
                */
                $data_donation->update([
                    'status' => 'pending'
                ]);

              } else {
                
                /**
                *   update invoice to success
                */
                $data_donation->update([
                    'status' => 'success'
                ]);

              }

            }

        } elseif ($transaction == 'settlement') {

            /**
            *   update invoice to success
            */
            $data_donation->update([
                'status' => 'success'
            ]);


        } elseif($transaction == 'pending'){

            
            /**
            *   update invoice to pending
            */
            $data_donation->update([
                'status' => 'pending'
            ]);


        } elseif ($transaction == 'deny') {

            
            /**
            *   update invoice to failed
            */
            $data_donation->update([
                'status' => 'failed'
            ]);


        } elseif ($transaction == 'expire') {

            
            /**
            *   update invoice to expired
            */
            $data_donation->update([
                'status' => 'expired'
            ]);


        } elseif ($transaction == 'cancel') {

            /**
            *   update invoice to failed
            */
            $data_donation->update([
                'status' => 'failed'
            ]);

        }

    }
}
