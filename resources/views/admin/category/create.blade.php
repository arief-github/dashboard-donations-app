@extends('layouts.app', ['title' => 'Tambah Kategori - Admin'])

@section('content')
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-300">
        <div class="container mx-auto px-6 py-8">
            <div class="p-6 bg-white rounded-md shadow-md">
                <h2 class="text-lg text-gray-700 font-semibold caitalized">
                    tambah kategori
                </h2>
                <hr class="mt-4">
                <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 gap-6 mt-4">
                        <div>
                            <label for="image" class="text-gray-700">GAMBAR</label>
                            <input type="file" class="form-input w-full mt-2 rounded-md bg-gray-200 focus:bg-white" name="image" id="image">
                            @error('image')
                                <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                    <div class="px-4 py-2">
                                        <p class="text-gray-600 text-sm">
                                            {{ $message }}
                                        </p>
                                    </div>
                                </div>
                            @enderror
                        </div>
                        <div>
                            <label for="name" class="text-gray-700">NAMA KATEGORI</label>
                            <input class="form-input w-full mt-2 rounded-md bg-gray-200 focus:bg-white" type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Nama Kategori">
                            @error('name')
                                <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                    <div class="px-4 py-2">
                                        <p class="text-gray-600 text-sm">
                                            {{ $message }}
                                        </p>
                                    </div>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-start mt-4">
                        <button
                            type="submit"
                            class="px-4 py-2 bg-gray-600 text-gray-200 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700"
                            x-data="{loading:false}"
                            x-on:click="loading=true; document.getElementById('form').submit();"
                            x-html="loading ? `Mohon Tunggu ...` : 'SIMPAN'" class="disabled:opacity-50"
                            x-bind:disabled="loading">
                        >
                            SIMPAN
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
