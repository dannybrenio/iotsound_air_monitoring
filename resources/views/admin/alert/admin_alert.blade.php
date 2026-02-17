<x-admin :$notifs>
    <div class="h-auto lg:h-screen flex justify-center items-start px-7">
        <div class="container mx-auto">
            <h1 class="text-xl font-bold mb-10">Alerts</h1>
            <div class="flex justify-end w-full">
                <style>
                    select, ::picker(select){
                        appearance: base-select;
                        width: 100px;
                    }
                </style>

                <form method="GET" class="mb-3">
                    <select
                        name="type"
                        onchange="this.form.submit()"
                        class="border border-[#06402b] rounded-md p-2 text-sm text-[#06402b] focus:ring-0 focus:outline-none cursor-pointer"
                    >
                        <option value="air" {{ ($type ?? request('type', 'air')) === 'air' ? 'selected' : '' }}>AIR</option>
                        <option value="noise" {{ ($type ?? request('type', 'air')) === 'noise' ? 'selected' : '' }}>NOISE</option>
                    </select>
                </form>
                
            </div>
            <div class="overflow-x-auto">
                <table class="w-full bg-white border border-gray-200 rounded-lg shadow">
                    <thead>
                        <tr class="bg-[#06402b] text-white text-left">
                            <th class="px-2 py-2">ID</th>
                            <th class="px-2 py-2">Alert</th>
                            <th class="px-2 py-2">Date</th>
                        </tr>
                    </thead>
                 <tbody>
                    @foreach($alerts as $alert)
                        <tr class="{{ $loop->even ? 'bg-gray-300' : 'bg-white' }}">
                            <td class="px-2 py-2 text-start"><p>{{$alert->alert_id}}</p></td>
                            <td class="px-2 py-2 text-start"><p>{{$alert->alert_body}}</p></td>
                            <td class="px-2 py-2 text-start"><p>{{$alert->created_at}}</p></td>
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