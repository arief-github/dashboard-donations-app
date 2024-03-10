@extends('layouts.auth', ['title' => 'Login - Admin'])
@section('content')
    <div class="flex justify-center items-center h-screen bg-gray-300 px-6">
    <div class="p-6 max-w-sm w-full bg-white shadow-md rounded-md">
        <div class="flex justify-center items-center">
            <span class="text-gray-700 font-semibold text-2xl uppercase">login</span>
        </div>
        @if (session('status'))
            <div class="bg-green-500 p-3 rounded-md shadow-sm mt-3 text-center"> {{ session('status') }} </div>
        @endif
            <form action="{{ route('login') }}" class="mt-4" method="POST">
                    @csrf
                    <label class="block">
                        <span class="text-gray-700"> Email </span>
                        <input type="email" name="email" placeholder="Masukkan Email" class="form-input mt-1 block w-full rounded-md focus:outline-none" value="{{ old('email') }}">
                        @error('email')
                            <div class="inline-flex max-w-sm w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm"> {{ $message }} </p>
                                </div>
                            </div>
                        @enderror
                    </label>
                    <label class="mt-3">
                        <span class="text-gray-700 text-sm">Password</span>
                        <input type="password" name="password" class="form-input mt-1 block w-full rounded-md" placeholder="Masukkan Password">
                        @error('password')
                            <div class="inline-flex max-w-sm w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                <div class="px-4 py-2">
                                    <p class="text-gray-600 text-sm"> {{ $message }} </p>
                                </div>
                            </div>
                        @enderror
                    </label>
                    <div class="flex justify-between items-center mt-4">
                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" class="form-checkbox text-indigo-600">
                                <span class="mx-2 text-gray-600 text-sm">Ingatkan Saya</span>
                            </label>
                        </div>
                        <div hx-boost="true">
                            <a class="block text-sm font-medium text-indigo-700 hover:underline" href="/forgot-password">
                                Lupa Password?
                            </a>
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="py-2 px-4 text-center bg-indigo-600 rounded-md text-white w-full text-sm hover:bg-indigo-500 focus:outline-none">
                            LOGIN
                        </button>
                    </div>
                </form>
             </div>
</div>
@endsection
