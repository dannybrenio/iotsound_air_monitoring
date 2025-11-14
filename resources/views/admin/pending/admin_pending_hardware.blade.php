<x-admin :$notifs>
    <div class="h-screen flex justify-center items-start px-7">
        <div class="container mx-auto">
            <h1 class="text-xl font-bold mb-10">Pending Hardware</h1>
            <div class="overflow-x-auto">
                <table class="w-full bg-white border border-gray-200 rounded-lg shadow">
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
                        @foreach($pending_hardwares as $pending_hardware)
                            <tr class="{{ $loop->even ? 'bg-gray-300' : 'bg-white' }}">
                                <td class="px-4 py-2 text-start">{{$pending_hardware->hardware_id}}</td>
                                <td class="px-4 py-2 text-start">{{$pending_hardware->hardware_info}}</td>
                                <td class="px-4 py-2 text-start">{{$pending_hardware->hardware_location}}</td>
                                <td class="px-4 py-2 text-start">{{$pending_hardware->created_at}}</td>
                                <td class="px-4 py-2 text-start">{{$pending_hardware->updated_at}}</td>
                                <td class="px-4 py-2 text-center w-10">
                                    <form action="{{ route('hardware.store') }}" method="POST" style="display:inline;">
                                        @csrf
                                        {{-- // @method('POST') --}}
                                        <input type="hidden" name="hardware_info"
                                            value="{{ $pending_hardware->hardware_info }}">
                                        <div class="relative group inline-block">
                                            <svg fill="currentColor" class="cursor-pointer text-blue-500 size-4"
                                                onclick="return confirm('Do you want to register this hardware?')" viewBox="0 0 16 16" id="register-16px" xmlns="http://www.w3.org/2000/svg">
                                                <path id="Path_184" data-name="Path 184" d="M57.5,41a.5.5,0,0,0-.5.5V43H47V31h2v.5a.5.5,0,0,0,.5.5h5a.5.5,0,0,0,.5-.5V31h2v.5a.5.5,0,0,0,1,0v-1a.5.5,0,0,0-.5-.5H55v-.5A1.5,1.5,0,0,0,53.5,28h-3A1.5,1.5,0,0,0,49,29.5V30H46.5a.5.5,0,0,0-.5.5v13a.5.5,0,0,0,.5.5h11a.5.5,0,0,0,.5-.5v-2A.5.5,0,0,0,57.5,41ZM50,29.5a.5.5,0,0,1,.5-.5h3a.5.5,0,0,1,.5.5V31H50Zm11.854,4.646-2-2a.5.5,0,0,0-.708,0l-6,6A.5.5,0,0,0,53,38.5v2a.5.5,0,0,0,.5.5h2a.5.5,0,0,0,.354-.146l6-6A.5.5,0,0,0,61.854,34.146ZM54,40V38.707l5.5-5.5L60.793,34.5l-5.5,5.5Zm-2,.5a.5.5,0,0,1-.5.5h-2a.5.5,0,0,1,0-1h2A.5.5,0,0,1,52,40.5Zm0-3a.5.5,0,0,1-.5.5h-2a.5.5,0,0,1,0-1h2A.5.5,0,0,1,52,37.5ZM54.5,35h-5a.5.5,0,0,1,0-1h5a.5.5,0,0,1,0,1Z" transform="translate(-46 -28)"/>
                                            </svg>
                                            <span
                                                class="absolute bottom-full left-1/2 -translate-x-1/2 mb-1 hidden group-hover:block bg-gray-700 text-white text-xs rounded py-1 px-2 whitespace-nowrap shadow-lg">
                                                Register
                                            </span>
                                        </div>
                                        <!-- <button type="submit"
                                            onclick="return confirm('Do you want to register this hardware?')">Register</button> -->
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-6 flex justify-center">
                    {{ $pending_hardwares->onEachSide(1)->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>
    </div>
</x-admin>