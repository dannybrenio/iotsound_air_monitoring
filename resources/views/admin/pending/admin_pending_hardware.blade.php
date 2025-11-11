<x-admin>
    <div class="h-screen flex justify-center items-start p-5">
        <div class="container mx-auto">
            <h1 class="text-2xl font-bold mb-4">Pending Hardware</h1>
            <div class="overflow-x-auto">
                <table class="w-full bg-white border border-gray-200 rounded-lg shadow">
                    <thead>
                        <tr class="bg-[#06402b] text-white text-left">
                            <th class="px-4 py-2 text-start">ID</th>
                            <th class="px-4 py-2 text-start">Hardware Info</th>
                            <th class="px-4 py-2 text-start">Location</th>
                            <th class="px-4 py-2 text-start">Created At</th>
                            <th class="px-4 py-2 text-start">Updated At</th>
                            <th class="px-4 py-2 text-start">Actions</th>
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
                                <td class="px-4 py-2 text-start">
                                    <form action="{{ route('hardware.store') }}" method="POST" style="display:inline;">
                                        @csrf
                                        {{-- // @method('POST') --}}
                                        <input type="hidden" name="hardware_info"
                                            value="{{ $pending_hardware->hardware_info }}">
                                        <div class="relative group inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="cursor-pointer text-blue-500 size-5"
                                                onclick="return confirm('Do you want to register this hardware?')"
                                                viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="M6 20q-.825 0-1.413-.588T4 18q0-.825.588-1.413T6 16q.825 0 1.413.588T8 18q0 .825-.588 1.413T6 20Zm0-6q-.825 0-1.413-.588T4 12q0-.825.588-1.413T6 10q.825 0 1.413.588T8 12q0 .825-.588 1.413T6 14Zm0-6q-.825 0-1.413-.588T4 6q0-.825.588-1.413T6 4q.825 0 1.413.588T8 6q0 .825-.588 1.413T6 8Zm6 6q-.825 0-1.413-.588T10 12q0-.825.588-1.413T12 10q.825 0 1.413.588T14 12l-2 2Zm0-6q-.825 0-1.413-.588T10 6q0-.825.588-1.413T12 4q.825 0 1.413.588T14 6q0 .825-.588 1.413T12 8Zm-1 12v-2.125l5.3-5.3l2.125 2.125l-5.3 5.3H11Zm7-12q-.825 0-1.413-.588T16 6q0-.825.588-1.413T18 4q.825 0 1.413.588T20 6q0 .825-.588 1.413T18 8Zm1.125 6L17 11.875l.725-.725q.3-.3.713-.3t.687.3l.725.725q.3.275.3.688t-.3.712l-.725.725Z" />
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
            </div>
        </div>
    </div>
</x-admin>