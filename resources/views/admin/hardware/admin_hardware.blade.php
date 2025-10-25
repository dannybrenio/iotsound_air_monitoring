<x-admin>
    <div class="h-screen flex justify-center items-start p-5">
        <div class="container mx-auto">
            <h1 class="text-2xl font-bold mb-4">Hardware</h1>
            <div class="overflow-x-auto">
                <table>
                    <tr>
                        <th>Hardware Id</th>
                        <th>Hardware Info</th>
                        <th>Hardware Location</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Modify</th>
                    </tr>
                    @foreach($hardwares as $hardware)
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
                </table>
            </div>
        </div> 
    </div>
</x-admin>