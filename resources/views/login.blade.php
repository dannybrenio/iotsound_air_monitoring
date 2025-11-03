<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('bglogo.png') }}" type="image/png">
    <link rel="icon" href="{{ asset('bglogo.png') }}" type="image/png">
    <title>LOGIN</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="w-screen h-screen flex justify-center items-center bg-gradient-to-b from-[#06402b] to-white">
    <div
        class="max-h-[350px] h-[60%] w-[80%] md:w-[60%] lg:w-[30%] border border-[#06402b] bg-white rounded-3xl shadow-md flex flex-col justify-center items-center gap-y-5">
        <div class="flex flex-col justify-center items-center gap-y-1">
            <span class="uppercase text-[#06402b] font-extrabold text-3xl">ADMIN</span>
            <div class="border-2 border-[#06402b] w-[60%] rounded-xl"></div>
        </div>
        <form action="{{ route('login.post') }}" method="POST" class="w-full gap-y-3 flex justify-center items-center flex-col">
            @csrf
            <!-- User Input -->
            <div class="relative flex items-center w-[70%] justify-center">
                <img src="{{ asset('user.png') }}" alt="" class="absolute left-3 size-4">
                <input type="text" name="username"
                    class="w-full h-10 px-9 border border-[#06402b] focus:outline-none focus:ring-0 rounded-lg font-semibold"
                    placeholder="Username" required>
            </div>
            <!-- Password Input -->
            <div class="relative flex items-center w-[70%] justify-center">
                <img src="{{ asset('password.png') }}" alt="" class="absolute left-3 size-4">
                <input type="password" name="password"
                    class="w-full h-10 px-9 border border-[#06402b] focus:outline-none focus:ring-0 rounded-lg font-semibold"
                    placeholder="Password" required>
            </div>
            <div class="relative flex flex-col items-center gap-y-2 justify-center w-[70%]">
                <button
                    class="bg-[#06402b] w-full text-white font-bold h-10 flex justify-center items-center rounded-lg px-9">
                    Log In
                </button>
                <a href="{{ route('dashboard') }}" class="underline hover:text-blue-500 duration-300 text-xs">Back to
                    Dashboard</a>
            </div>
             <!-- Show error -->
             @if(session('error'))
                <span class="text-red-600 text-xs font-semibold uppercase">{{ session('error') }}</span>
            @endif
        </form>
    </div>
</body>

</html>