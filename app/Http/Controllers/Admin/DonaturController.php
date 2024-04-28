<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donatur;

class DonaturController extends Controller
{
    // show all donatur data registered
    public function index()
    {
        $donaturs = Donatur::latest()->when(request()->q, function($donaturs) {
            $donaturs = $donaturs->where('name', 'like', '%'. request()->q . '%');
        })->paginate(10);

        return view('admin.donatur.index', compact('donaturs'));
    }
}
