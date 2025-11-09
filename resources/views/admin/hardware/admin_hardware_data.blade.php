<x-admin :$notifs>
    <div class="h-screen flex justify-center items-start p-5">
        <div class="container mx-auto">
            <h1 class="text-2xl font-bold mb-4">Hardware Data</h1>
            <div class="overflow-x-auto">
                <table class="w-[1000px] lg:w-full bg-white border border-gray-200 rounded-lg shadow">
                    <thead>
                        <tr class="bg-[#06402b] text-white text-left">
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Hardware Info</th>
                            <th class="px-4 py-2">PM 2.5</th>
                            <th class="px-4 py-2">PM 10</th>
                            <th class="px-4 py-2">CO</th>
                            <th class="px-4 py-2">NO2</th>
                            <th class="px-4 py-2">Decibels</th>
                            <th class="px-4 py-2">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hardware_data as $hardware_datum)
                            <tr class="{{ $loop->even ? 'bg-gray-300' : 'bg-white' }}">
                                <td class="px-4 py-2">{{$hardware_datum->data_id}}</td>
                                <td class="px-4 py-2">{{$hardware_datum->hardware?->hardware_info}}</td>
                                <td class="px-4 py-2">{{$hardware_datum->pm2_5 }}</td>
                                <td class="px-4 py-2">{{$hardware_datum->pm10 }}</td>
                                <td class="px-4 py-2">{{$hardware_datum->co }}</td>
                                <td class="px-4 py-2">{{$hardware_datum->no2 }}</td>
                                <td class="px-4 py-2">{{$hardware_datum->decibels }}</td>
                                <td class="px-4 py-2">{{$hardware_datum->created_at}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <a href="https://aeroson-monitoring.com/api/exports/aqi.csv" class="justify-end flex w-full underline text-xs hover:text-blue-500 duration-300 p-1">Download Data</a>
                <div class="mt-6 flex justify-center">
                    {{ $hardware_data->onEachSide(1)->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>
    </div>
</x-admin>