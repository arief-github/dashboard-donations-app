<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get data categories
        $categories = Category::latest()->paginate(12);

        // return with JSON Response
        return response()->json([
            'success' => true,
            'message' => 'List Data Categories',
            'data' => $categories
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        // get detail data category
        $category = Category::where('slug', $slug)->first();

        if($category) {
            // return with response JSON success true and data
            return response()->json([
                'success' => true,
                'message' => 'Detail Data Category',
                'data' => $category
            ], 200);
        }

        // return with response JSON failed
        return response()->json([
            'success' => false,
            'message' => 'Data Tidak Ditemukan',
        ], 400);
    }

    /**
     * Category Home
     * 
     * @return void
     */

     public function categoryHome()
     {
        // get data categories
        $categories = Category::latest()->take(3)->get();

        // return with response json
        return response()->json([
            'success' => true,
            'message' => 'List Data Category Home',
            'data' => $categories
        ], 200);
     }
}
