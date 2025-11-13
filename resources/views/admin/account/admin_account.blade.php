<x-admin>
    <div class="h-screen flex justify-center items-start px-7">
        <div class="container mx-auto">
            <h1 class="text-xl font-bold mb-10">Accounts</h1>
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
                            <th class="px-4 py-2 text-start">Updated At</th>
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
                                <td class="px-4 py-2 text-start">{{$user->updated_at}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> 
    </div>
</x-admin>

{{-- <tr class="border-t"> --}}
                            {{-- <td class="px-4 py-2 text-start text-red-500" colspan="5">NO ACCOUNTS DATA</td> --}}
                        {{-- </tr> --}}