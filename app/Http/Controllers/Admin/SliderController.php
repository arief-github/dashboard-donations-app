<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::latest()->paginate(5);
        return view('admin.slider.index', compact('sliders'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'link' => 'required'
        ]);

        // upload image process
        $image = $request->file('image');
        $image->storeAs('public/sliders', $image->hashName());

        // save to database
        $slider = Slider::create([
            'image' => $image->hashName(),
            'link' => $request->link
        ]);

        if($slider) {
            //redirect dengan pesan sukses
            return redirect()->route('admin.slider.index')->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            // redirect dengan pesan error
            return redirect()->route('admin.slider.index')->with(['error' => 'Data Gagal Disimpan']);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        $slider = Slider::findOrFail($slider->id);

        Storage::disk('local')->delete('public/sliders/'.basename($slider->image));

        $slider->delete();

        if($slider) {
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
