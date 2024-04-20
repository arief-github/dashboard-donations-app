<?php

namespace App\Http\Controllers\Admin;

use App\Models\Campaign;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CampaignController extends Controller
{
    /**
     * index
     * 
     * @return void
     */

    public function index()
    {
     $campaigns = Campaign::latest()->when(request()->q, function($campaigns) {
            $campaigns = $campaigns->where('title', 'like', '%'. request()->q . '%');
        })->paginate(10);

        return view('admin.campaign.index', compact('campaigns'));
    }

    /**
     * create
     * 
     * @return void
     */
    public function create()
    {
        $categories = Category::latest()->get();
        return view('admin.campaign.create', compact('categories'));
    }

    /**
     * store
     * 
     * @param mixed $request
     * @return void
     */

     public function store(Request $request)
     {
        // validate request
        $this->validate($request, [
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'title' => 'required',
            'category_id' => 'required',
            'target_donation' => 'required|numeric',
            'max_date' => 'required',
            'description' => 'required'
        ]);

        // upload image
        $image = $request->file('image');
        $image->storeAs('public/campaigns', $image->hashname());

        $campaign = Campaign::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
            'category_id' => $request->category_id,
            'target_donation' => $request->target_donation,
            'max_date' => $request->max_date,
            'description' => $request->description,
            'user_id' => auth()->user()->id,
            'image' => $image->hashname()
        ]);

        if($campaign) {
            // redirect with message success
            return redirect()->route('admin.campaign.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            // redirect with error message
            return redirect()->route('admin.campaign.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
     }

     /**
      * edit
      */
      public function edit(Campaign $campaign)
      {
        $categories = Category::latest()->get();
        return view('admin.campaign.edit', compact('campaign', 'categories'));
      }

      /**
       * update
       * 
       * @param mixed $request
       * @param mixed $campaign
       * @return void
       */

       public function update(Request $request, Campaign $campaign)
       {
            $this->validate($request, [
                'title'             => 'required',
                'category_id'       => 'required',
                'target_donation'   => 'required|numeric',
                'max_date'          => 'required',
                'description'       => 'required'
            ]);      

            // check if image is empty
            if($request->file('image') == '') {
                // update the campaign data without image
                $campaign = Campaign::findOrFail($campaign->id);
                $campaign->update([
                    'title' => $request->title,
                    'slug' => Str::slug($request->title, '-'),
                    'category_id' => $request->category_id,
                    'target_donation' => $request->target_donation,
                    'max_date' => $request->max_date,
                    'description' => $request->description,
                    'user' => auth()->user()->id
                ]);
            } else {
                // delete old image
                Storage::disk('local')->delete('public/campaigns'.basename($campaign->image));

                // upload new image
                $image = $request->file('image');
                $image->storeAs('public/campaigns', $image->hashname());

                // update campaign data
                $campaign = Campaign::findOrFail($campaign->id);
                $campaign->update([
                    'title'             => $request->title,
                    'slug'              => Str::slug($request->title, '-'),
                    'category_id'       => $request->category_id,
                    'target_donation'   => $request->target_donation,
                    'max_date'          => $request->max_date,
                    'description'       => $request->description,
                    'user_id'           => auth()->user()->id,
                    'image'             => $image->hashName()
                ]);
            }

            if($campaign) {
                // redirect with success message
                return redirect()->route('admin.campaign.index')->with(['success' => 'Data Berhasil Diupdate']);
            } else {
                // redirect with error message
                return redirect()->route('admin.campaign.index')->with(['error' => 'Data Gagal Diupdate']);
            }
       }

       /**
        * destroy
        */

        public function destroy($id)
        {
            $campaign = Campaign::findOrFail($id);
            Storage::disk('local')->delete('public/campaigns'.basename($campaign->image));

            $campaign->delete();

            if($campaign) {
                return response()->json([
                    'status' => 'success'
                ]);
            } else {
                return response()->json([
                    'status' => 'error'
                ]);
            }
        }
}
