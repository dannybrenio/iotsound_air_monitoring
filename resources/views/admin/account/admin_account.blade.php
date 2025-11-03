<x-admin>
    <div class="h-screen flex justify-center items-start p-5">
        <div class="container mx-auto">
            <h1 class="text-2xl font-bold mb-4">Accounts</h1>
            <div class="overflow-x-auto">
                <table class="w-full bg-white border border-gray-200 rounded-lg shadow">
                    <thead>
                        <tr class="bg-[#06402b] text-white text-left">
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Barangay</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Username</th>
                            <th class="px-4 py-2">Created At</th>
                            <th class="px-4 py-2">Updated At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr class="{{ $loop->even ? 'bg-gray-300' : 'bg-white' }}">
                                <td class="px-4 py-2">{{$user->id}}</td>
                                <td class="px-4 py-2">{{$user->first_name}} {{$user->middle_name ?? ''}} {{$user->last_name}}</td>
                                <td class="px-4 py-2">{{$user->barangay}}</td>
                                <td class="px-4 py-2">{{$user->email}}</td>
                                <td class="px-4 py-2">{{$user->username}}</td>
                                <td class="px-4 py-2">{{$user->created_at}}</td>
                                <td class="px-4 py-2">{{$user->updated_at}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> 
    </div>
</x-admin>

{{-- <tr class="border-t"> --}}
                            {{-- <td class="px-4 py-2 text-red-500" colspan="5">NO ACCOUNTS DATA</td> --}}
                        {{-- </tr> --}}