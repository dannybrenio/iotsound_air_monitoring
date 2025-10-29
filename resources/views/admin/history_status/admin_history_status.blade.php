<x-admin>
    <div class="h-screen flex justify-center items-start p-5">
        <div class="container mx-auto">
            <h1 class="text-2xl font-bold mb-4">History Status</h1>
            <div class="overflow-x-auto">
                <table class="w-full bg-white border border-gray-200 rounded-lg shadow">
                    <thead>
                        <tr class="bg-[#06402b] text-white text-left">
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Hardware Info</th>
                            <th class="px-4 py-2">Sensor Type</th>
                            <th class="px-4 py-2">Sensor Status</th>
                            <th class="px-4 py-2">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($history_statuses as $history_status) 
                            <tr>                                  
                                <td><p> {{$history_status->history_id}} </p></td>
                                <td><p> {{$history_status->device_status?->hardware_info}} </p></td>
                                <td><p> {{$history_status->sensor_type}} </p></td>
                                <td><p> {{$history_status->sensor_status}} </p></td>
                                <td><p> {{$history_status->created_at}} </p></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> 
    </div>
</x-admin>