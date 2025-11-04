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

        $reports = Report::all();
        return view('admin.report.admin_report', compact('reports', 'notifs'));
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
        $path = $request->file('image')->store('reports', 'public');
      }
  
      Log::info('receive-report', [
          'path'   =>  $path ? Storage::url($path) : null,
      ]);
    
      Report::create([
        "user_id" =>  $validated["user_id"],
        "report_body" =>  $validated["description"],
        "image_path" =>  $path ? Storage::url($path) : null,
      ]);

      return response()->json([
        'ok'          => true,
        'description' => $validated['description'],
        'image_path'  => $path ? Storage::url($path) : null,
      ]);
    }

}