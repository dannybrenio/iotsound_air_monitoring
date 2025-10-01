<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RASE</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#dedede] overflow-y-auto hide-scrollbar">
    <!-- Fixed Header -->
    <header class="fixed top-0 left-0 right-0 shadow-md w-full h-[50px] px-5 py-2 bg-white z-50">
        <div class="flex flex-row w-full h-full justify-between items-center">
            <div class="h-full text-[#060033] w-[50%] flex justify-start items-center uppercase">Real-time Air & Sound Environment Monitoring System</div>
            <div class="h-full w-[50%] flex justify-end items-center gap-x-4">
                <div class="h-full w-[60%] flex items-center justify-end">
                    <div class="relative w-[60%] h-full flex items-center">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                            <!-- Heroicon: Magnifying Glass -->
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                fill="none" viewBox="0 0 24 24" 
                                stroke-width="1.5" stroke="currentColor" 
                                class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" 
                                    d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                            </svg>
                        </span>

                        <input type="text" 
                            placeholder="Search..."
                            class="pl-10 pr-3 py-2 w-full text-sm h-[80%] rounded-md border border-[#060033]" />
                    </div>
                </div>
                <div
                
                 class="h-full w-[40%] flex-row items-center justify-between hidden lg:flex">
                    <a href=# class="flex flex-row gap-x-2 justify-center items-center text-sm uppercase">
                        <img src="{{asset('dashboard.png')}}" alt="" class="size-4">
                        Dashboard
                    </a>
                    <a href=# class="flex flex-row gap-x-2 justify-center items-center text-sm uppercase">
                        <img src="{{asset('info.png')}}" alt="" class="size-4">
                        About
                    </a>
                    <a href=# class="flex flex-row gap-x-2 justify-center items-center text-sm uppercase">
                        <img src="{{asset('question.png')}}" alt="" class="size-4">
                        Help
                    </a>
                </div
                
                >
            </div>
        </div>
    </header>

    <!-- Main content with padding to avoid overlap -->
    <main class="h-[550px] pt-[50px]">
        <div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-[#060033] text-white h-[130px] lg:h-[50px] flex flex-col lg:flex-row items-center justify-between py-4 lg:px-4">
        <p class="text-white h-auto font-bold upppercase">© RASE</p>
        <div class="w-full lg:w-[30%] h-auto flex flex-col lg:flex-row items-center justify-center lg:justify-between">
            <p class="text-white font-bold upppercase">Privacy Policy</p>
            <p class="text-white font-bold upppercase"># 0912-345-6789</p>
            <p class="text-white font-bold upppercase">Feedback</p>
        </div>
    </footer>
</body>

</html>