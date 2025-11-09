<x-admin :$notifs>
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
                            <tr class="{{ $loop->even ? 'bg-gray-300' : 'bg-white' }}">                                  
                                <td class="px-4 py-2">{{$history_status->history_id}}</td>
                                <td class="px-4 py-2">{{$history_status->device_status?->hardware_info}}</td>
                                <td class="px-4 py-2">{{$history_status->sensor_type}}</td>
                                <td class="px-4 py-2">{{$history_status->sensor_status}}</td>
                                <td class="px-4 py-2">{{$history_status->created_at}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-6 flex justify-center">
                    {{ $history_statuses->onEachSide(1)->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div> 
    </div>
</x-admin>