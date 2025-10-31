<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::all();
        return view('admin.report.admin_report', compact('reports'));
    }

    // api to receive report from mobile
    public function receiveReport(Request $request)
    {
      $validated = $request->validate([
        'user_id' => 'required',
        'description' => 'required|string|max:2000',
        'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
      ]);
      
      $file = $request->file('image');

        Log::info('receive-report', [
            'has_file'   => $file !== null,
            'orig_name'  => $file?->getClientOriginalName(),
            'mime'       => $file?->getMimeType(),
            'size'       => $file?->getSize(),
            'desc'       => $validated['description'],
        ]);

      $path = null;
      if ($request->hasFile('image')) {
        // store to storage/app/public/reports
        $path = $request->file('image')->store('reports', 'public');
      }

      // TODO: Save to DB if you want
      // Report::create([...]);

      return response()->json([
        'ok'          => true,
        'description' => $validated['description'],
        'image_path'  => $path ? Storage::url($path) : null,
      ]);
    }

}