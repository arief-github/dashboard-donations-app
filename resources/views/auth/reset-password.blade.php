@extends('layouts.auth', ['title' => 'Update Password - Admin'])

@section('content')
    <div class="flex justify-center items-center h-screen bg-gray-300 px-6">
        <div class="p-6 max-w-sm w-full bg-white shadow-md rounded-md">
            <div class="flex justify-center items-center">
                <span class="text-gray-700 font-semibold text-2xl uppercase">reset password</span>
            </div>
            @if (session('status'))
                <div class="bg-green-500 p-3 rounded-md shadow-sm mt-3">
                    {{ session('status') }}
                </div>
            @endif
            <form class="mt-4" action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                <label class="block">
                    <span class="text-gray-700 text-sm">Email</span>
                    <input type="email" name="email" id="email" value="{{ $request->email ?? old('email') }}" class="form-input mt-1 block w-full rounded-md focus:border-indigo-600" placeholder="Masukkan Alamat Email">
                    @error('email')
                    <div class="inline-flex max-w-sm w-full bg-red-200 shadow-md rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">
                                {{ $message }}
                            </p>
                        </div>
                    </div>
                    @enderror
                </label>
                <label class="block mt-3">
                    <span class="text-gray-700 text-sm">Password</span>
                    <input type="password" name="password" id="password" value="{{ $request->email ?? old('email') }}" class="form-input mt-1 block w-full rounded-md focus:border-indigo-600" placeholder="Masukkan Password">
                    @error('password')
                    <div class="inline-flex max-w-sm w-full bg-red-200 shadow-md rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">
                                {{ $message }}
                            </p>
                        </div>
                    </div>
                    @enderror
                </label>
                <label class="block mt-3">
                    <span class="text-gray-700 text-sm">Konfirmasi Password</span>
                    <input type="password" name="password_confirmation" id="password_confirmation" value="{{ $request->email ?? old('email') }}" class="form-input mt-1 block w-full rounded-md focus:border-indigo-600" placeholder="Masukkan Ulang Password">
                    @error('password')
                    <div class="inline-flex max-w-sm w-full bg-red-200 shadow-md rounded-md overflow-hidden mt-2">
                        <div class="px-4 py-2">
                            <p class="text-gray-600 text-sm">
                                {{ $message }}
                            </p>
                        </div>
                    </div>
                    @enderror
                </label>
                <div class="mt-6">
                    <button type="submit" hx-indicator="spinner" class="py-2 px-4 text-center bg-indigo-600 rounded-md w-full text-white text-sm hover:bg-indigo-500 focus:outline-none uppercase">
                        update password
                    </button>
                    <div class="flex gap-2 htmx-indicator" id="spinner">
                        <div class="w-5 h-5 rounded-full animate-pulse bg-blue-600"></div>
                        <div class="w-5 h-5 rounded-full animate-pulse bg-blue-600"></div>
                        <div class="w-5 h-5 rounded-full animate-pulse bg-blue-600"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
