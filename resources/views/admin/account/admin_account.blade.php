<x-admin :$notifs>
    <div class="h-auto lg:h-screen flex justify-center items-start px-7">
        
        {{-- SUCCESS TOAST --}}
        @if(session('success'))
            <div
                x-data="{ show: true }"
                x-show="show"
                x-transition:enter="transform ease-out duration-300"
                x-transition:enter-start="translate-y-4 opacity-0 scale-95"
                x-transition:enter-end="translate-y-0 opacity-100 scale-100"
                x-transition:leave="transform ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                x-init="setTimeout(() => show = false, 4000)"
                class="fixed top-6 right-6 z-[9999]
                       flex items-center gap-x-4
                       bg-green-700 text-white px-6 py-4 rounded-xl shadow-2xl
                       border-l-8 border-green-300 min-w-[320px]"
                style="right: 1.5rem; top: 1.5rem;"  {{-- extra safety --}}
            >
                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-white/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24">
                        <path fill="currentColor"
                              d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                    </svg>
                </div>
        
                <div class="flex-1">
                    <p class="font-semibold text-base leading-tight">Success</p>
                    <p class="text-sm text-white/90">{{ session('success') }}</p>
                </div>
        
                <button @click="show = false"
                        class="text-white/70 hover:text-white text-lg font-bold">
                    ✕
                </button>
            </div>
        @endif

        <div class="container mx-auto">
            <h1 class="text-xl font-bold mb-10">Accounts</h1>
            <div x-data="{ open: false }">
                <!-- Button -->
                <div class="flex justify-end w-full">
                    <button 
                        @click="open = true"
                        class="flex flex-row gap-x-2 p-2 w-auto bg-[#06402b] text-white font-bold uppercase text-sm rounded-md justify-center items-center mb-3 hover:bg-[#06402b]/80 cursor-pointer hover:scale-105 duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24">
                            <path fill="#FFFFFF" d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10s10-4.477 10-10S17.523 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/>
                        </svg>
                        New Account
                    </button>
                </div>
        
                <!-- Modal -->
                <div 
                    x-show="open"
                    @click.self="open = false"
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                    style="display: none;">
                    <div 
                        @click.away="open = false"
                        class="bg-white rounded-lg shadow-xl max-w-md w-[30%] mx-4 p-6">
                        <!-- Modal Header -->
                        <div class="flex justify-between items-center mb-4">
                            <div class="flex flex-row gap-x-2 justify-center items-center w-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-6" viewBox="0 0 472 384"><path fill="#06402b" d="M298.5 192q-35.5 0-60.5-25t-25-60.5T238 46t60.5-25T359 46t25 60.5t-25 60.5t-60.5 25zM107 149h64v43h-64v64H64v-64H0v-43h64V85h43v64zm191.5 86q31.5 0 69.5 9t69.5 29.5T469 320v43H128v-43q0-26 31.5-46.5T229 244t69.5-9z"/></svg>
                                <h2 class="text-2xl font-bold text-gray-800">Create Account</h2>
                            </div>
                            <!--<button-->
                            <!--    @click="open = false"-->
                            <!--    class="text-gray-500 hover:text-gray-700 text-2xl font-bold">-->
                            <!--    ×-->
                            <!--</button>-->
                        </div>
        
                        <!-- Modal Content -->
                        <form class="space-y-4"
                              method="POST"
                              action="{{ route('admin.accounts.store') }}">
                            @csrf
                        
                            <!-- Personal Information -->
                            <div class="gap-y-2 flex flex-col">
                                <input type="text" name="first_name" placeholder="First Name"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#06402b]"
                                       required value="{{ old('first_name') }}"/>
                        
                                <input type="text" name="middle_name" placeholder="Middle Name (Optional)"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#06402b]"
                                       value="{{ old('middle_name') }}"/>
                        
                                <input type="text" name="last_name" placeholder="Last Name"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#06402b]"
                                       required value="{{ old('last_name') }}"/>
                            </div>
                        
                            <!-- Barangay -->
                            <input type="text" name="barangay" placeholder="Barangay"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#06402b]"
                                   required value="{{ old('barangay') }}"/>
                        
                            <!-- Account Details -->
                            <input type="email" name="email" placeholder="Email Address"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#06402b]"
                                   required value="{{ old('email') }}"/>
                        
                            <input type="text" name="username" placeholder="Username"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#06402b]"
                                   required value="{{ old('username') }}"/>
                        
                            <!-- Security -->
                            <input type="password" name="password" placeholder="Password"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#06402b]"
                                   required/>
                        
                            <input type="password" name="password_confirmation" placeholder="Confirm Password"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#06402b]"
                                   required/>
                        
                            <div class="flex gap-x-3 pt-4">
                                <button type="button"
                                        @click="open = false"
                                        class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-300 font-medium cursor-pointer">
                                    Cancel
                                </button>
                        
                                <button type="submit"
                                        class="flex-1 px-4 py-2 bg-[#06402b] text-white rounded-md hover:bg-[#06402b]/80 font-medium cursor-pointer">
                                    Create Account
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full bg-white border border-gray-200 rounded-lg shadow">
                    <thead>
                        <tr class="bg-[#06402b] text-white text-left">
                            <th class="px-4 py-2 text-start">ID</th>
                            <th class="px-4 py-2 text-start">Name</th>
                            <th class="px-4 py-2 text-start">Barangay</th>
                            <th class="px-4 py-2 text-start">Email</th>
                            <th class="px-4 py-2 text-start">Username</th>
                            <th class="px-4 py-2 text-start">Created At</th>
                            <th class="px-4 py-2 text-start w-10">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr class="{{ $loop->even ? 'bg-gray-300' : 'bg-white' }}">
                                <td class="px-4 py-2 text-start">{{$user->id}}</td>
                                <td class="px-4 py-2 text-start">{{$user->first_name}} {{$user->middle_name ?? ''}} {{$user->last_name}}</td>
                                <td class="px-4 py-2 text-start">{{$user->barangay}}</td>
                                <td class="px-4 py-2 text-start">{{$user->email}}</td>
                                <td class="px-4 py-2 text-start">{{$user->username}}</td>
                                <td class="px-4 py-2 text-start">{{$user->created_at}}</td>
                                <td class="px-4 py-2 text-center w-10">
                                    <div x-data="{ open: false }" class="inline-block">
                                        <!-- Trigger Icon -->
                                        <div class="relative group inline-block">
                                            <svg @click="open = true"
                                                xmlns="http://www.w3.org/2000/svg" class="size-5 cursor-pointer" viewBox="0 0 36 36">
                                                <path fill="#2c4be8" d="M19.5 28.1h-2.9c-.5 0-.9-.3-1-.8l-.5-1.8l-.4-.2l-1.6.9c-.4.2-.9.2-1.2-.2l-2.1-2.1c-.3-.3-.4-.8-.2-1.2l.9-1.6l-.2-.4l-1.8-.5c-.4-.1-.8-.5-.8-1v-2.9c0-.5.3-.9.8-1l1.8-.5l.2-.4l-.9-1.6c-.2-.4-.2-.9.2-1.2l2.1-2.1c.3-.3.8-.4 1.2-.2l1.6.9l.4-.2l.5-1.8c.1-.4.5-.8 1-.8h2.9c.5 0 .9.3 1 .8L21 10l.4.2l1.6-.9c.4-.2.9-.2 1.2.2l2.1 2.1c.3.3.4.8.2 1.2l-.9 1.6l.2.4l1.8.5c.4.1.8.5.8 1v2.9c0 .5-.3.9-.8 1l-1.8.5l-.2.4l.9 1.6c.2.4.2.9-.2 1.2L24.2 26c-.3.3-.8.4-1.2.2l-1.6-.9l-.4.2l-.5 1.8c-.2.5-.6.8-1 .8zm-2.2-2h1.4l.5-2.1l.5-.2c.4-.1.7-.3 1.1-.4l.5-.3l1.9 1.1l1-1l-1.1-1.9l.3-.5c.2-.3.3-.7.4-1.1l.2-.5l2.1-.5v-1.4l-2.1-.5l-.2-.5c-.1-.4-.3-.7-.4-1.1l-.3-.5l1.1-1.9l-1-1l-1.9 1.1l-.5-.3c-.3-.2-.7-.3-1.1-.4l-.5-.2l-.5-2.1h-1.4l-.5 2.1l-.5.2c-.4.1-.7.3-1.1.4l-.5.3l-1.9-1.1l-1 1l1.1 1.9l-.3.5c-.2.3-.3.7-.4 1.1l-.2.5l-2.1.5v1.4l2.1.5l.2.5c.1.4.3.7.4 1.1l.3.5l-1.1 1.9l1 1l1.9-1.1l.5.3c.3.2.7.3 1.1.4l.5.2l.5 2.1zm9.8-6.6z"/>
                                                <path fill="#2c4be8" d="M18 22.3c-2.4 0-4.3-1.9-4.3-4.3s1.9-4.3 4.3-4.3s4.3 1.9 4.3 4.3s-1.9 4.3-4.3 4.3zm0-6.6c-1.3 0-2.3 1-2.3 2.3s1 2.3 2.3 2.3c1.3 0 2.3-1 2.3-2.3s-1-2.3-2.3-2.3z"/>
                                                <path fill="#2c4be8" d="M18 2c-.6 0-1 .4-1 1s.4 1 1 1c7.7 0 14 6.3 14 14s-6.3 14-14 14S4 25.7 4 18c0-2.8.8-5.5 2.4-7.8v1.2c0 .6.4 1 1 1s1-.4 1-1v-5h-5c-.6 0-1 .4-1 1s.4 1 1 1h1.8C3.1 11.1 2 14.5 2 18c0 8.8 7.2 16 16 16s16-7.2 16-16S26.8 2 18 2z"/>
                                                <path fill="none" d="M0 0h36v36H0z"/>
                                            </svg>
                                    
                                            <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-1 hidden group-hover:block bg-gray-700 text-white text-xs rounded py-1 px-2 shadow-lg">
                                                Update
                                            </span>
                                        </div>
                                
                                        <!-- Modal -->
                                        <div 
                                            x-show="open"
                                            @click.self="open = false"
                                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                                            style="display: none;">
                                            <div 
                                                @click.away="open = false"
                                                class="bg-white rounded-lg shadow-xl max-w-md w-[30%] mx-4 p-6">
                                                <!-- Modal Header -->
                                                <div class="flex justify-between items-center mb-4">
                                                    <div class="flex flex-row gap-x-2 justify-center items-center w-full">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-6" viewBox="0 0 472 384"><path fill="#06402b" d="M298.5 192q-35.5 0-60.5-25t-25-60.5T238 46t60.5-25T359 46t25 60.5t-25 60.5t-60.5 25zM107 149h64v43h-64v64H64v-64H0v-43h64V85h43v64zm191.5 86q31.5 0 69.5 9t69.5 29.5T469 320v43H128v-43q0-26 31.5-46.5T229 244t69.5-9z"/></svg>
                                                        <h2 class="text-2xl font-bold text-gray-800">Update Account</h2>
                                                    </div>
                                                    <!--<button-->
                                                    <!--    @click="open = false"-->
                                                    <!--    class="text-gray-500 hover:text-gray-700 text-2xl font-bold">-->
                                                    <!--    ×-->
                                                    <!--</button>-->
                                                </div>
                                
                                                <!-- Modal Content -->
                                                <form class="space-y-6 max-w-3xl mx-auto" 
                                                      action="{{ route('admin.accounts.update', $user->id) }}" 
                                                      method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    
                                                    <!-- Personal Information Section -->
                                                    <div class="space-y-4">
                                                        <h3 class="text-base font-semibold text-gray-800 border-b border-gray-300 pb-2">User Information</h3>
                                                        
                                                        <div class="grid grid-cols-3 gap-4">
                                                            <div>
                                                                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">
                                                                    First Name <span class="text-red-500">*</span>
                                                                </label>
                                                                <input type="text" 
                                                                       id="first_name"
                                                                       name="first_name" 
                                                                       value="{{ $user->first_name }}" 
                                                                       required
                                                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700 outline-none transition text-gray-900">
                                                            </div>
                                                            
                                                            <div>
                                                                <label for="middle_name" class="block text-sm font-medium text-gray-700 mb-2">
                                                                    Middle Name
                                                                </label>
                                                                <input type="text" 
                                                                       id="middle_name"
                                                                       name="middle_name" 
                                                                       value="{{ $user->middle_name }}"
                                                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700 outline-none transition text-gray-900">
                                                            </div>
                                                            
                                                            <div>
                                                                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">
                                                                    Last Name <span class="text-red-500">*</span>
                                                                </label>
                                                                <input type="text" 
                                                                       id="last_name"
                                                                       name="last_name" 
                                                                       value="{{ $user->last_name }}" 
                                                                       required
                                                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700 outline-none transition text-gray-900">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Location Section -->

                                                        <div>
                                                            <label for="barangay" class="block text-sm font-medium text-gray-700 mb-2">
                                                                Barangay <span class="text-red-500">*</span>
                                                            </label>
                                                            <input type="text" 
                                                                   id="barangay"
                                                                   name="barangay" 
                                                                   value="{{ $user->barangay }}" 
                                                                   required
                                                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700 outline-none transition text-gray-900">
                                                        </div>

                                                    <!-- Account Details Section -->

                                                        <div class="grid grid-cols-2 gap-4">
                                                            <div>
                                                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                                                    Email <span class="text-red-500">*</span>
                                                                </label>
                                                                <input type="email" 
                                                                       id="email"
                                                                       name="email" 
                                                                       value="{{ $user->email }}" 
                                                                       required
                                                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700 outline-none transition text-gray-900">
                                                            </div>
                                                            
                                                            <div>
                                                                <label for="username" class="block text-sm font-medium text-gray-700 mb-2 mt-4">
                                                                    Username <span class="text-red-500">*</span>
                                                                </label>
                                                                <input type="text" 
                                                                       id="username"
                                                                       name="username" 
                                                                       value="{{ $user->username }}" 
                                                                       required
                                                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700 outline-none transition text-gray-900">
                                                            </div>
                                                        </div>
                                                        
                                                                                                      <!-- Security Section -->
                                                        <div>
                                                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                                                New Password
                                                            </label>
                                                            <input type="password" 
                                                                   id="password"
                                                                   name="password"
                                                                   placeholder="Leave blank to keep current password"
                                                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-700 focus:border-green-700 outline-none transition text-gray-900 placeholder:text-gray-400">
                                                            <p class="mt-2 text-xs text-gray-500 text-center">Only fill this if you want to change the password</p>
                                                        </div>


                                                    <!-- Form Actions -->
