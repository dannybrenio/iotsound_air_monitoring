<x-admin>
    <div class="h-screen flex justify-center items-start p-5">
        <div class="container mx-auto">
            <h1 class="text-2xl font-bold mb-4">Pending Hardware</h1>
            <div class="overflow-x-auto">
                <table class="w-full bg-white border border-gray-200 rounded-lg shadow">
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
                        @foreach($pending_hardwares as $pending_hardware) 
                            <tr>                                  
                                <td><p>{{$pending_hardware->hardware_id}} </p></td>
                                <td><p>{{$pending_hardware->hardware_info}}</p></td>
                                <td><p>{{$pending_hardware->hardware_location}}</p></td>
                                <td><p>{{$pending_hardware->created_at}}</p></td> 
                                <td><p>{{$pending_hardware->updated_at}}</p></td>
                                <td> ADD HERE{{-- <td><a href="{{ route('hardware.edit', $hardware->hardware_id) }}">Update</a> 
                                        <form action="{{ route('hardware.destroy', $hardware->hardware_id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE') 
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this hardware?')">Delete</button>
                                        </form> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> 
    </div>
</x-admin>