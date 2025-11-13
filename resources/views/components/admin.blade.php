@props(['notifs' => null])

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('bglogo.png') }}" type="image/png">
    <link rel="icon" href="{{ asset('bglogo.png') }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        AeroSon Admin
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
            class="hamburger flex flex-col justify-center items-center p-2 text-white rounded w-8 h-10 space-y-1 focus:outline-none cursor-pointer">
            <span class="hamburger-line line1 block w-6 h-0.5 bg-[#06402b]"></span>
            <span class="hamburger-line line2 block w-6 h-0.5 bg-[#06402b]"></span>
            <span class="hamburger-line line3 block w-6 h-0.5 bg-[#06402b]"></span>
        </button>
    </div>
    <!-- ADD THIS OVERLAY DIV -->
    <div id="overlay" class="fixed inset-0 bg-black/90 bg-opacity-50 z-30 lg:hidden"></div>
    <!-- Sidebar -->
    <div id="mobile-menu" class="bg-[#E0EBDC] fixed h-screen w-[80%] lg:w-[20%] flex flex-col justify-between items-center py-6 gap-y-5 
        shadow-[0px_0_15px_1px_rgba(0,0,0,0.3)] z-40">
        <!-- Add Close Button Here -->
        <button id="close-menu" class="absolute top-5 right-4 text-gray-700 text-4xl lg:hidden cursor-pointer">&times;</button>
        <div class="flex flex-row justify-start items-center gap-x-2 w-[85%]">
            <img src="{{ asset('bglogo.png') }}" alt="" class="size-8">
            <span class="text-[#06402b] font-extrabold text-xl">AEROSON</span>
        </div>
        <!-- <div class="rounded border border-[#06402b] w-[85%]"></div> -->
        <div class="flex flex-col w-[85%] justify-start h-full items-start gap-y-1">
            <div class="flex items-center w-full justify-center">
                <span class="text-lg text-[#06402b] uppercase mb-2 font-bold">Admin Panel</span>
            </div>
            <a href="{{ route('hardware') }}"
                class="flex flex-row gap-x-3 justify-center items-center text-sm truncate h-10
                        {{ request()->routeIs('hardware') ? 'text-white  duration-300 bg-[#06402b] font-semibold w-full rounded justify-start px-2' : 'text-[#06402b] font-semibold hover:text-black hover:bg-[#a9b3da] w-full rounded flex justify-start duration-300 px-2' }}">
                <svg fill="currentColor" class="size-5" viewBox="0 0 15 15" version="1.1" id="hardware"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M13.7919,3.2619c0,0-1.676,1.675-2.1163,2.1208c-0.085,0.0861-0.1688,0.1135-0.282,0.0961&#xA;&#x9;c-0.1481-0.0226-0.2974-0.038-0.4462-0.0558c-0.4072-0.0485-0.8145-0.0966-1.2292-0.1458C9.649,4.6852,9.5787,4.1049,9.5177,3.5236&#xA;&#x9;C9.512,3.4689,9.5509,3.3943,9.5925,3.3522c0.5071-0.5134,1.9261-1.9287,2.134-2.136c-0.4508-0.2129-1.2243-0.2968-1.8007-0.2031&#xA;&#x9;c-2.1801,0.3543-3.5112,2.534-2.8206,4.625C7.1432,5.753,7.1194,5.8201,7.0374,5.902C5.1891,7.7454,3.3436,9.5914,1.498,11.4374&#xA;&#x9;c-0.0616,0.0616-0.1231,0.124-0.1779,0.1913c-0.5264,0.6473-0.3873,1.6264,0.2974,2.102c0.6044,0.4197,1.3658,0.3442,1.9053-0.1948&#xA;&#x9;c1.8534-1.8519,3.7059-3.7047,5.556-5.5598C9.1707,7.884,9.2437,7.8526,9.3779,7.8983c0.6189,0.2109,1.2524,0.2354,1.8884,0.0884&#xA;&#x9;c1.9386-0.4478,3.1251-2.3732,2.6549-4.3034C13.8895,3.5532,13.843,3.4244,13.7919,3.2619z" />
                </svg>
                Hardware
            </a>
            <a href="{{ route('hardwareData') }}"
                class="flex flex-row gap-x-3 justify-center items-center text-sm truncate h-10
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
                class="flex flex-row gap-x-3 justify-center items-center text-sm truncate h-10
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
                class="flex flex-row gap-x-3 justify-center items-center text-sm truncate h-10
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
            <a href="{{ route('device') }}"
                class="flex flex-row gap-x-3 justify-center items-center text-sm truncate h-10
                        {{ request()->routeIs('device') ? 'text-white  duration-300 bg-[#06402b] font-semibold w-full rounded justify-start px-2' : 'text-[#06402b] font-semibold hover:text-black hover:bg-[#a9b3da] w-full rounded flex justify-start duration-300 px-2' }}">
                <svg class="size-5" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="currentColor" clip-rule="currentColor" d="M1 4.85714C1 3.21069 2.41423 2 4 2H20C21.5858 2 23 3.21069 23 4.85714V14.1429C23 15.7893 21.5858 17 20 17H13V20H16.5C17.0523 20 17.5 20.4477 17.5 21C17.5 21.5523 17.0523 22 16.5 22H7.5C6.94772 22 6.5 21.5523 6.5 21C6.5 20.4477 6.94772 20 7.5 20H11V17H4C2.41423 17 1 15.7893 1 14.1429V4.85714ZM4 4C3.37663 4 3 4.45225 3 4.85714V14.1429C3 14.5477 3.37663 15 4 15H20C20.6234 15 21 14.5477 21 14.1429V4.85714C21 4.45225 20.6234 4 20 4H4Z" fill="currentColor"/>
                </svg>
                Device Status
            </a>
            <a href="{{ route('history') }}"
                class="flex flex-row gap-x-3 justify-center items-center text-sm truncate h-10
                        {{ request()->routeIs('history') ? 'text-white  duration-300 bg-[#06402b] font-semibold w-full rounded justify-start px-2' : 'text-[#06402b] font-semibold hover:text-black hover:bg-[#a9b3da] w-full rounded flex justify-start duration-300 px-2' }}">
                <svg class="size-5" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 5.67541V3C3 2.44772 2.55228 2 2 2C1.44772 2 1 2.44772 1 3V7C1 8.10457 1.89543 9 3 9H7C7.55229 9 8 8.55229 8 8C8 7.44772 7.55229 7 7 7H4.52186C4.54218 6.97505 4.56157 6.94914 4.57995 6.92229C5.621 5.40094 7.11009 4.22911 8.85191 3.57803C10.9074 2.80968 13.173 2.8196 15.2217 3.6059C17.2704 4.3922 18.9608 5.90061 19.9745 7.8469C20.9881 9.79319 21.2549 12.043 20.7247 14.1724C20.1945 16.3018 18.9039 18.1638 17.0959 19.4075C15.288 20.6513 13.0876 21.1909 10.9094 20.9247C8.73119 20.6586 6.72551 19.605 5.27028 17.9625C4.03713 16.5706 3.27139 14.8374 3.06527 13.0055C3.00352 12.4566 2.55674 12.0079 2.00446 12.0084C1.45217 12.0088 0.995668 12.4579 1.04626 13.0078C1.25994 15.3309 2.2082 17.5356 3.76666 19.2946C5.54703 21.3041 8.00084 22.5931 10.6657 22.9188C13.3306 23.2444 16.0226 22.5842 18.2345 21.0626C20.4464 19.541 22.0254 17.263 22.6741 14.6578C23.3228 12.0526 22.9963 9.30013 21.7562 6.91897C20.5161 4.53782 18.448 2.69239 15.9415 1.73041C13.4351 0.768419 10.6633 0.756291 8.14853 1.69631C6.06062 2.47676 4.26953 3.86881 3 5.67541Z" fill="currentColor"/>
                    <path d="M12 5C11.4477 5 11 5.44771 11 6V12.4667C11 12.4667 11 12.7274 11.1267 12.9235C11.2115 13.0898 11.3437 13.2344 11.5174 13.3346L16.1372 16.0019C16.6155 16.278 17.2271 16.1141 17.5032 15.6358C17.7793 15.1575 17.6155 14.546 17.1372 14.2698L13 11.8812V6C13 5.44772 12.5523 5 12 5Z" fill="currentColor"/>
                </svg>
                History Status
            </a>
            <a href="{{ route('report') }}"
                class="flex flex-row gap-x-3 justify-center items-center text-sm truncate h-10
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
                class="flex flex-row gap-x-3 justify-center items-center text-sm truncate h-10
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
                class="flex flex-row gap-x-3 justify-center items-center text-sm truncate h-10
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
        </div>
        <div class="w-full flex flex-col justify-center items-center gap-y-2">
            <div class="rounded border border-[#06402b] w-[80%]"></div>
            <a href="{{ route('logout') }}"
                class="px-2.5 text-[#FFF] text-sm flex flex-row gap-x-1 bg-[#06402b] items-center font-semibold hover:text-[#06402b] hover:bg-[#a9b3da] w-[80%] h-10 rounded justify-center duration-300">
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
        <div class="px-4 py-6">
            {{ $slot }}
        </div>
        <div x-data="{ open: false }" class="fixed right-5 top-5">
            <!-- Notification Button -->
            <button 
                @click="open = !open"
                class="flex items-center justify-center h-10 w-10 bg-[#06402b] rounded-full text-white hover:bg-[#06402b]/80 duration-300 relative focus:bg-white focus:text-[#06402b] focus:ring-2 focus:ring-[#06402b]"
            >
                <svg class="size-8" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.7258 7.34056C12.1397 7.32632 12.4638 6.97919 12.4495 6.56522C12.4353 6.15125 12.0882 5.8272 11.6742 5.84144L11.7258 7.34056ZM7.15843 11.562L6.40879 11.585C6.40906 11.5938 6.40948 11.6026 6.41006 11.6114L7.15843 11.562ZM5.87826 14.979L6.36787 15.5471C6.38128 15.5356 6.39428 15.5236 6.40684 15.5111L5.87826 14.979ZM5.43951 15.342L5.88007 15.949C5.89245 15.94 5.90455 15.9306 5.91636 15.9209L5.43951 15.342ZM9.74998 17.75C10.1642 17.75 10.5 17.4142 10.5 17C10.5 16.5858 10.1642 16.25 9.74998 16.25V17.75ZM11.7258 5.84144C11.3118 5.8272 10.9647 6.15125 10.9504 6.56522C10.9362 6.97919 11.2602 7.32632 11.6742 7.34056L11.7258 5.84144ZM16.2415 11.562L16.9899 11.6113C16.9905 11.6025 16.9909 11.5938 16.9912 11.585L16.2415 11.562ZM17.5217 14.978L16.9931 15.5101C17.0057 15.5225 17.0187 15.5346 17.0321 15.5461L17.5217 14.978ZM17.9605 15.341L17.4836 15.9199C17.4952 15.9294 17.507 15.9386 17.5191 15.9474L17.9605 15.341ZM13.65 16.25C13.2358 16.25 12.9 16.5858 12.9 17C12.9 17.4142 13.2358 17.75 13.65 17.75V16.25ZM10.95 6.591C10.95 7.00521 11.2858 7.341 11.7 7.341C12.1142 7.341 12.45 7.00521 12.45 6.591H10.95ZM12.45 5C12.45 4.58579 12.1142 4.25 11.7 4.25C11.2858 4.25 10.95 4.58579 10.95 5H12.45ZM9.74998 16.25C9.33577 16.25 8.99998 16.5858 8.99998 17C8.99998 17.4142 9.33577 17.75 9.74998 17.75V16.25ZM13.65 17.75C14.0642 17.75 14.4 17.4142 14.4 17C14.4 16.5858 14.0642 16.25 13.65 16.25V17.75ZM10.5 17C10.5 16.5858 10.1642 16.25 9.74998 16.25C9.33577 16.25 8.99998 16.5858 8.99998 17H10.5ZM14.4 17C14.4 16.5858 14.0642 16.25 13.65 16.25C13.2358 16.25 12.9 16.5858 12.9 17H14.4ZM11.6742 5.84144C8.65236 5.94538 6.31509 8.53201 6.40879 11.585L7.90808 11.539C7.83863 9.27613 9.56498 7.41488 11.7258 7.34056L11.6742 5.84144ZM6.41006 11.6114C6.48029 12.6748 6.08967 13.7118 5.34968 14.4469L6.40684 15.5111C7.45921 14.4656 8.00521 13.0026 7.9068 11.5126L6.41006 11.6114ZM5.38865 14.4109C5.23196 14.5459 5.10026 14.6498 4.96265 14.7631L5.91636 15.9209C6.0264 15.8302 6.195 15.6961 6.36787 15.5471L5.38865 14.4109ZM4.99895 14.735C4.77969 14.8942 4.58045 15.1216 4.43193 15.3617C4.28525 15.5987 4.14491 15.9178 4.12693 16.2708C4.10726 16.6569 4.24026 17.0863 4.63537 17.3884C4.98885 17.6588 5.45464 17.75 5.94748 17.75V16.25C5.78415 16.25 5.67611 16.234 5.60983 16.2171C5.54411 16.2004 5.53242 16.1861 5.54658 16.1969C5.56492 16.211 5.59211 16.2408 5.61004 16.2837C5.62632 16.3228 5.62492 16.3484 5.62499 16.3472C5.62513 16.3443 5.62712 16.3233 5.6414 16.2839C5.65535 16.2454 5.67733 16.1997 5.70749 16.151C5.73748 16.1025 5.77159 16.0574 5.80538 16.0198C5.84013 15.981 5.86714 15.9583 5.88007 15.949L4.99895 14.735ZM5.94748 17.75H9.74998V16.25H5.94748V17.75ZM11.6742 7.34056C13.835 7.41488 15.5613 9.27613 15.4919 11.539L16.9912 11.585C17.0849 8.53201 14.7476 5.94538 11.7258 5.84144L11.6742 7.34056ZM15.4932 11.5127C15.3951 13.0024 15.9411 14.4649 16.9931 15.5101L18.0503 14.4459C17.3105 13.711 16.9199 12.6744 16.9899 11.6113L15.4932 11.5127ZM17.0321 15.5461C17.205 15.6951 17.3736 15.8292 17.4836 15.9199L18.4373 14.7621C18.2997 14.6488 18.168 14.5449 18.0113 14.4099L17.0321 15.5461ZM17.5191 15.9474C17.5325 15.9571 17.5599 15.9802 17.5949 16.0193C17.629 16.0573 17.6634 16.1026 17.6937 16.1514C17.7241 16.2004 17.7463 16.2463 17.7604 16.285C17.7748 16.3246 17.7769 16.3457 17.777 16.3485C17.7771 16.3497 17.7756 16.3238 17.792 16.2844C17.81 16.241 17.8375 16.211 17.856 16.1968C17.8702 16.1859 17.8585 16.2002 17.7925 16.217C17.7259 16.234 17.6174 16.25 17.4535 16.25V17.75C17.9468 17.75 18.4132 17.6589 18.7669 17.3885C19.1628 17.0859 19.2954 16.6557 19.2749 16.2693C19.2562 15.9161 19.1151 15.5972 18.9682 15.3604C18.8194 15.1206 18.6202 14.8936 18.4018 14.7346L17.5191 15.9474ZM17.4535 16.25H13.65V17.75H17.4535V16.25ZM12.45 6.591V5H10.95V6.591H12.45ZM9.74998 17.75H13.65V16.25H9.74998V17.75ZM8.99998 17C8.99998 18.5008 10.191 19.75 11.7 19.75V18.25C11.055 18.25 10.5 17.7084 10.5 17H8.99998ZM11.7 19.75C13.2089 19.75 14.4 18.5008 14.4 17H12.9C12.9 17.7084 12.3449 18.25 11.7 18.25V19.75Z" fill="currentColor"/>
                </svg>

                <!-- Badge -->
                {{-- Display the number of unread messages --}}
                <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-semibold rounded-full px-1.5 py-0.5">{{ count($notifs) }}</span>
            </button>
            
            <!-- Notification Modal -->
            <div 
                x-show="open"
                @click.outside="open = false"
                x-transition
                class="absolute right-0 w-80 bg-white shadow-lg rounded-lg border border-gray-200 mt-0.5"
            >
                <div class="flex items-center justify-between p-3 border-b bg-[#06402b] text-white rounded-t-lg">
                    <span class="font-semibold">Notifications</span>
                    <!-- <button @click="open = false" class="text-sm">✕</button> -->
                </div>
                
                <div id="notifList" class="max-h-120 overflow-y-auto p-3 space-y-2">
                    @forelse($notifs as $notif)
                        <div
                        class="p-2 rounded-md border border-gray-200 hover:bg-gray-100 cursor-pointer"
                        data-history-id="{{ $notif->history_id }}"   {{-- hidden identifier --}}
                        data-is-read="{{ (int) $notif->isRead }}"
                        >
                        <p class="text-sm text-gray-800">
                            Notification message:
                            <span>{{ $notif->sensor_type }} is {{ $notif->sensor_status }}</span>
                        </p>
                        <p class="text-xs text-gray-500">{{ $notif->created_at->diffForHumans() }}</p>
                        </div>
                    @empty
                        <div class="py-4 text-gray-500" data-empty>No unread notifications.</div>
                    @endforelse
                </div>

            </div>
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

        // Turn an ISO/time-like value into "x minutes ago"
        function relativeTimeFrom(dateInput) {
            try {
                const d = (dateInput instanceof Date) ? dateInput : new Date(dateInput);
                const diffMs = d.getTime() - Date.now();
                const abs = Math.abs(diffMs);
                const rtf = new Intl.RelativeTimeFormat(undefined, { numeric: 'auto' });

                const sec = Math.round(diffMs / 1000);
                const min = Math.round(diffMs / (1000 * 60));
                const hr  = Math.round(diffMs / (1000 * 60 * 60));
                const day = Math.round(diffMs / (1000 * 60 * 60 * 24));

                if (abs < 60 * 1000) return rtf.format(sec, 'second');
                if (abs < 60 * 60 * 1000) return rtf.format(min, 'minute');
                if (abs < 24 * 60 * 60 * 1000) return rtf.format(hr, 'hour');
                return rtf.format(day, 'day');
            } catch {
                return typeof dateInput === 'string' ? dateInput : new Date().toLocaleString();
            }
        }

        function extractNotifPayload(evt) {
        const raw = evt && typeof evt === 'object' ? evt : {};
        const p = raw.payload && typeof raw.payload === 'object' ? raw.payload : raw;
        return {
            sensor_status: p.sensor_status ?? p.status ?? 'Unknown status',
            sensor_type:   p.sensor_type   ?? 'Unknown sensor',
            created_at:    p.created_at    ?? new Date().toISOString(),
        };
        }

        function buildNotifCard({ sensor_status, created_at, sensor_type }) {
        const wrapper = document.createElement('div');
        wrapper.className = 'p-2 rounded-md border border-gray-200 hover:bg-gray-100 cursor-pointer';

        const p1 = document.createElement('p');
        p1.className = 'text-sm text-gray-800';
        p1.textContent = 'Notification message: ';
        const msg = document.createElement('span');
        msg.textContent = sensor_type + " is " + sensor_status;
        p1.appendChild(msg);

        const p2 = document.createElement('p');
        p2.className = 'text-xs text-gray-500';
        p2.textContent = relativeTimeFrom(created_at);

        wrapper.appendChild(p1);
        wrapper.appendChild(p2);
        return wrapper;
        }

        function prependNotifCard(card, { maxItems = 100 } = {}) {
        const list = document.getElementById('notifList');
        if (!list) return;
        const emptyNode = list.querySelector('[data-empty]');
        if (emptyNode) emptyNode.remove();
        list.insertBefore(card, list.firstChild);

        const cards = [...list.children].filter(el => !el.hasAttribute('data-empty'));
        if (cards.length > maxItems) {
            for (let i = maxItems; i < cards.length; i++) cards[i].remove();
        }
        }

        // --- Echo subscription (PUBLIC channel) ---
        (function subscribeToNotifications() {
        if (!window.Echo) {
            console.warn('Echo is not available. Skipping notif subscription.');
            return;
        }

        const handler = (evt) => {
            const payload = extractNotifPayload(evt);
            const card = buildNotifCard(payload);
            prependNotifCard(card, { maxItems: 100 });
        };

        // If you used broadcastAs(): return 'NotificationReceived' → dot form
        window.Echo.channel('notif-received')
            .listen('.NotificationReceived', handler)     // with broadcastAs()
            .listen('NotificationReceived', handler);     // without broadcastAs()
        })();

        (function () {
            const list = document.getElementById('notifList');
            if (!list) return;

            const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '';
            const REDIRECT_URL = 'https://aeroson-monitoring.com/admin_history_status'; // <- target page

            async function markRead(historyId) {
                // If you named the route, you can use @json(route('notifications.markRead')) instead
                const url = '{{ route('notifications.markRead') }}';
                const res = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ history_id: historyId }),
                });
                if (!res.ok) throw new Error('HTTP ' + res.status);
                return res.json();
            }

            list.addEventListener('click', async (e) => {
                const card = e.target.closest('[data-history-id]');
                if (!card) return;

                // prevent double submits
                if (card.dataset.busy === '1') return;
                card.dataset.busy = '1';

                const historyId = card.getAttribute('data-history-id');

                // slight visual feedback
                card.style.opacity = '0.6';

                try {
                await markRead(historyId);
                // success → go to admin page
                window.location.href = REDIRECT_URL;
                } catch (err) {
                console.error('markRead failed:', err);
                // still redirect so the user reaches the page
                window.location.href = REDIRECT_URL;
                }
            });
        })();
    });
</script>


</html>