
<x-admin>
    <div class="h-screen flex justify-center items-start px-7">
        <div class="container mx-auto">
            <h1 class="text-xl font-bold mb-10">Pending Data</h1>
            <div class="overflow-x-auto">
                <table class="w-full bg-white border border-gray-200 rounded-lg shadow">
                    <thead>
                        <tr class="bg-[#06402b] text-white text-left">
                            <th class="px-4 py-2 text-start">ID</th>
                            <th class="px-4 py-2 text-start">Hardware Info</th>
                            <th class="px-4 py-2 text-start">PM 2.5</th>
                            <th class="px-4 py-2 text-start">PM 10</th>
                            <th class="px-4 py-2 text-start">CO</th>
                            <th class="px-4 py-2 text-start">NO2</th>
                            <th class="px-4 py-2 text-start">Decibels</th>
                            <th class="px-4 py-2 text-start">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                           @foreach($pending_data as $pending_datum) 
                            <tr class="{{ $loop->even ? 'bg-gray-300' : 'bg-white' }}">                                  
                            <td class="px-4 py-2 text-start">{{$pending_datum->pending_hardware_data_id}}</td>
                            <td class="px-4 py-2 text-start">{{$pending_datum->pending_hardware_info}}</td>
                            <td class="px-4 py-2 text-start">{{$pending_datum->pm2_5 }}</td>
                            <td class="px-4 py-2 text-start">{{$pending_datum->pm10 }}</td>
                            <td class="px-4 py-2 text-start">{{$pending_datum->co }}</td>
                            <td class="px-4 py-2 text-start">{{$pending_datum->no2 }}</td>
                            <td class="px-4 py-2 text-start">{{$pending_datum->decibels }}</td>
                            <td class="px-4 py-2 text-start">{{$pending_datum->created_at}}</td> 
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-6 flex justify-center">
                    {{ $pending_data->onEachSide(1)->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div> 
    </div>
</x-admin>