<x-admin :notifs="$notifs">
    <div class="h-auto lg:h-screen flex justify-center items-start px-7">
        <div class="container mx-auto flex flex-col">
            <h1 class="text-xl font-bold mb-10">Dashboard</h1>
            <div class="w-full h-auto flex flex-col justify-center items-center gap-y-5">
                <div class="flex flex-col lg:flex-row w-full justify-between gap-y-5">
                    @foreach ($device_statuses as $device_status)
                        <div onclick="window.location='{{ route('device') }}'"
                            class="cursor-pointer hover:-translate-y-1 duration-300 bg-gradient-to-r from-[#06402b] to-green-500 rounded-xl shadow-md w-full lg:w-[24%] h-24 flex flex-col justify-between items-start p-5">
                            <span class="text-xs font-semibold text-[#FFFFFF]">PMS Status</span>
                            <span class="uppercase text-base text-white font-bold tracking-wide">
                                {{$device_status->pms_status}}
                            </span>
                        </div>
                        <div onclick="window.location='{{ route('device') }}'"
                            class="cursor-pointer hover:-translate-y-1 duration-300 bg-white rounded-xl shadow-md w-full lg:w-[24%] h-24 flex flex-col justify-between items-start p-5">
                            <span class="text-xs font-semibold text-[#06402b]">Mq135 Status</span>
                            <span class="uppercase text-base text-[#06402b] font-bold tracking-wide">
                                {{$device_status->mq135_status}}
                            </span>
                        </div>
                        <div onclick="window.location='{{ route('device') }}'"
                            class="cursor-pointer hover:-translate-y-1 duration-300 bg-white rounded-xl shadow-md w-full lg:w-[24%] h-24 flex flex-col justify-between items-start p-5">
                            <span class="text-xs font-semibold text-[#06402b]">Mq7 Status</span>
                            <span class="uppercase text-base text-[#06402b] font-bold tracking-wide">
                                {{$device_status->mq7_status}}
                            </span>
                        </div>
                        <div onclick="window.location='{{ route('device') }}'"
                            class="cursor-pointer hover:-translate-y-1 duration-300 bg-white rounded-xl shadow-md w-full lg:w-[24%] h-24 flex flex-col justify-between items-start p-5">
                            <span class="text-xs font-semibold text-[#06402b]">Sound Status</span>
                            <span class="uppercase text-base text-[#06402b] font-bold tracking-wide">
                                {{$device_status->sound_status}}
                            </span>
                        </div>
                    @endforeach
                </div>
                <div class="flex flex-col lg:flex-row w-full justify-between gap-y-5">
                    <div class="flex flex-col justify-between items-start bg-white rounded-xl shadow-md w-full lg:w-[64%] h-70 p-5 gap-y-5">
                        <div class="flex flex-col lg:flex-row justify-between items-center w-full">
                            <span class="text-[#06402b] font-bold text-base">New Registered Account</span>
                            <a href="{{ route('account') }}" class="hover:text-[#06402b] font-semibold text-xs flex flex-row items-center justify-center gap-x-1">
                                <svg class="size-4" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="none"><path fill="currentColor" fill-rule="evenodd" d="M8 3.517a1 1 0 011.62-.784l5.348 4.233a1 1 0 010 1.568l-5.347 4.233A1 1 0 018 11.983v-1.545c-.76-.043-1.484.003-2.254.218-.994.279-2.118.857-3.506 1.99a.993.993 0 01-1.129.096.962.962 0 01-.445-1.099c.415-1.5 1.425-3.141 2.808-4.412C4.69 6.114 6.244 5.241 8 5.042V3.517zm1.5 1.034v1.2a.75.75 0 01-.75.75c-1.586 0-3.066.738-4.261 1.835a8.996 8.996 0 00-1.635 2.014c.878-.552 1.695-.916 2.488-1.138 1.247-.35 2.377-.33 3.49-.207a.75.75 0 01.668.745v1.2l4.042-3.2L9.5 4.55z" clip-rule="evenodd"/></svg>
                                Check Information
                            </a>
                        </div>
                        <div class="border-2 border-gray-200 rounded-xl overflow-hidden h-96">
                            <div class="h-full overflow-y-auto hide-scrollbar">
                                <table class="w-full table-fixed">
                                    <thead class="bg-gray-100 sticky top-0 z-10">
                                        <tr>
                                            <th class="text-left text-sm px-2 h-10">Name</th>
                                            <th class="text-left text-sm px-2 h-10">Username</th>
                                            <th class="text-left text-sm px-2 h-10">Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                        <!-- class="{{ $loop->odd ? 'bg-[#06402b] text-white' : 'bg-white' }}" -->
                                            <tr class="hover:bg-gradient-to-r from-[#06402b] to-green-500 hover:text-white">
                                                <td class="px-2 text-xs h-10">
                                                    {{ $user->first_name }} {{ $user->middle_name ?? '' }}
                                                    {{ $user->last_name }}
                                                </td>
                                                <td class="px-2 text-xs h-10">
                                                    {{ $user->username }}
                                                </td>
                                                <td class="px-2 text-xs h-10">
                                                    {{ $user->created_at }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col justify-center items-center w-full lg:w-[34.5%] h-70 gap-y-5">
                        <div class="flex flex-row justify-between items-center h-[50%] w-full">
                            <div onclick="window.location='{{ route('report') }}'" class="flex flex-col justify-evenly items-center w-[48%] h-full bg-white rounded-xl shadow-md cursor-pointer hover:-translate-y-1 duration-300 transform">
                                <div class="flex flex-col items-start gap-x-1">
                                    <span class="text-sm font-semibold text-[#06402b]">Today's Reports</span>
                                </div>
                                <span class="text-4xl font-bold text-[#06402b] w-full text-center">{{ $reports }}</span>
                            </div>
                            <div onclick="window.location='{{ route('alert') }}'" class="flex flex-col justify-evenly items-center w-[48%] h-full bg-white rounded-xl shadow-md cursor-pointer hover:-translate-y-1 duration-300 transform">
                                <div class="flex flex-col items-start gap-x-1">
                                    <span class="text-sm font-semibold text-[#06402b]">Today's Alerts</span>
                                </div>
                                <span class="text-4xl font-bold text-[#06402b] w-full text-center">{{ $alerts }}</span>
                            </div>
                        </div>
                        <div class="flex flex-col justify-center items-center bg-[#06402b] h-[50%] w-full rounded-xl shadow-md px-5 gap-y-3">
                            <div class="flex flex-row w-[80%] items-center justify-evenly">
                                <span id="weekday" class="text-sm uppercase font-semibold text-[#FFFFFF]"></span>
                                <span class="text-sm uppercase font-semibold text-[#FFFFFF]">—</span>
                                <div class="flex flex-row gap-x-1">
                                    <span id="month" class="text-sm uppercase font-semibold text-[#FFFFFF]"></span>
                                    <span id="day" class="text-sm uppercase font-semibold text-[#FFFFFF]"></span>
                                    <span id="year" class="text-sm uppercase font-semibold text-[#FFFFFF]"></span>
                                </div>
                            </div>
                            <div class="flex flex-row items-center gap-x-1 font-bold">
                                <span id="hour" class="text-5xl text-[#FFFFFF]"></span>
                                <span class="text-5xl text-[#FFFFFF]">:</span>
                                <span id="minute" class=" text-5xl text-[#FFFFFF]"></span>
                                <div class="flex flex-col justify-between">
                                    <span id="second" class=" text-sm text-[#FFFFFF]"></span>
                                    <span id="ampm" class="text-sm text-[#FFFFFF]"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateClock() {
            const now = new Date();

            // Full date: Monday, January 20, 2025
            const weekday = now.toLocaleDateString('en-US', {
                weekday: 'long',
                
            });
            const year = now.toLocaleDateString('en-US', {
                year: 'numeric',
                
            });
            const month = now.toLocaleDateString('en-US', {
                month: 'long',
                
            });
            const day = now.toLocaleDateString('en-US', {
                day: 'numeric',
                
            });

            
            document.getElementById('weekday').textContent = `${weekday}`;
            document.getElementById('year').textContent = `${year}`;
            document.getElementById('month').textContent = month + " ";
            document.getElementById('day').textContent = day + ", ";

            const hours24 = now.getHours();
            const minutes = now.getMinutes();
            const seconds = now.getSeconds();
    
            let hours12 = hours24 % 12;
            hours12 = hours12 ? hours12 : 12;
            const ampm = hours24 >= 12 ? "PM" : "AM";
    
            document.getElementById('hour').textContent = hours12.toString().padStart(2,'0');
            document.getElementById('minute').textContent = minutes.toString().padStart(2,'0');
            document.getElementById('second').textContent = seconds.toString().padStart(2,'0');
            document.getElementById('ampm').textContent = ampm;
        }

        setInterval(updateClock, 1000);
        updateClock();
    </script>
</x-admin>