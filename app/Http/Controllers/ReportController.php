<?php

namespace App\Http\Controllers;

use App\Models\History_status;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class ReportController extends Controller
{
    public function index()
    {
        $notifs = History_status::where('isRead', 0)->orderByDesc('created_at')->get();

        $reports = Report::paginate(10);
        return view('admin.report.admin_report', compact('reports', 'notifs'));
    }
    
    public function receiveReport(Request $request)
    {
        $validated = $request->validate([
            'user_id'     => 'required',
            'description' => 'required|string|max:2000',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);
    
        $path = null;
    
        if ($request->hasFile('image')) {
            // stores to public_html/storage/reports and returns "reports/<file>"
            $path = $request->file('image')->store('reports', 'web');
        }
    
        // Log what we actually wrote
        Log::info('receive-report', [
            'disk' => 'web',
            'path' => $path,
            'url'  => $path ? Storage::disk('web')->url($path) : null,
        ]);
    
        // Save only the relative path (e.g., "reports/foo.png")
        $report = Report::create([
            'user_id'     => $validated['user_id'],
            'report_body' => $validated['description'],
            'image_path'  => $path,
        ]);
    
        return response()->json([
            'ok'         => true,
            'image_url'  => $path ? Storage::disk('web')->url($path) : null,
            'id'         => $report->id ?? null,
        ]);
    }


}