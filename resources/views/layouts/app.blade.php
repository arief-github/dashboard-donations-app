<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1,
shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="shortcut icon" type="image/jpg"
          href="https://i.imgur.com/UyXqJLi.png" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    <!-- css -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;50
0;600;700&display=swap" rel="stylesheet">
    <!-- js -->
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js">
    </script>
    <script
        src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.1/dist/alpine.min.
js" defer></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200 font-roboto">
        <div :class="sideparOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed z-20 inset-0 bg-black opacity-50 transition-opacity lg:hidden"></div>
        <div :class="sidebarOpen ? 'translate-x-0 ease-out' : 'translate-x-full ease-in'" class="fixed z-30 inset-y-0 left-0 w-64 transition duration-300 transform bg-gray-900 overflow-y-auto lg:translate-x-0 lg:static lg:inset-0">
            <div class="flex items-center justify-center mt-4 mb-2">
                <div class="flex items-center">
                    <img src="{{ asset('img/dashImg.svg') }}" class="h-12 w-12" alt="big img icon dashboard"/>
                    <span class="text-white text-2xl mx-2 font-semibold uppercase">dashboard</span>
                </div>
            </div>

            <hr>

            <nav class="mt-5">
                <a class="flex items-center mt-4 py-2 px-6 hover:bg-opacity-25 hover:text-gray-100 cursor-pointer">
                    <img class="w-6 h-6" src="{{ asset('icon/dashIcon.svg') }}" alt="Icon Dashboard"/>
                    <span class="mx-3">Dashboard</span>
                </a>
                <a hx-boost="true" class="flex items-center mt-4 py-2 px-6 hover:bg-opacity-25 hover:text-gray-100 cursor-pointer 
                    {{ Request::is('admin.category*') ? 'bg-gray-700 bg-opacity-25 text-gray-100' : 'text-gray-500' }}" 
                    href="{{ route('admin.category.index') }}">
                    <img class="w-6 h-6" src="{{ asset('icon/kategorIcon.svg') }}" alt="Icon Kategory">
                    <span class="mx-3">Kategori</span>
                </a>
                <a hx-boost="true" class="flex items-center mt-4 py-2 px-6 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 {{ Request::is('admin/campaign*') ? ' bg-gray-700 bg-opacity-25 text-gray-100' :  'text-gray-500' }}"
                    href="{{ route('admin.campaign.index') }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9">
                        </path>
                    </svg>

                    <span class="mx-3">Campaigns</span>
                </a>
                <a hx-boost="true" class="flex items-center mt-4 py-2 px-6 hover:bg-opacity-25 hover:text-gray-100 cursor-pointer 
                    {{ Request::is('admin.donatur*') ? 'bg-gray-700 bg-opacity-25 text-gray-100' : 'text-gray-500' }}" 
                    href="{{ route('admin.donatur.index') }}">
                    <img class="w-6 h-6" src="{{ asset('icon/donaturIcon.svg') }}" alt="Icon Donatur">
                    <span class="mx-3">Donatur</span>
                </a>
                <a hx-boost="true" class="flex items-center mt-4 py-2 px-6 hover:bg-opacity-25 hover:text-gray-100 cursor-pointer 
                    {{ Request::is('admin.donation*') ? 'bg-gray-700 bg-opacity-25 text-gray-100' : 'text-gray-500' }}" 
                    href="{{ route('admin.donation.index') }}">
                    <img class="w-6 h-6" src="{{ asset('icon/donationIcon.svg') }}" alt="Icon Donation">
                    <span class="mx-3">Donasi</span>
                </a>
                <a hx-boost="true" class="flex items-center mt-4 py-2 px-6 hover:bg-opacity-25 hover:text-gray-100 cursor-pointer 
                    {{ Request::is('admin.profile*') ? 'bg-gray-700 bg-opacity-25 text-gray-100' : 'text-gray-500' }}" 
                    href="{{ route('admin.profile.index') }}">
                    <img class="w-6 h-6" src="{{ asset('icon/profile.svg') }}" alt="Icon Kategory">
                    <span class="mx-3">Profil Saya</span>
                 </a>
                <a hx-boost="true" class="flex items-center mt-4 py-2 px-6 hover:bg-opacity-25 hover:text-gray-100 cursor-pointer
                    {{ Request::is('admin/slider*') ? 'bg-gray-700 bg-opacity-25 text-gray-100' : 'text-gray-500' }}" href="{{ route('admin.slider.index') }}">
                    <img class="w-6 h-6" src="{{ asset('icon/sliders.svg') }}" alt="Icon Sliders">
                    <span class="mx-3">Sliders</span>
                </a>
            </nav>
        </div>
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="flex justify-between items-center py-4 px-6 bg-white">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                        <img src="{{ asset('icon/threeline.svg') }}" alt="three line images">
                    </button>
                </div>
                <div class="flex-items-center">
                    <div x-data="{ dropdownOpen: false }" class="relative">
                        <button @click="dropdownOpen = !dropdownOpen" class="relative block h-8 w-8 rounded-full overflow-hidden shadow focus:outline-none">
                            <img src="{{  auth()->user()->avatar }}" alt="avatar image" class="h-full w-full object-cover">
                        </button>

                        <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10"></div>

                        <div x-show="dropdownOpen" class="absolute right-0 mt-2 w-48 bg-white rounded-md overflow-hidden shadow-sm z-10">
                            <div class="block px-4 py-2 text-sm text-gray-700">
                                {{ auth()->user()->name }}
                            </div>
                            <hr>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white"
                            >Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </header>
            @yield('content')
        </div>
    </div>
<script>
    @if(session()->has('success'))
    Swal.fire({
            icon: 'success',
            title: 'BERHASIL!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000
    })

    @elseif(session()->has('error'))

    Swal.fire({
        icon: 'error',
        text: 'GAGAL!',
        title: '{{ session('error') }}',
        showConfirmButton: false,
        timer: 3000
    })

    @endif
</script>
    <script src="https://unpkg.com/htmx.org@1.9.6" integrity="sha384-FhXw7b6AlE/jyjlZH5iHa/tTe9EpJ1Y55RjcgPbjeWMskSxZt1v9qkxLJWNJaGni" crossorigin="anonymous"></script>
</body>
</html>
