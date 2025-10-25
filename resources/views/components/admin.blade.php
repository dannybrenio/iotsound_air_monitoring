<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('bglogo.png') }}" type="image/png">
    <link rel="icon" href="{{ asset('bglogo.png') }}" type="image/png">
    <title>
        ADMIN
    </title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Sidebar Slide (Fix: Left to Right) - ONLY APPLY ON MOBILE */
        @media (max-width: 1023px) {
            #mobile-menu {
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
            }
            
            #mobile-menu.active {
                transform: translateX(0);
            }
        }
        
        /* Hamburger Animation */
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
        
        /* Overlay */
        #overlay {
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease-in-out;
        }
        
        #overlay.active {
            opacity: 1;
            visibility: visible;
        }
    </style>

</head>

<body>
    <!-- Mobile Navbar -->
    <div class="lg:hidden fixed top-4 left-4 z-30">
        <button id="hamburger-btn"
            class="hamburger flex flex-col justify-center items-center p-2 text-white rounded w-8 h-8 space-y-1 focus:outline-none">
            <span class="hamburger-line line1 block w-6 h-0.5 bg-[#06402b]"></span>
            <span class="hamburger-line line2 block w-6 h-0.5 bg-[#06402b]"></span>
            <span class="hamburger-line line3 block w-6 h-0.5 bg-[#06402b]"></span>
        </button>
    </div>
    <!-- Sidebar -->
    <div id="mobile-menu" class="bg-white fixed h-screen w-[50%] lg:w-[20%] flex flex-col justify-start items-center py-6 gap-y-5 
        shadow-[2px_0_15px_-5px_rgba(0,0,0,0.3)] z-40">
        <!-- Add Close Button Here -->
        <button id="close-menu" class="absolute top-5 right-4 text-gray-700 text-4xl lg:hidden">&times;</button>
        <div class="flex flex-row justify-start items-center gap-x-3 w-[85%]">
            <img src="{{ asset('bglogo.png') }}" alt="" class="size-7">
            <span class="text-[#06402b] font-extrabold text-2xl">ADMIN</span>
        </div>
        <div class="rounded border border-[#06402b] w-[85%]"></div>
        <div class="flex flex-col w-[85%] justify-center items-start gap-y-2 ">
            <a href="{{ route('hardware') }}"
                class="flex flex-row gap-x-3 justify-center items-center text-lg h-10
                        {{ request()->routeIs('hardware') ? 'text-white  duration-300 bg-[#06402b] font-semibold w-full rounded justify-start px-2' : 'text-[#06402b] font-semibold hover:text-black hover:bg-[#a9b3da] w-full rounded flex justify-start duration-300 px-2' }}">
                <svg fill="currentColor" class="size-5" viewBox="0 0 15 15" version="1.1" id="hardware"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M13.7919,3.2619c0,0-1.676,1.675-2.1163,2.1208c-0.085,0.0861-0.1688,0.1135-0.282,0.0961&#xA;&#x9;c-0.1481-0.0226-0.2974-0.038-0.4462-0.0558c-0.4072-0.0485-0.8145-0.0966-1.2292-0.1458C9.649,4.6852,9.5787,4.1049,9.5177,3.5236&#xA;&#x9;C9.512,3.4689,9.5509,3.3943,9.5925,3.3522c0.5071-0.5134,1.9261-1.9287,2.134-2.136c-0.4508-0.2129-1.2243-0.2968-1.8007-0.2031&#xA;&#x9;c-2.1801,0.3543-3.5112,2.534-2.8206,4.625C7.1432,5.753,7.1194,5.8201,7.0374,5.902C5.1891,7.7454,3.3436,9.5914,1.498,11.4374&#xA;&#x9;c-0.0616,0.0616-0.1231,0.124-0.1779,0.1913c-0.5264,0.6473-0.3873,1.6264,0.2974,2.102c0.6044,0.4197,1.3658,0.3442,1.9053-0.1948&#xA;&#x9;c1.8534-1.8519,3.7059-3.7047,5.556-5.5598C9.1707,7.884,9.2437,7.8526,9.3779,7.8983c0.6189,0.2109,1.2524,0.2354,1.8884,0.0884&#xA;&#x9;c1.9386-0.4478,3.1251-2.3732,2.6549-4.3034C13.8895,3.5532,13.843,3.4244,13.7919,3.2619z" />
                </svg>
                Hardware
            </a>
            <a href="{{ route('hardwareData') }}"
                class="flex flex-row gap-x-3 justify-center items-center text-lg h-10
                        {{ request()->routeIs('hardwareData') ? 'text-white  duration-300 bg-[#06402b] font-semibold w-full rounded justify-start px-2' : 'text-[#06402b] font-semibold hover:text-black hover:bg-[#a9b3da] w-full rounded flex justify-start duration-300 px-2' }}">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="System / Data">
                        <path id="Vector"
                            d="M18 12V17C18 18.6569 15.3137 20 12 20C8.68629 20 6 18.6569 6 17V12M18 12V7M18 12C18 13.6569 15.3137 15 12 15C8.68629 15 6 13.6569 6 12M18 7C18 5.34315 15.3137 4 12 4C8.68629 4 6 5.34315 6 7M18 7C18 8.65685 15.3137 10 12 10C8.68629 10 6 8.65685 6 7M6 12V7"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </g>
                </svg>
                Hardware Data
            </a>
            <a href="{{ route('pendingHardware') }}"
                class="flex flex-row gap-x-3 justify-center items-center text-lg h-10
                        {{ request()->routeIs('pendingHardware') ? 'text-white  duration-300 bg-[#06402b] font-semibold w-full rounded justify-start px-2' : 'text-[#06402b] font-semibold hover:text-black hover:bg-[#a9b3da] w-full rounded flex justify-start duration-300 px-2' }}">
                <svg fill="currentColor" class="size-5" viewBox="0 0 32 32" id="icon"
                    xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <style>
                            .cls-1 {
                                fill: none;
                            }
                        </style>
                    </defs>
                    <circle cx="9" cy="16" r="2" />
                    <circle cx="23" cy="16" r="2" />
                    <circle cx="16" cy="16" r="2" />
                    <path
                        d="M16,30A14,14,0,1,1,30,16,14.0158,14.0158,0,0,1,16,30ZM16,4A12,12,0,1,0,28,16,12.0137,12.0137,0,0,0,16,4Z"
                        transform="translate(0 0)" />
                </svg>
                Pending Hardware
            </a>
            <a href="{{ route('pendingData') }}"
                class="flex flex-row gap-x-3 justify-center items-center text-lg h-10
                        {{ request()->routeIs('pendingData') ? 'text-white  duration-300 bg-[#06402b] font-semibold w-full rounded justify-start px-2' : 'text-[#06402b] font-semibold hover:text-black hover:bg-[#a9b3da] w-full rounded flex justify-start duration-300 px-2' }}">
                <svg class="size-5" viewBox="0 0 1024 1024" class="icon" version="1.1"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M511.9 183c-181.8 0-329.1 147.4-329.1 329.1s147.4 329.1 329.1 329.1c181.8 0 329.1-147.4 329.1-329.1S693.6 183 511.9 183z m0 585.2c-141.2 0-256-114.8-256-256s114.8-256 256-256 256 114.8 256 256-114.9 256-256 256z"
                        fill="currentColor" />
                    <path d="M548.6 365.7h-73.2v161.4l120.5 120.5 51.7-51.7-99-99z" fill="currentColor" />
                </svg>
                Pending Data
            </a>
            <a href="{{ route('report') }}"
                class="flex flex-row gap-x-3 justify-center items-center text-lg h-10
                        {{ request()->routeIs('report') ? 'text-white  duration-300 bg-[#06402b] font-semibold w-full rounded justify-start px-2' : 'text-[#06402b] font-semibold hover:text-black hover:bg-[#a9b3da] w-full rounded flex justify-start duration-300 px-2' }}">
                <svg fill="currentColor" class="size-5" viewBox="0 0 32 32"
                    style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;" version="1.1"
                    xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:serif="http://www.serif.com/"
                    xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g id="Layer1">
                        <path
                            d="M27,3c-0,-0.552 -0.448,-1 -1,-1l-20,0c-0.552,0 -1,0.448 -1,1l-0,26c0,0.552 0.448,1 1,1l20,0c0.552,0 1,-0.448 1,-1l-0,-26Zm-2,1l-0,24c-0,0 -18,0 -18,0c-0,-0 -0,-24 -0,-24l18,0Zm-9,10c-3.311,0 -6,2.689 -6,6c-0,3.311 2.689,6 6,6c3.311,0 6,-2.689 6,-6c-0,-3.311 -2.689,-6 -6,-6Zm-1,2.126c-1.724,0.445 -3,2.012 -3,3.874c-0,2.208 1.792,4 4,4c1.862,0 3.429,-1.276 3.874,-3l-3.874,0c-0.552,0 -1,-0.448 -1,-1l0,-3.874Zm-2,-4.126l6,0c0.552,0 1,-0.448 1,-1c0,-0.552 -0.448,-1 -1,-1l-6,0c-0.552,0 -1,0.448 -1,1c0,0.552 0.448,1 1,1Zm-2,-4l10,0c0.552,0 1,-0.448 1,-1c0,-0.552 -0.448,-1 -1,-1l-10,0c-0.552,0 -1,0.448 -1,1c0,0.552 0.448,1 1,1Z" />
                    </g>
                </svg>
                Reports
            </a>
            <a href="{{ route('account') }}"
                class="flex flex-row gap-x-3 justify-center items-center text-lg h-10
                        {{ request()->routeIs('account') ? 'text-white  duration-300 bg-[#06402b] font-semibold w-full rounded justify-start px-2' : 'text-[#06402b] font-semibold hover:text-black hover:bg-[#a9b3da] w-full rounded flex justify-start duration-300 px-2' }}">
                <svg class="size-5" viewBox="0 0 24 24" id="Layer_1" data-name="Layer 1"
                    xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <style>
                            .cls-1 {
                                fill: none;
                                stroke: currentColor;
                                stroke-miterlimit: 10;
                                stroke-width: 1.91px;
                            }
                        </style>
                    </defs>
                    <circle class="cls-1" cx="12" cy="7.25" r="5.73" />
                    <path class="cls-1"
                        d="M1.5,23.48l.37-2.05A10.3,10.3,0,0,1,12,13h0a10.3,10.3,0,0,1,10.13,8.45l.37,2.05" />
                </svg>
                Accounts
            </a>
            <a href="{{ route('alert') }}"
                class="flex flex-row gap-x-3 justify-center items-center text-lg h-10
                        {{ request()->routeIs('alert') ? 'text-white  duration-300 bg-[#06402b] font-semibold w-full rounded justify-start px-2' : 'text-[#06402b] font-semibold hover:text-black hover:bg-[#a9b3da] w-full rounded flex justify-start duration-300 px-2' }}">
                <svg class="size-5" viewBox="-1 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                    <title>alert</title>
                    <desc>Created with Sketch Beta.</desc>
                    <defs>
                    </defs>
                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                        <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-362.000000, -880.000000)"
                            fill="currentColor">
                            <path
                                d="M365,904 L368,898 L368,890 C368,885.582 371.582,882 376,882 C380.418,882 384,885.582 384,890 L384,898 L387,904 L365,904 L365,904 Z M376,908 C374.695,908 373.597,907.163 373.184,906 L378.816,906 C378.403,907.163 377.305,908 376,908 L376,908 Z M386,898 L386,890 C386,884.478 381.522,880 376,880 C370.478,880 366,884.478 366,890 L366,898 L362,906 L371.101,906 C371.564,908.282 373.581,910 376,910 C378.419,910 380.436,908.282 380.899,906 L390,906 L386,898 L386,898 Z"
                                id="alert" sketch:type="MSShapeGroup">
                            </path>
                        </g>
                    </g>
                </svg>
                Alerts
            </a>
            <a href="{{ route('login') }}"
                class="px-2.5 text-[#06402b] text-lg flex flex-row gap-x-3 items-center font-semibold hover:text-black hover:bg-[#a9b3da] w-full h-10 rounded justify-start duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24" fill="currentColor">
                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2">
                        <path d="M14 8V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2v-2" />
                        <path d="M9 12h12l-3-3m0 6l3-3" />
                    </g>
                </svg>
                Logout
            </a>
        </div>
    </div>
    <main class="lg:pl-[20%] pl-0">
        <div class="px-4 py-8">
            {{ $slot }}
        </div>
    </main>
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

        // Close menu when X (close button) clicked
        closeBtn.addEventListener('click', () => {
            hamburgerBtn.classList.remove('active');
            mobileMenu.classList.remove('active');
            overlay.classList.remove('active');
        });
    });
</script>


</html>