<x-admin>
    <div class="h-screen flex justify-center items-start px-7">
        <div class="container mx-auto">
            <h1 class="text-xl font-bold mb-10">History Status</h1>
            <div class="overflow-x-auto">
                <table class="w-full bg-white border border-gray-200 rounded-lg shadow">
                    <thead>
                        <tr class="bg-[#06402b] text-white text-left">
                            <th class="px-4 py-2 text-start">ID</th>
                            <th class="px-4 py-2 text-start">Hardware Info</th>
                            <th class="px-4 py-2 text-start">Sensor Type</th>
                            <th class="px-4 py-2 text-start">Sensor Status</th>
                            <th class="px-4 py-2 text-start">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($history_statuses as $history_status) 
                            <tr class="{{ $loop->even ? 'bg-gray-300' : 'bg-white' }}">                                  
                                <td class="px-4 py-2 text-start">{{$history_status->history_id}}</td>
                                <td class="px-4 py-2 text-start">{{$history_status->device_status?->hardware_info}}</td>
                                <td class="px-4 py-2 text-start">{{$history_status->sensor_type}}</td>
                                <td class="px-4 py-2 text-start">{{$history_status->sensor_status}}</td>
                                <td class="px-4 py-2 text-start">{{$history_status->created_at}}</td>
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