<x-admin>
    <div class="h-screen flex justify-center items-start p-5">
        <div class="container mx-auto">
            <h1 class="text-2xl font-bold mb-4">Reports</h1>
            <div class="overflow-x-auto">
                <table class="w-full bg-white border border-gray-200 rounded-lg shadow">
                    <thead>
                        <tr class="bg-[#06402b] text-white text-left">
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">User Name</th>
                            <th class="px-4 py-2">Report Body</th>
                            <th class="px-4 py-2">Image Path</th>  
                            <th class="px-4 py-2">Created At</th>            
                        </tr>
                    </thead>
                    <tbody>
                          @foreach ($reports as $report)
                            <tr class="{{ $loop->even ? 'bg-gray-300' : 'bg-white' }}">
                                <td class="px-4 py-2">{{ $report->report_id}}</td>
                                <td class="px-4 py-2">{{ $report->user->name}}</td>
                                <td class="px-4 py-2">{{ $report->report_body}}</td>
                                <!-- no image path yet -->
                                <td class="px-4 py-2">{{ $report->image_path}}</td>
                                <td class="px-4 py-2">{{ $report->created_at}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> 
    </div>
</x-admin>