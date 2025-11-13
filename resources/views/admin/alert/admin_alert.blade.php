<x-admin>
    <div class="h-screen flex justify-center items-start px-7">
        <div class="container mx-auto">
            <h1 class="text-xl font-bold mb-10">Alerts</h1>
            <div class="overflow-x-auto">
                <table class="w-full bg-white border border-gray-200 rounded-lg shadow">
                    <thead>
                        <tr class="bg-[#06402b] text-white text-left">
                            <th class="px-2 py-2">ID</th>
                            <th class="px-18 py-2">Alert</th>
                        </tr>
                    </thead>
                 <tbody>
                    @foreach($alerts as $alert)
                        <tr class="{{ $loop->even ? 'bg-gray-300' : 'bg-white' }}">
                            <td class="px-4 py-2 text-start"><p>{{$alert->alert_id}}</p></td>
                            <td class="px-4 py-2 text-start"><p>{{$alert->alert_body}}</p></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-6 flex justify-center">
                    {{ $alerts->onEachSide(1)->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div> 
    </div>
</x-admin>