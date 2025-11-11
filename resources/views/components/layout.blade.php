<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('bglogo.png') }}" type="image/png">
    <link rel="icon" href="{{ asset('bglogo.png') }}" type="image/png">
    <title>
        AeroSon
    </title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/luxon"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
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

        @keyframes marquee {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        .animate-marquee {
            animation: marquee 15s linear infinite;
        }
    </style>
</head>

<body class="bg-white overflow-y-auto hide-scrollbar">
    <!-- Fixed Header -->
    <header class="fixed top-0 left-0 right-0 shadow-md w-full h-[60px] px-10 py-2 bg-[#E0EBDC] z-50">
        <div class="flex flex-row w-full h-full justify-between items-center">
            <div
                class="h-full text-[#06402b] w-[50%] flex flex-row justify-start items-center text-xl font-extrabold gap-x-2 group">
                <a href="{{ route('dashboard') }}">
                    <img src="{{ asset('bglogo.png') }}" alt="" class="size-10 cursor-pointer">
                </a>
                <a href="{{ route('dashboard') }}"
                    class="text-center h-full flex justify-center items-center hidden lg:flex cursor-pointer uppercase">AeroSon</a>
            </div>
            <div class="h-full w-[80%] flex justify-end items-center gap-x-4">
                <div class="h-full w-[55%] flex-row items-center justify-between hidden lg:flex">
                    <a href="{{ route('dashboard') }}"
                        class="flex flex-row gap-x-2 justify-center items-center text-sm h-[80%]
                                {{ request()->routeIs('dashboard') ? 'text-[#06402b] border-b-2 font-semibold border-[#06402b] hover:scale-105 duration-300' : 'text-black hover:text-green-500 hover:scale-105 duration-300' }}">
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
                            <line x1="4" y1="21" x2="20" y2="21" />
                            <rect x="6" y="10" width="4" height="7" />
                            <rect x="14" y="6" width="4" height="11" />
                        </svg> -->
                        Dashboard
                    </a>
                    <a href="{{ route('about') }}"
                        class="flex flex-row gap-x-2 justify-center items-center text-sm h-[80%]
                                {{ request()->routeIs('about') ? 'text-[#06402b] border-b-2 font-semibold border-[#06402b] hover:scale-105 duration-300' : 'text-black hover:text-green-500 hover:scale-105 duration-300' }}">
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="16" x2="12" y2="12" />
                            <line x1="12" y1="8" x2="12.01" y2="8" />
                        </svg> -->
                        About Us
                    </a>
                    <a href="{{ route('help') }}"
                        class="flex flex-row gap-x-2 justify-center items-center text-sm h-[80%]
                                {{ request()->routeIs('help') ? 'text-[#06402b] border-b-2 font-semibold border-[#06402b] hover:scale-105 duration-300' : 'text-black hover:text-green-500 hover:scale-105 duration-300' }}">
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24">
                            <path fill="#E0EBDC" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 12h1m8-9v1m8 8h1M5.6 5.6l.7.7m12.1-.7l-.7.7M9 16a5 5 0 1 1 6 0a3.5 3.5 0 0 0-1 3a2 2 0 0 1-4 0a3.5 3.5 0 0 0-1-3m.7 1h4.6" />
                        </svg> -->
                        Knowledge Hub
                    </a>
                    <a href="{{ route('login') }}"
                        class="flex flex-row gap-x-2 justify-center items-center text-sm bg-[#06402b] rounded text-white font-bold w-20 uppercase h-[70%] hover:scale-105 duration-300">
                        Sign In
                    </a>
                </div>
                <!-- Mobile Hamburger Button -->
                <button id="hamburger-btn"
                    class="hamburger lg:hidden flex flex-col justify-center items-center w-8 h-8 space-y-1 focus:outline-none cursor-pointer">
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
    <div id="mobile-menu" class="menu-slide-in fixed top-0 right-0 h-full w-[80%] bg-[#E0EBDC] shadow-lg z-50 lg:hidden">
        <div class="flex flex-col h-full">
            <!-- Menu Header -->
            <div class="flex justify-between items-center p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-[#060033] uppercase">Menu</h2>
                <button id="close-menu" class="text-gray-500 hover:text-gray-700 focus:outline-none cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Menu Items -->
            <nav class="flex flex-col flex-1 p-6 space-y-4">
                <a href="{{route('dashboard')}}"
                    class="mobile-nav-link flex items-center space-x-3 p-4 text-lg font-medium text-gray-700 hover:text-green-500 hover:bg-green-50 transition-colors duration-200
                        {{ request()->routeIs('dashboard') ? 'text-[#06402b] border-b-2 font-semibold border-[#06402b]. hover:scale-105 duration-300' : 'text-black hover:text-green-500 hover:scale-105 duration-300' }}">
                    <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
                        <line x1="4" y1="21" x2="20" y2="21" />
                        <rect x="6" y="10" width="4" height="7" />
                        <rect x="14" y="6" width="4" height="11" />
                    </svg> -->
                    <span class="">Dashboard</span>
                </a>

                <a href="{{route('about')}}"
                    class="mobile-nav-link flex items-center space-x-3 p-4 text-lg font-medium text-gray-700 hover:text-green-500 hover:bg-green-50 transition-colors duration-200
                        {{ request()->routeIs('about') ? 'text-[#06402b] border-b-2 font-semibold border-[#06402b]. hover:scale-105 duration-300' : 'text-black hover:text-green-500 hover:scale-105 duration-300' }}">
                    <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="16" x2="12" y2="12" />
                        <line x1="12" y1="8" x2="12.01" y2="8" />
                    </svg> -->
                    <span class="">About Us</span>
                </a>

                <a href="{{route('help')}}"
                    class="mobile-nav-link flex items-center space-x-3 p-4 text-lg font-medium text-gray-700 hover:text-green-500 hover:bg-green-50 transition-colors duration-200
                        {{ request()->routeIs('help') ? 'text-[#06402b] border-b-2 font-semibold border-[#06402b]. hover:scale-105 duration-300' : 'text-black hover:text-green-500 hover:scale-105 duration-300' }}">
                    <!-- <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24">
                        <path fill="#E0EBDC" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 12h1m8-9v1m8 8h1M5.6 5.6l.7.7m12.1-.7l-.7.7M9 16a5 5 0 1 1 6 0a3.5 3.5 0 0 0-1 3a2 2 0 0 1-4 0a3.5 3.5 0 0 0-1-3m.7 1h4.6" />
                    </svg> -->
                    <span class="">Knowledge Hub</span>
                </a>

                <a href="{{ route('login') }}"
                    class="mobile-nav-link flex gap-x-2 justify-center items-center text-base bg-[#06402b] rounded text-white font-bold w-full h-16 hover:scale-105 duration-300">
                    Sign In
                </a>
            </nav>

            <!-- Menu Footer -->
            <div class="p-6 border-t border-gray-500">
                <p class="text-sm text-gray-500 text-center">© 2025 AeroSon</p>
            </div>
        </div>
    </div>

    <!-- Main content with padding to avoid overlap -->
    <main class="h-auto pt-[60px] w-full">
        <div>
            {{$slot}}
        </div>
    </main>

    <!-- Footer -->
    <footer
        class="bg-[#E0EBDC] w-full text-black h-auto flex flex-col items-center justify-center gap-y-10 py-8 lg:px-4 border-t border-[#638559]">
        <div class="w-[80%] h-auto flex flex-col lg:flex-row items-center lg:items-start justify-center lg:justify-between gap-y-10">
            <div class="flex flex-col">
                <h3 class="text-[#06402b] text-xl font-bold mb-4 relative inline-block mx-auto md:mx-0">
                    Quick Links
                    <span class="absolute bottom-0 left-0 w-1/2 h-0.5 bg-yellow-500"></span>
                </h3>
                <div class="flex flex-col gap-y-1 items-center lg:items-start">
                    <a href="{{ route('dashboard') }}" class="hover:text-green-500">Dashboard</a>
                    <a href="{{ route('about') }}" class="hover:text-green-500">About</a>
                    <a href="{{ route('help') }}" class="hover:text-green-500">Knowledge Hub</a>
                </div>
            </div>
            <div class="flex flex-col">
                <h3 class="text-[#06402b] text-xl font-bold mb-4 relative inline-block mx-auto md:mx-0">
                    Follow Us
                    <span class="absolute bottom-0 left-0 w-1/2 h-0.5 bg-yellow-500"></span>
                </h3>
                <div class="flex flex-row gap-x-3 justify-center items-center">
                    <!-- Facebook Logo -->
                    <a href="https://facebook.com/maribeth.barros.2024" target="_blank" rel="noopener noreferrer" class="flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-8 hover:scale-105 duration-300 cursor-pointer" viewBox="0 0 24 24"><path fill="currentColor" d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669c1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <!-- Instagram Logo -->
                    <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-8 hover:scale-105 duration-300 cursor-pointer" viewBox="0 0 24 24"><path fill="currentColor" d="M12 0C8.74 0 8.333.015 7.053.072C5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053C.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913a5.885 5.885 0 0 0 1.384 2.126A5.868 5.868 0 0 0 4.14 23.37c.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558a5.898 5.898 0 0 0 2.126-1.384a5.86 5.86 0 0 0 1.384-2.126c.296-.765.499-1.636.558-2.913c.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913a5.89 5.89 0 0 0-1.384-2.126A5.847 5.847 0 0 0 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071c1.17.055 1.805.249 2.227.415c.562.217.96.477 1.382.896c.419.42.679.819.896 1.381c.164.422.36 1.057.413 2.227c.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227a3.81 3.81 0 0 1-.899 1.382a3.744 3.744 0 0 1-1.38.896c-.42.164-1.065.36-2.235.413c-1.274.057-1.649.07-4.859.07c-3.211 0-3.586-.015-4.859-.074c-1.171-.061-1.816-.256-2.236-.421a3.716 3.716 0 0 1-1.379-.899a3.644 3.644 0 0 1-.9-1.38c-.165-.42-.359-1.065-.42-2.235c-.045-1.26-.061-1.649-.061-4.844c0-3.196.016-3.586.061-4.861c.061-1.17.255-1.814.42-2.234c.21-.57.479-.96.9-1.381c.419-.419.81-.689 1.379-.898c.42-.166 1.051-.361 2.221-.421c1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678a6.162 6.162 0 1 0 0 12.324a6.162 6.162 0 1 0 0-12.324zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4s4 1.79 4 4s-1.79 4-4 4zm7.846-10.405a1.441 1.441 0 0 1-2.88 0a1.44 1.44 0 0 1 2.88 0z"/></svg>
                    </a>
                </div>
            </div>
            <div class="flex flex-col">
                <h3 class="text-[#06402b] text-xl font-bold mb-4 relative inline-block mx-auto md:mx-0">
                    Contact Us
                    <span class="absolute bottom-0 left-0 w-1/2 h-0.5 bg-yellow-500"></span>
                </h3>
                <div class="flex flex-row gap-x-1 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 100 100"><path fill="currentColor" d="M84.96 70.237c-.167-1.032-.814-1.914-1.783-2.438l-14.335-8.446l-.118-.066a4.256 4.256 0 0 0-1.937-.45c-1.201 0-2.348.455-3.144 1.253l-4.231 4.233c-.181.172-.771.421-.95.43c-.049-.004-4.923-.355-13.896-9.329c-8.957-8.955-9.337-13.844-9.34-13.844c.005-.25.251-.838.426-1.02l3.608-3.607c1.271-1.274 1.652-3.386.898-5.022L32.19 16.938c-.579-1.192-1.704-1.928-2.952-1.928c-.883 0-1.735.366-2.401 1.031l-9.835 9.813c-.943.938-1.755 2.578-1.932 3.898c-.086.631-1.831 15.693 18.819 36.346C51.42 83.627 65.09 84.989 68.865 84.989a10.7 10.7 0 0 0 1.376-.071c1.316-.176 2.954-.986 3.891-1.925l9.827-9.826c.802-.806 1.168-1.871 1.001-2.93z"/></svg>
                    <h3 class="hover:underline cursor-pointer hover:text-green-500">0912-345-6789</h3>
                </div>
            </div>
            <div class="flex flex-col">
                <h3 class="text-[#06402b] text-xl font-bold mb-4 relative inline-block mx-auto md:mx-0">
                    Feedback
                    <span class="absolute bottom-0 left-0 w-1/2 h-0.5 bg-yellow-500"></span>
                </h3>
                <div class="flex flex-row gap-x-2 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 432 384"><path fill="currentColor" d="M384 21q18 0 30.5 12.5T427 64v256q0 18-12.5 30.5T384 363H43q-18 0-30.5-12.5T0 320V64q0-18 12.5-30.5T43 21h341zm0 86V64L213 171L43 64v43l170 106z"/></svg>
                    <a href="" class="hover:text-green-500 hover:underline">aeroson@gmail.com</a>
                </div>
            </div>
        </div>
        <p class="text-gray-500 h-auto upppercase font-semibold border-t border-gray-400 w-[80%] text-center pt-7">© 2025 AeroSon. All rights reserved.</p>
    </footer>
</body>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const hamburgerBtn = document.getElementById('hamburger-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const overlay = document.getElementById('overlay');
        const closeBtn = document.getElementById('close-menu');

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