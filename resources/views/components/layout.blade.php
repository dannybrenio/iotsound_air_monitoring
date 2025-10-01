<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        Air and Sound Monitoring System
        {{-- <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}"> --}}
    </title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>      
    <style>
        /* Custom animations for smooth transitions */
        .menu-slide-in {
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
        }
        
        .menu-slide-in.active {
            transform: translateX(0);
        }
        
        .hamburger-line {
            transition: all 0.3s ease;
            transform-origin: center;
        }
        
        .hamburger.active .line1 {
            transform: rotate(45deg) translate(5px, 5px);
        }
        
        .hamburger.active .line2 {
            opacity: 0;
        }
        
        .hamburger.active .line3 {
            transform: rotate(-45deg) translate(7px, -6px);
        }
        
        .overlay {
            transition: opacity 0.3s ease-in-out;
        }
        
        .overlay.active {
            opacity: 1;
            visibility: visible;
        }
    </style>
</head>
<body class="bg-white overflow-y-auto hide-scrollbar">
    <!-- Fixed Header -->
    <header class="fixed top-0 left-0 right-0 shadow-xl w-screen h-[60px] px-10 py-2 bg-white z-50">
        <div class="flex flex-row w-full h-full justify-between items-center">
            <div class="h-full text-[#06402b] w-[50%] flex justify-start items-center uppercase text-xl font-extrabold">RASE</div>
            <div class="h-full w-[50%] flex justify-end items-center gap-x-4">
                <div class="h-full w-[50%] flex-row items-center justify-between hidden lg:flex">
                    <a href="{{ route('dashboard') }}" 
                        class="flex flex-row gap-x-2 justify-center items-center text-lg uppercase h-[80%]
                                {{ request()->routeIs('dashboard') ? 'text-green-500 border-b-2 font-semibold border-green-500 hover:scale-105 duration-300' : 'text-black hover:text-green-500 hover:scale-105 duration-300' }}">
                        <!-- <img src="{{asset('dashboard.png')}}" alt="" class="size-4"> -->
                        <svg xmlns="http://www.w3.org/2000/svg" 
                            viewBox="0 0 24 24" 
                            fill="none" 
                            stroke="currentColor" 
                            stroke-width="2" 
                            stroke-linecap="round" 
                            stroke-linejoin="round" 
                            class="size-5">
                        <line x1="4" y1="21" x2="20" y2="21" />
                        <rect x="6" y="10" width="4" height="7" />
                        <rect x="14" y="6" width="4" height="11" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('about') }}" 
                        class="flex flex-row gap-x-2 justify-center items-center text-lg uppercase h-[80%]
                                {{ request()->routeIs('about') ? 'text-green-500 border-b-2 font-semibold border-green-500 hover:scale-105 duration-300' : 'text-black hover:text-green-500 hover:scale-105 duration-300' }}">
                        <!-- <img src="{{asset('info.png')}}" alt="" class="size-4"> -->
                        <svg xmlns="http://www.w3.org/2000/svg" 
                                viewBox="0 0 24 24" 
                                fill="none" 
                                stroke="currentColor" 
                                stroke-width="2" 
                                stroke-linecap="round" 
                                stroke-linejoin="round" 
                                class="size-4">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="16" x2="12" y2="12" />
                            <line x1="12" y1="8" x2="12.01" y2="8" />
                        </svg>
                        About
                    </a>
                    <a href="{{ route('help') }}" 
                        class="flex flex-row gap-x-2 justify-center items-center text-lg uppercase h-[80%]
                                {{ request()->routeIs('help') ? 'text-green-500 border-b-2 font-semibold border-green-500 hover:scale-105 duration-300' : 'text-black hover:text-green-500 hover:scale-105 duration-300' }}">
                        <!-- <img src="{{asset('question.png')}}" alt="" class="size-4 fill-current"> -->
                        <svg xmlns="http://www.w3.org/2000/svg" 
                                viewBox="0 0 24 24" 
                                fill="none" 
                                stroke="currentColor" 
                                stroke-width="2" 
                                stroke-linecap="round" 
                                stroke-linejoin="round"
                                class="size-4">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M9.09 9a3 3 0 1 1 5.83 1c0 2-3 2.5-3 5" />
                            <line x1="12" y1="17" x2="12.01" y2="17" />
                        </svg>
                        Help
                    </a>
                </div>
                <!-- Mobile Hamburger Button -->
                <button id="hamburger-btn" class="hamburger lg:hidden flex flex-col justify-center items-center w-8 h-8 space-y-1 focus:outline-none">
                    <span class="hamburger-line line1 block w-6 h-0.5 bg-[#060033]"></span>
                    <span class="hamburger-line line2 block w-6 h-0.5 bg-[#060033]"></span>
                    <span class="hamburger-line line3 block w-6 h-0.5 bg-[#060033]"></span>
                </button>
            </div>
        </div>
    </header>

    <!-- Overlay -->
    <div id="overlay" class="overlay fixed inset-0 bg-black/90 bg-opacity-50 z-40 opacity-0 invisible"></div>

    <!-- Mobile Menu Sidebar -->
    <div id="mobile-menu" class="menu-slide-in fixed top-0 right-0 h-full w-80 bg-[#f8f1e9] shadow-lg z-50 lg:hidden">
        <div class="flex flex-col h-full">
            <!-- Menu Header -->
            <div class="flex justify-between items-center p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-[#060033] uppercase">Menu</h2>
                <button id="close-menu" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Menu Items -->
            <nav class="flex flex-col flex-1 p-6 space-y-4">
                <a href="{{route('dashboard')}}" 
                   class="mobile-nav-link flex items-center space-x-3 p-4 text-lg font-medium text-gray-700 hover:text-green-500 hover:bg-green-50 transition-colors duration-200
                        {{ request()->routeIs('dashboard') ? 'text-green-500 border-b-2 font-semibold border-green-500 hover:scale-105 duration-300' : 'text-black hover:text-green-500 hover:scale-105 duration-300' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                        viewBox="0 0 24 24" 
                        fill="none" 
                        stroke="currentColor" 
                        stroke-width="2" 
                        stroke-linecap="round" 
                        stroke-linejoin="round" 
                        class="size-5">
                        <line x1="4" y1="21" x2="20" y2="21" />
                        <rect x="6" y="10" width="4" height="7" />
                        <rect x="14" y="6" width="4" height="11" />
                    </svg>
                    <span class="uppercase">Dashboard</span>
                </a>

                <a href="{{route('about')}}" 
                   class="mobile-nav-link flex items-center space-x-3 p-4 text-lg font-medium text-gray-700 hover:text-green-500 hover:bg-green-50 transition-colors duration-200
                        {{ request()->routeIs('about') ? 'text-green-500 border-b-2 font-semibold border-green-500 hover:scale-105 duration-300' : 'text-black hover:text-green-500 hover:scale-105 duration-300' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                        viewBox="0 0 24 24" 
                        fill="none" 
                        stroke="currentColor" 
                        stroke-width="2" 
                        stroke-linecap="round" 
                        stroke-linejoin="round" 
                        class="size-5">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="16" x2="12" y2="12" />
                        <line x1="12" y1="8" x2="12.01" y2="8" />
                    </svg>
                    <span class="uppercase">About</span>
                </a>

                <a href="{{route('help')}}" 
                   class="mobile-nav-link flex items-center space-x-3 p-4 text-lg font-medium text-gray-700 hover:text-green-500 hover:bg-green-50 transition-colors duration-200
                        {{ request()->routeIs('help') ? 'text-green-500 border-b-2 font-semibold border-green-500 hover:scale-105 duration-300' : 'text-black hover:text-green-500 hover:scale-105 duration-300' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                        viewBox="0 0 24 24" 
                        fill="none" 
                        stroke="currentColor" 
                        stroke-width="2" 
                        stroke-linecap="round" 
                        stroke-linejoin="round"
                        class="size-5">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M9.09 9a3 3 0 1 1 5.83 1c0 2-3 2.5-3 5" />
                        <line x1="12" y1="17" x2="12.01" y2="17" />
                    </svg>
                    <span class="uppercase">Help</span>
                </a>
            </nav>

            <!-- Menu Footer -->
            <div class="p-6 border-t border-gray-200">
                <p class="text-sm text-gray-500 text-center">RASE © 2025</p>
            </div>
        </div>
    </div>

    <!-- Main content with padding to avoid overlap -->
    <main class="h-auto pt-[60px]">
        <div>
            {{$slot}}
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-[#06402b] w-screen text-white h-[130px] lg:h-[50px] flex flex-col lg:flex-row items-center justify-between py-4 lg:px-4">
        <p class="text-white h-auto font-bold upppercase">© RASE</p>
        <div class="w-full lg:w-[30%] h-auto flex flex-col lg:flex-row items-center justify-center lg:justify-between">
            <p class="text-white font-bold upppercase">Privacy Policy</p>
            <p class="text-white font-bold upppercase"># 0912-345-6789</p>
            <p class="text-white font-bold upppercase">Feedback</p>
        </div>
    </footer>
</body>

<script>
    document.addEventListener('DOMContentLoaded', () => {
    const hamburgerBtn = document.getElementById('hamburger-btn');
    const mobileMenu   = document.getElementById('mobile-menu');
    const overlay      = document.getElementById('overlay');
    const closeBtn     = document.getElementById('close-menu');

    // Open / close menu when hamburger clicked
    hamburgerBtn.addEventListener('click', () => {
        hamburgerBtn.classList.toggle('active');
        mobileMenu.classList.toggle('active');
        overlay.classList.toggle('active');
    });

    // Close menu when overlay clicked
    overlay.addEventListener('click', () => {
        hamburgerBtn.classList.remove('active');
        mobileMenu.classList.remove('active');
        overlay.classList.remove('active');
    });

    // Close menu when X button clicked
    closeBtn.addEventListener('click', () => {
        hamburgerBtn.classList.remove('active');
        mobileMenu.classList.remove('active');
        overlay.classList.remove('active');
    });
});

</script>

</html>