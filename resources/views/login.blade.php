<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('bglogo.png') }}" type="image/png">
    <link rel="icon" href="{{ asset('bglogo.png') }}" type="image/png">
    <title>Admin Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="w-screen h-screen flex justify-center items-center bg-gradient-to-b from-[#06402b] to-white">
    <div class="max-h-[400px] max-w-[400px] h-[73%] w-[80%] lg:w-[30%] border border-[#06402b] bg-white rounded-3xl shadow-md flex flex-col justify-center items-center gap-y-5">
        <div class="flex flex-col justify-center items-center gap-y-1 gap-x-3">
            <img src="{{ asset('bglogo.png') }}" alt="" class="size-24">
            <!-- <div class="border-2 border-[#06402b] h-[60%] rounded-xl"></div> -->
            <span class="uppercase text-[#06402b] font-extrabold text-3xl">ADMIN</span>
            <!-- <div class="border-2 border-[#06402b] w-[40%] rounded-xl"></div> -->
        </div>
        <form action="{{ route('login.post') }}" method="POST" class="w-full gap-y-3 flex justify-center items-center flex-col">
            @csrf
            <!-- User Input -->
            <div class="relative flex items-center w-[70%] justify-center">
                <!-- <img src="{{ asset('user.png') }}" alt="" class="absolute left-3 size-4"> -->
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute size-4 left-3" viewBox="0 0 24 24"><path fill="currentColor" d="M15.71 12.71a6 6 0 1 0-7.42 0a10 10 0 0 0-6.22 8.18a1 1 0 0 0 2 .22a8 8 0 0 1 15.9 0a1 1 0 0 0 1 .89h.11a1 1 0 0 0 .88-1.1a10 10 0 0 0-6.25-8.19ZM12 12a4 4 0 1 1 4-4a4 4 0 0 1-4 4Z"/></svg>
                <input type="text" name="username"
                    class="w-full h-9 px-9 border border-[#06402b] focus:outline-none focus:ring-0 rounded-lg font-semibold"
                    placeholder="Username" required>
            </div>
            <!-- Password Input -->
            <div class="relative flex items-center w-[70%] justify-center">
                <!-- <img src="{{ asset('password.png') }}" alt="" class="absolute left-3 size-4"> -->
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute size-4 left-3" viewBox="0 0 24 24"><path fill="currentColor" d="M17 9V7A5 5 0 0 0 7 7v2a3 3 0 0 0-3 3v7a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-7a3 3 0 0 0-3-3ZM9 7a3 3 0 0 1 6 0v2H9Zm9 12a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-7a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1Z"/></svg>
                <input type="password" name="password"
                    class="w-full h-9 pl-9 pr-3 border border-[#06402b] focus:outline-none focus:ring-0 rounded-lg font-semibold"
                    placeholder="Password" required>
            </div>
            <div class="relative flex flex-col items-center gap-y-6 justify-center w-[70%]">
                <button
                    class="bg-[#06402b] w-full text-white font-bold h-9 flex justify-center items-center rounded-lg px-9 cursor-pointer">
                    Log In
                </button>
                <a href="{{ route('dashboard') }}" class=" hover:text-[#06402b] duration-300 text-xs text-gray-400">Back to
                    Dashboard</a>
            </div>
        </form>
    </div>
    <!-- Show error -->
    @if(session('error'))
        <div x-data="{ show: true }" 
            x-show="show"
            x-transition:enter="transform transition ease-out duration-500"
            x-transition:enter-start="translate-y-10 opacity-0"
            x-transition:enter-end="translate-y-0 opacity-100"
            x-transition:leave="transform transition ease-in duration-500"
            x-transition:leave-start="translate-y-0 opacity-100"
            x-transition:leave-end="translate-x-20 opacity-0"
            x-init="setTimeout(() => show = false, 3000)"
            class="fixed top-2 right-2 w-auto p-3 bg-white border-l-8 border-red-600 rounded-md flex flex-row items-center justify-center gap-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-red-600" viewBox="0 0 20 20"><path fill="currentColor" d="M10 2c4.42 0 8 3.58 8 8s-3.58 8-8 8s-8-3.58-8-8s3.58-8 8-8zm1.13 9.38l.35-6.46H8.52l.35 6.46h2.26zm-.09 3.36c.24-.23.37-.55.37-.96c0-.42-.12-.74-.36-.97s-.59-.35-1.06-.35s-.82.12-1.07.35s-.37.55-.37.97c0 .41.13.73.38.96c.26.23.61.34 1.06.34s.8-.11 1.05-.34z"/></svg>
            <span class="text-red-600 text-xs font-semibold uppercase">{{ session('error') }}</span>
            <div class="absolute bottom-0 left-0 h-1 bg-red-600"
                x-init="$el.style.width = '0%';
                        setTimeout(() => $el.style.width = '100%', 10);
                        $el.style.transition = 'width 3s linear';">
            </div>
        </div>
    @endif
</body>
</html>