<div class="mt-10 pt-6 flex flex-wrap items-center justify-center gap-x-8 gap-y-3">
                                                        <button
                                                            type="button"
                                                            @click="open = false"
                                                            class="px-10 py-3 text-base font-semibold
                                                                   text-gray-700 bg-white border border-gray-300 rounded-lg
                                                                   hover:bg-gray-50 
                                                                   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400
                                                                   transition"
                                                        >
                                                            Cancel
                                                        </button>
                                                    
                                                        <button
                                                            type="submit"
                                                            class="px-10 py-3 text-base font-semibold
                                                                   text-white bg-green-700 rounded-lg
                                                                   hover:bg-green-800
                                                                   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-700
                                                                   transition"
                                                        >
                                                            Update Account
                                                        </button>
                                                    </div>

                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                    
                                    <form action="{{ route('admin.accounts.destroy', $user->id) }}"
                                          method="POST"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                    
                                        <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete this user?')"
                                                class="relative group inline-flex items-center">
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
                    {{ $users->onEachSide(1)->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div> 
    </div>
</x-admin>

<!--{{-- <tr class="border-t"> --}}-->
<!--                            {{-- <td class="px-4 py-2 text-start text-red-500" colspan="5">NO ACCOUNTS DATA</td> --}}-->
<!--                        {{-- </tr> --}}-->