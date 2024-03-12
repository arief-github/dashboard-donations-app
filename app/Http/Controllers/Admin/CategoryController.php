<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->when(request()->q, function($categories) {
           $categories = $categories->where('name', 'like', '%'. request()->q. '%');
        })->paginate(10);

        return view('admin.category.index', compact('categories'));
    }

    // showing create page
    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
           'image' => 'required|image|mimes:jpeg,jpg,png|max:2000',
           'name' => 'required|unique:categories'
        ]);

        // upload image
        $image = $request->file('image');
        $image->storeAs('public/categories', $image->hashName());

        // save the data into DB
        $category = Category::create([
           'image' => $image->hashName(),
           'name' => $request->name,
           'slug' => Str::slug($request->name, '-')
        ]);

        if($category) {
            return redirect()->route('admin.category.index')->with([
                'success' => 'Data Kategori Berhasil Disimpan'
            ]);
        } else {
            return redirect()->route('admin.category.index')->with([
                'error' => 'Data Kategori Gagal Disimpan'
            ]);
        }
    }
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $category
     * @return void
     */

    // showing edit page
    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, Category $category) {
        $this->validate($request, [
            'name' => 'required|unique:categories,name,'.$category->id
        ]);

        // check if empty image
        if($request->file('image') == '') {
            // update the category data without image
            $category = Category::findOrFail($category->id);
            $category->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name, '-')
            ]);
        } else {
            // delete old image
            Storage::disk('local')->delete('public/categories/'.basename($category->image));

            // upload new image
            $image = $request->file('image');
            $image->storeAs('public/categories', $image->hashName());

            // update data category with image
            $category = Category::findOrFail($category->id);
            $category->update([
                'image' => $image->hashName(),
                'name' => $request->name,
                'slug' => Str::slug($request->name, '-')
            ]);
        }

        if($category) {
            return redirect()->route('admin.category.index')->with([
               'success' => 'Data Berhasil Diupdate!'
            ]);
        } else {
            return redirect()->route('admin.category.index')->with([
                'error' => 'Data Gagal Diupdate!'
            ]);
        }
    }

    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        Storage::disk('local')->delete('public/categories'.basename($category->image));

        $category->delete();

        if($category) {
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
