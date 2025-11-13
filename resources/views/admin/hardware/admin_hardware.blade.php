<x-admin>
    <div class="h-screen flex justify-center items-start px-7">
        <div class="container mx-auto">
            <h1 class="text-xl font-bold mb-10">Hardware</h1>
            <div class="overflow-x-auto">
                <table class="w-[1000px] lg:w-full bg-white border border-gray-200 rounded-lg shadow">
                    <thead>
                        <tr class="bg-[#06402b] text-white text-left">
                            <th class="px-4 py-2 text-start">ID</th>
                            <th class="px-4 py-2 text-start">Hardware Info</th>
                            <th class="px-4 py-2 text-start">Location</th>
                            <th class="px-4 py-2 text-start">Created At</th>
                            <th class="px-4 py-2 text-start">Updated At</th>
                            <th class="px-4 py-2 text-start w-10">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hardwares as $hardware)
                            <tr class="{{ $loop->even ? 'bg-gray-300' : 'bg-white' }}">
                                <td class="px-4 py-2 text-start">
                                    <p> {{$hardware->hardware_id}} </p>
                                </td>
                                <td class="px-4 py-2 text-start">
                                    <p>{{$hardware->hardware_info}}</p>
                                </td>
                                <td class="px-4 py-2 text-start">
                                    <p>{{$hardware->hardware_location}}</p>
                                </td>
                                <td class="px-4 py-2 text-start">
                                    <p>{{$hardware->created_at}}</p>
                                </td>
                                <td class="px-4 py-2 text-start">
                                    <p>{{$hardware->updated_at}}</p>
                                </td>
                                <td class="px-4 py-2 text-center w-10">
                                    {{-- <td><a href="{{ route('hardware.edit', $hardware->hardware_id) }}">Update</a> --}}
                                    <form action="{{ route('hardware.destroy', $hardware->hardware_id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <div class="relative group inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                onclick="return confirm('Are you sure you want to delete this hardware?')"
                                                class="text-red-500 size-5 cursor-pointer" viewBox="0 0 26 26">
                                                <path fill="currentColor"
                                                    d="M11.5-.031c-1.958 0-3.531 1.627-3.531 3.594V4H4c-.551 0-1 .449-1 1v1H2v2h2v15c0 1.645 1.355 3 3 3h12c1.645 0 3-1.355 3-3V8h2V6h-1V5c0-.551-.449-1-1-1h-3.969v-.438c0-1.966-1.573-3.593-3.531-3.593h-3zm0 2.062h3c.804 0 1.469.656 1.469 1.531V4H10.03v-.438c0-.875.665-1.53 1.469-1.53zM6 8h5.125c.124.013.247.031.375.031h3c.128 0 .25-.018.375-.031H20v15c0 .563-.437 1-1 1H7c-.563 0-1-.437-1-1V8zm2 2v12h2V10H8zm4 0v12h2V10h-2zm4 0v12h2V10h-2z" />
                                            </svg>
                                            <span
                                                class="absolute bottom-full left-1/2 -translate-x-1/2 mb-1 hidden group-hover:block bg-gray-700 text-white text-xs rounded py-1 px-2 whitespace-nowrap shadow-lg">
                                                Delete
                                            </span>
                                        </div>

                                        <!-- <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete this hardware?')">Delete</button> -->
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