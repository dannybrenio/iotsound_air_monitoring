<x-admin>
    <div class="h-screen flex justify-center items-start p-5">
        <div class="container mx-auto">
            <h1 class="text-2xl font-bold mb-4">Hardware Data</h1>
            <div class="overflow-x-auto">
                <table class="w-full bg-white border border-gray-200 rounded-lg shadow">
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
                            <tr>                                  
                            <td>{{$hardware_datum->data_id}}</td>
                            <td>{{$hardware_datum->hardware?->hardware_info}}</td>
                            <td>{{$hardware_datum->pm2_5 }}</td>
                            <td>{{$hardware_datum->pm10 }}</td>
                            <td>{{$hardware_datum->co }}</td>
                            <td>{{$hardware_datum->no2 }}</td>
                            <td>{{$hardware_datum->decibels }}</td>
                            <td>{{$hardware_datum->created_at}}</td> 
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> 
    </div>
</x-admin>