<x-admin :$notifs>
    <div class="h-screen flex justify-center items-start px-7">
        <div class="container mx-auto">
            <h1 class="text-xl font-bold mb-10">Device Status</h1>
            <div class="overflow-x-auto">
                <table class="w-[1000px] lg:w-full bg-white border border-gray-200 rounded-lg shadow">
                    <thead>
                        <tr class="bg-[#06402b] text-white text-left">
                            <th class="px-4 py-2 text-start">ID</th>
                            <th class="px-4 py-2 text-start">Hardware Info</th>
                            <th class="px-4 py-2 text-start">PMS Status</th>
                            <th class="px-4 py-2 text-start">MQ135 Status</th>
                            <th class="px-4 py-2 text-start">MQ7 Status</th>
                            <th class="px-4 py-2 text-start">Sound Status</th>
                            <th class="px-4 py-2 text-start">Timestamp Status</th>
                            <th class="px-4 py-2 text-start">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach($device_statuses as $device_status) 
                                <tr class="{{ $loop->even ? 'bg-gray-300' : 'bg-white' }}">
                                <td class="px-4 py-2 text-start">{{$device_status->status_id}}</td>
                                <td class="px-4 py-2 text-start">{{$device_status->hardware_info}}</td>
                                <td class="px-4 py-2 text-start">{{$device_status->pms_status}}</td>
                                <td class="px-4 py-2 text-start">{{$device_status->mq135_status}}</td> 
                                <td class="px-4 py-2 text-start">{{$device_status->mq7_status}}</td>
                                <td class="px-4 py-2 text-start">{{$device_status->sound_status}}</td>
                                <td class="px-4 py-2 text-start">{{$device_status->timestamp_status}}</td>
                                <td class="px-4 py-2 text-start">{{$device_status->created_at}}</td>
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