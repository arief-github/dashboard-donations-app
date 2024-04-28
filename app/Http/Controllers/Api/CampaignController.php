<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\Donation;

class CampaignController extends Controller
{
    /**
     * index
     */

     public function index()
     {
        // get data campaigns
        $campaigns = Campaign::with('user')->with('sumDonation')->when(request()->q, function($campaigns) {
            $campaigns = $campaigns->where('title', 'like', '%'.request()->q.'%');
        })->latest()->paginate(5);

        // return with response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Campaigns',
            'data' => $campaigns,
        ], 200);
     }

    /**
      * A description of the entire PHP function.
      *
      * @param datatype $slug description
      * @throws Some_Exception_Class description of exception
      * @return Some_Return_Value
     */ 

     public function show($slug)
     {
        // get data campaign by slug
        $campaign = Campaign::with('user')->with('sumDonation')->where('slug', $slug)->first();

        // get data donation by campaign
        $donations = Donation::with('donatur')->where('campaign_id', $campaign->id)->where('status', 'success')->latest()->get();

        if(!$campaign) {
            return response()->json([
                'success' => false,
                'message' => 'Data Campaign Tidak Ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Data Campaign : '.$campaign->title,
            'data' => $campaign,
            'donations' => $donations
        ], 200);
     }
}
