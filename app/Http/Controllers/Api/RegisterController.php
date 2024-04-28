<?php

namespace App\Http\Controllers\Api;

use App\Models\Donatur;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Register
     * 
     * @param mixed $request
     * @return void
     */

    public function register(Request $request)
    {
        // set validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:donaturs',
            'password' => 'required|min:8|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Create Donatur
        $donatur = Donatur::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // return JSON
        return response()->json([
            'success' => true,
            'message' => 'Register Berhasil',
            'data' => $donatur,
            'token' => $donatur->createToken('authToken')->accessToken
        ], 201);
    }
}
