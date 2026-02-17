<x-admin :$notifs>
    <div class="h-screen flex justify-center items-start px-7">
        <div class="container mx-auto">
            <h1 class="text-xl font-bold mb-10">Hardware</h1>

            <div class="flex justify-end w-full">
                <!-- IMPORTANT: put the alpine state here (same div that owns open) -->
                <div
                    x-data="{
                        open: false,
                        hardware_information: '',
                        location_name: '',
                        longitude: '',
                        latitude: '',

                        selectHardware(event) {
                            const option = event.target.selectedOptions[0];
                            console.log(option);

                            this.hardware_information = option.dataset.hardwareInfo || '';
                            this.location_name = option.dataset.locationName || '';
                            this.longitude = option.dataset.longitude || '';
                            this.latitude = option.dataset.latitude || '';
                        }
                    }"
                >
                    <!-- Button -->
                    <button
                        type="button"
                        @click="open = true"
                        class="flex flex-row gap-x-2 p-2 w-auto bg-[#06402b] text-white font-bold uppercase text-sm rounded-md justify-center items-center mb-3 hover:bg-[#06402b]/80 cursor-pointer hover:scale-105 duration-300"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24">
                            <path fill="#FFFFFF" d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10s10-4.477 10-10S17.523 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/>
                        </svg>
                        New Hardware
                    </button>

                    <!-- Modal -->
                    <div
                        x-show="open"
                        @click.self="open = false"
                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                        style="display: none;"
                    >
                        <div
                            @click.away="open = false"
                            class="bg-white rounded-lg shadow-xl max-w-md w-[30%] mx-4 p-6"
                        >
                            <!-- Modal Header -->
                            <div class="flex justify-between items-center mb-4">
                                <div class="flex flex-row gap-x-2 justify-center items-center w-full">
                                    <h2 class="text-2xl font-bold text-gray-800">Add Hardware</h2>
                                </div>
                            </div>

                            <!-- Modal Content -->
                            <form
                                action="{{ route('hardware.store') }}"
                                method="POST"
                                class="space-y-4"
                            >
                                @csrf
                            
                                <!-- Pending Hardware -->
                                <div>
                                    <label class="block text-start uppercase font-medium text-gray-700 mb-1">
                                        Pending Hardware
                                    </label>
                            
                                    <div class="gap-y-2 flex flex-col">
                                        <style>
                                            select, ::picker(select){
                                                appearance: base-select;
                                            }
                                        </style>
                                        <select
                                            name="pending_hardware_id"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#06402b]"
                                            @change="selectHardware($event)"
                                            required
                                            
                                        >
                                            <option value="">Select Hardware</option>
                            
                                            @foreach(($pending_hardwares ?? []) as $pending_hardware)
                                                <option
                                                    value="{{ data_get($pending_hardware, 'id') }}"
                                                    data-hardware-info="{{ e(data_get($pending_hardware, 'hardware_info')) }}"
                                                    data-location-name="{{ e(data_get($pending_hardware, 'location_name')) }}"
                                                    data-longitude="{{ e(data_get($pending_hardware, 'longitude')) }}"
                                                    data-latitude="{{ e(data_get($pending_hardware, 'latitude')) }}"
                                                >
                                                    {{ data_get($pending_hardware, 'hardware_info', 'N/A') }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            
                                <!-- Hardware Information (display only) -->
                                <div>
                                    <label class="block text-start uppercase font-medium text-gray-700 mb-1">
                                        Hardware Information
                                    </label>
                            
                                    <input
                                        type="text"
                                        x-model="hardware_information"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#06402b]"
                                        disabled
                                    />
                            
                                    <!-- submitted -->
                                    <input type="hidden" name="hardware_info" :value="hardware_information">
                                </div>
                            
                                <!-- Location Name -->
                                <div>
                                    <label class="block text-start uppercase font-medium text-gray-700 mb-1">
                                        Location Name
                                    </label>
                            
                                    <input
                                        type="text"
                                        x-model="location_name"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#06402b]"
                                        disabled
                                    />
                            
                                    <input type="hidden" name="location_name" :value="location_name">
                                </div>
                            
                                <!-- Longitude -->
                                <div>
                                    <label class="block text-start uppercase font-medium text-gray-700 mb-1">
                                        Longitude
                                    </label>
                            
                                    <input
                                        type="text"
                                        x-model="longitude"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#06402b]"
                                        disabled
                                    />
                            
                                    <input type="hidden" name="longitude" :value="longitude">
                                </div>
                            
                                <!-- Latitude -->
                                <div>
                                    <label class="block text-start uppercase font-medium text-gray-700 mb-1">
                                        Latitude
                                    </label>
                            
                                    <input
                                        type="text"
                                        x-model="latitude"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#06402b]"
                                        disabled
                                    />
                            
                                    <input type="hidden" name="latitude" :value="latitude">
                                </div>
                            
                                <!-- Modal Actions -->
                                <div class="flex gap-x-3 pt-4">
                                    <button
                                        type="button"
                                        @click="open = false"
                                        class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-300 font-medium cursor-pointer"
                                    >
                                        Cancel
                                    </button>
                            
                                    <button
                                        type="submit"
                                        class="flex-1 px-4 py-2 bg-[#06402b] text-white rounded-md hover:bg-[#06402b]/80 font-medium cursor-pointer"
                                    >
                                        Add Hardware
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-[1000px] lg:w-full bg-white border border-gray-200 rounded-lg shadow">
                    <thead>
                        <tr class="bg-[#06402b] text-white text-left">
                            <th class="px-4 py-2 text-start">ID</th>
                            <th class="px-4 py-2 text-start">Hardware Info</th>
                            <th class="px-4 py-2 text-start">Location Name</th>
                            <th class="px-4 py-2 text-start">Longitude</th>
                            <th class="px-4 py-2 text-start">Latitude</th>
                            <th class="px-4 py-2 text-start">Created At</th>
                            <th class="px-4 py-2 text-start w-10">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($hardwares as $hardware)
                            <tr class="{{ $loop->even ? 'bg-gray-300' : 'bg-white' }}">
                                <td class="px-4 py-2 text-start">
                                    <p>{{ $hardware->hardware_id }}</p>
                                </td>

                                <td class="px-4 py-2 text-start uppercase">
                                    <p>{{ $hardware->hardware_info }}</p>
                                </td>

                                <td class="px-4 py-2 text-start uppercase">
                                    <p>{{ $hardware->location_name }}</p>
                                </td>

                                <td class="px-4 py-2 text-start">
                                    <p>{{ $hardware->longitude }}</p>
                                </td>

                                <td class="px-4 py-2 text-start">
                                    <p>{{ $hardware->latitude }}</p>
                                </td>

                                <td class="px-4 py-2 text-start">
                                    <p>{{ $hardware->created_at }}</p>
                                </td>

                                <td class="px-4 py-2 text-center w-10">
                                    <div x-data="{ open: false }" class="inline-block">
                                        <!-- Trigger Icon -->
                                        <div class="relative group inline-block">
                                            <svg
                                                @click="open = true"
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="size-5 cursor-pointer"
                                                viewBox="0 0 36 36"
                                            >
                                                <path fill="#2c4be8" d="M19.5 28.1h-2.9c-.5 0-.9-.3-1-.8l-.5-1.8l-.4-.2l-1.6.9c-.4.2-.9.2-1.2-.2l-2.1-2.1c-.3-.3-.4-.8-.2-1.2l.9-1.6l-.2-.4l-1.8-.5c-.4-.1-.8-.5-.8-1v-2.9c0-.5.3-.9.8-1l1.8-.5l.2-.4l-.9-1.6c-.2-.4-.2-.9.2-1.2l2.1-2.1c.3-.3.8-.4 1.2-.2l1.6.9l.4-.2l.5-1.8c.1-.4.5-.8 1-.8h2.9c.5 0 .9.3 1 .8L21 10l.4.2l1.6-.9c.4-.2.9-.2 1.2.2l2.1 2.1c.3.3.4.8.2 1.2l-.9 1.6l.2.4l1.8.5c.4.1.8.5.8 1v2.9c0 .5-.3.9-.8 1l-1.8.5l-.2.4l.9 1.6c.2.4.2.9-.2 1.2L24.2 26c-.3.3-.8.4-1.2.2l-1.6-.9l-.4.2l-.5 1.8c-.2.5-.6.8-1 .8zm-2.2-2h1.4l.5-2.1l.5-.2c.4-.1.7-.3 1.1-.4l.5-.3l1.9 1.1l1-1l-1.1-1.9l.3-.5c.2-.3.3-.7.4-1.1l.2-.5l2.1-.5v-1.4l-2.1-.5l-.2-.5c-.1-.4-.3-.7-.4-1.1l-.3-.5l1.1-1.9l-1-1l-1.9 1.1l-.5-.3c-.3-.2-.7-.3-1.1-.4l-.5-.2l-.5-2.1h-1.4l-.5 2.1l-.5.2c-.4.1-.7.3-1.1.4l-.5.3l-1.9-1.1l-1 1l1.1 1.9l-.3.5c-.2.3-.3.7-.4 1.1l-.2.5l-2.1.5v1.4l2.1.5l.2.5c.1.4.3.7.4 1.1l.3.5l-1.1 1.9l1 1l1.9-1.1l.5.3c.3.2.7.3 1.1.4l.5.2l.5 2.1zm9.8-6.6z"/>
                                                <path fill="#2c4be8" d="M18 22.3c-2.4 0-4.3-1.9-4.3-4.3s1.9-4.3 4.3-4.3s4.3 1.9 4.3 4.3s-1.9 4.3-4.3 4.3zm0-6.6c-1.3 0-2.3 1-2.3 2.3s1 2.3 2.3 2.3c1.3 0 2.3-1 2.3-2.3s-1-2.3-2.3-2.3z"/>
                                                <path fill="#2c4be8" d="M18 2c-.6 0-1 .4-1 1s.4 1 1 1c7.7 0 14 6.3 14 14s-6.3 14-14 14S4 25.7 4 18c0-2.8.8-5.5 2.4-7.8v1.2c0 .6.4 1 1 1s1-.4 1-1v-5h-5c-.6 0-1 .4-1 1s.4 1 1 1h1.8C3.1 11.1 2 14.5 2 18c0 8.8 7.2 16 16 16s16-7.2 16-16S26.8 2 18 2z"/>
                                                <path fill="none" d="M0 0h36v36H0z"/>
                                            </svg>

                                            <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-1 hidden group-hover:block bg-gray-700 text-white text-xs rounded py-1 px-2 whitespace-nowrap shadow-lg">
                                                Update
                                            </span>
                                        </div>

                                        <!-- Update Modal Overlay -->
                                        <div
                                            x-show="open"
                                            x-transition
                                            @click.self="open = false"
                                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                                            style="display: none;"
                                        >
                                            <div
                                                @click.away="open = false"
                                                class="bg-white rounded-lg shadow-xl max-w-md w-[30%] mx-4 p-6"
                                            >
                                                <div class="flex justify-between items-center mb-4">
                                                    <div class="flex flex-row gap-x-2 justify-center items-center w-full">
                                                        <h2 class="text-2xl font-bold text-gray-800">Update Hardware</h2>
                                                    </div>
                                                </div>

                                                <form action="{{ route('hardware.update', $hardware->hardware_id) }}" method="POST" class="space-y-4">
                                                    @csrf
                                                    @method('PUT')
                                                
                                                    <div>
                                                        <label class="block text-start uppercase font-medium text-gray-700 mb-1">
                                                            Hardware Information
                                                        </label>
                                                        <div class="gap-y-2 flex flex-col">
                                                            <input
                                                                type="text"
                                                                name="hardware_info"
                                                                value="{{ $hardware->hardware_info }}"
                                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#06402b]"
                                                                required
                                                            />
                                                        </div>
                                                    </div>
                                                
                                                    <div>
                                                        <label class="block text-start uppercase font-medium text-gray-700 mb-1">
                                                            Location Name
                                                        </label>
                                                        <div class="gap-y-2 flex flex-col">
                                                            <input
                                                                type="text"
                                                                name="location_name"
                                                                value="{{ $hardware->location_name }}"
                                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#06402b]"
                                                                required
                                                            />
                                                        </div>
                                                    </div>
                                                
                                                    <div>
                                                        <label class="block text-start uppercase font-medium text-gray-700 mb-1">
                                                            Longitude
                                                        </label>
                                                        <div class="gap-y-2 flex flex-col">
                                                            <input
                                                                type="text"
                                                                name="longitude"
                                                                value="{{ $hardware->longitude }}"
                                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#06402b]"
                                                                required
                                                            />
                                                        </div>
                                                    </div>
                                                
                                                    <div>
                                                        <label class="block text-start uppercase font-medium text-gray-700 mb-1">
                                                            Latitude
                                                        </label>
                                                        <div class="gap-y-2 flex flex-col">
                                                            <input
                                                                type="text"
                                                                name="latitude"
                                                                value="{{ $hardware->latitude }}"
                                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#06402b]"
                                                                required
                                                            />
                                                        </div>
                                                    </div>
                                                
                                                    <div class="flex gap-x-3 pt-4">
                                                        <button
                                                            type="button"
                                                            @click="open = false"
                                                            class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-300 font-medium cursor-pointer"
                                                        >
                                                            Cancel
                                                        </button>
                                                
                                                        <button
                                                            type="submit"
                                                            class="flex-1 px-4 py-2 bg-[#06402b] text-white rounded-md hover:bg-[#06402b]/80 font-medium cursor-pointer"
                                                        >
                                                            Submit
                                                        </button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                    <form action="{{ route('hardware.destroy', $hardware->hardware_id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                    
                                        <button
                                            type="submit"
                                            onclick="return confirm('Are you sure you want to delete this hardware?')"
                                            class="relative group inline-block"
                                            title="Delete"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="text-red-500 size-5 cursor-pointer"
                                                viewBox="0 0 26 26">
                                                <path fill="currentColor"
                                                    d="M11.5-.031c-1.958 0-3.531 1.627-3.531 3.594V4H4c-.551 0-1 .449-1 1v1H2v2h2v15c0 1.645 1.355 3 3 3h12c1.645 0 3-1.355 3-3V8h2V6h-1V5c0-.551-.449-1-1-1h-3.969v-.438c0-1.966-1.573-3.593-3.531-3.593h-3zm0 2.062h3c.804 0 1.469.656 1.469 1.531V4H10.03v-.438c0-.875.665-1.53 1.469-1.53zM6 8h5.125c.124.013.247.031.375.031h3c.128 0 .25-.018.375-.031H20v15c0 .563-.437 1-1 1H7c-.563 0-1-.437-1-1V8zm2 2v12h2V10H8zm4 0v12h2V10h-2zm4 0v12h2V10h-2z" />
                                            </svg>
                                    
                                            <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-1 hidden group-hover:block bg-gray-700 text-white text-xs rounded py-1 px-2 whitespace-nowrap shadow-lg">
                                                Delete
                                            </span>
                                        </button>
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
