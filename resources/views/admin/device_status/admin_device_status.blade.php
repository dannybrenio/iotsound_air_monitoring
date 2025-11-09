<x-admin :$notifs>
    <div class="h-screen flex justify-center items-start p-5">
        <div class="container mx-auto">
            <h1 class="text-2xl font-bold mb-4">Device Status</h1>
            <div class="overflow-x-auto">
                <table class="w-[1000px] lg:w-full bg-white border border-gray-200 rounded-lg shadow">
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
                                <tr class="{{ $loop->even ? 'bg-gray-300' : 'bg-white' }}">
                                <td class="px-4 py-2">{{$device_status->status_id}}</td>
                                <td class="px-4 py-2">{{$device_status->hardware_info}}</td>
                                <td class="px-4 py-2">{{$device_status->pms_status}}</td>
                                <td class="px-4 py-2">{{$device_status->mq135_status}}</td> 
                                <td class="px-4 py-2">{{$device_status->mq7_status}}</td>
                                <td class="px-4 py-2">{{$device_status->sound_status}}</td>
                                <td class="px-4 py-2">{{$device_status->timestamp_status}}</td>
                                <td class="px-4 py-2">{{$device_status->created_at}}</td>
                            </tr>
                        @endforeach
                        </table>
                    </tbody>
                </table>
                <div class="mt-6 flex justify-center">
                    {{ $device_statuses->onEachSide(1)->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div> 
    </div>
</x-admin>