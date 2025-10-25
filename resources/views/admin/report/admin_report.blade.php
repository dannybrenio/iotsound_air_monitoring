<x-admin>
    <div class="h-screen flex justify-center items-start p-5">
        <div class="container mx-auto">
            <h1 class="text-2xl font-bold mb-4">Reports</h1>
            <div class="overflow-x-auto">
                <table class="w-full bg-white border border-gray-200 rounded-lg shadow">
                    <thead>
                        <tr class="bg-[#06402b] text-white text-left">
                            <th>Report ID</th>
                            <th>User Name</th>
                            <th>Report Body</th>
                            <th>Image Path</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $report)
                        <tr class="border-t">
                            <td>{{ $report->report_id}}</td>
                            <td>{{ $report->user->name}}</td>
                            <td>{{ $report->report_body}}</td>
                            <!-- no image path yet -->
                            <td>{{ $report->image_path}}</td>
                            <td>{{ $report->created_at}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> 
    </div>
</x-admin>