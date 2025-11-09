<x-admin :$notifs>
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
                                <td class="px-4 py-2">{{ $report->user->first_name}} {{ $report->user->middle_name ?? ''}} {{ $report->user->last_name}}</td>
                                <td class="px-4 py-2">{{ $report->report_body}}</td>
                                      <td>             
                                        @if ($report->image_path)
                                        @if($report->image_path)
                                          <a class="text-blue-500" href="{{ Storage::disk('web')->url($report->image_path) }}" target="_blank">View Image</a>
                                        @else
                                          <span class="text-gray-500 text-sm">No image</span>
                                        @endif
                                        @else
                                        <span class="text-gray-500">No image</span>
                                        @endif
                                    </td>
                                <td class="px-4 py-2">{{ $report->created_at}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <a href="" class="justify-end flex w-full underline text-xs hover:text-blue-500 duration-300 p-1">Download Report</a>
                <div class="mt-6 flex justify-center">
                    {{ $reports->onEachSide(1)->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div> 
    </div>
</x-admin>