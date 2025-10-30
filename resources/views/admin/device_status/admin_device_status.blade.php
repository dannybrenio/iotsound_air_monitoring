<x-admin>
    <div class="h-screen flex justify-center items-start p-5">
        <div class="container mx-auto">
            <h1 class="text-2xl font-bold mb-4">Device Status</h1>
            <div class="overflow-x-auto">
                <table class="w-full bg-white border border-gray-200 rounded-lg shadow">
                    <thead>
                        <tr class="bg-[#06402b] text-white text-left">
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Hardware Info</th>
                            <th class="px-4 py-2">PMS Status</th>
                            <th class="px-4 py-2">MQ135 Status</th>
                            <th class="px-4 py-2">MQ7 Status</th>
                            <th class="px-4 py-2">Sound Status</th>
                            <th class="px-4 py-2">Timestamp Status</th>
                            <th class="px-4 py-2">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach($device_statuses as $device_status) 
                            <tr>                                  
                                <td><p> {{$device_status->status_id}} </p></td>
                                <td><p> {{$device_status->hardware_info}} </p></td>
                                <td><p> {{$device_status->pms_status}} </p></td>
                                <td><p> {{$device_status->mq135_status}} </p></td> 
                                <td><p> {{$device_status->mq7_status}} </p></td>
                                <td><p> {{$device_status->sound_status}} </p></td>
                                <td><p> {{$device_status->timestamp_status}} </p></td>
                                <td><p> {{$device_status->created_at}} </p></td>
                            </tr>
                        @endforeach
                        </table>
                    </tbody>
                </table>
            </div>
        </div> 
    </div>
</x-admin>