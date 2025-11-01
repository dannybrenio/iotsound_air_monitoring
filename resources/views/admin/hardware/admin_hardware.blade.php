<x-admin>
    <div class="h-screen flex justify-center items-start p-5">
        <div class="container mx-auto">
            <h1 class="text-2xl font-bold mb-4">Hardware</h1>
            <div class="overflow-x-auto">
                <table class="w-[1000px] lg:w-full bg-white border border-gray-200 rounded-lg shadow">
                    <thead>
                        <tr class="bg-[#06402b] text-white text-left">
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Hardware Info</th>
                            <th class="px-4 py-2">Location</th>
                            <th class="px-4 py-2">Created At</th>
                            <th class="px-4 py-2">Updated At</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hardwares as $hardware)
                            <tr class="{{ $loop->even ? 'bg-gray-300' : 'bg-white' }}">
                                <td class="px-4 py-2">
                                    <p> {{$hardware->hardware_id}} </p>
                                </td>
                                <td class="px-4 py-2">
                                    <p>{{$hardware->hardware_info}}</p>
                                </td>
                                <td class="px-4 py-2">
                                    <p>{{$hardware->hardware_location}}</p>
                                </td>
                                <td class="px-4 py-2">
                                    <p>{{$hardware->created_at}}</p>
                                </td>
                                <td class="px-4 py-2">
                                    <p>{{$hardware->updated_at}}</p>
                                </td>
                                <td class="px-4 py-2">
                                {{-- <td><a href="{{ route('hardware.edit', $hardware->hardware_id) }}">Update</a> --}}
                                    <form action="{{ route('hardware.destroy', $hardware->hardware_id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('Are you sure you want to delete this hardware?')">Delete</button>
                                    </form> 
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-6 flex justify-center">
                    {{ $hardwares->onEachSide(1)->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>
    </div>
</x-admin>



{{-- @foreach($hardwares as $hardware)
<tr>
    <td>
        <p> {{$hardware->hardware_id}} </p>
    </td>
    <td>
        <p>{{$hardware->hardware_info}}</p>
    </td>
    <td>
        <p>{{$hardware->hardware_location}}</p>
    </td>
    <td>
        <p>{{$hardware->created_at}}</p>
    </td>
    <td>
        <p>{{$hardware->updated_at}}</p>
    </td>
    <td><a href="{{ route('hardware.edit', $hardware->hardware_id) }}">Update</a>
        <form action="{{ route('hardware.destroy', $hardware->hardware_id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit"
                onclick="return confirm('Are you sure you want to delete this hardware?')">Delete</button>
        </form>
    </td>
</tr>
@endforeach --}}