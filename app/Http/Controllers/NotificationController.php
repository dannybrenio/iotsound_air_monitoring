<?php

// app/Http/Controllers/NotificationController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\History_status;

class NotificationController extends Controller
{
    public function markRead(Request $request)
    {
        $data = $request->validate([
            'history_id' => 'required', // change to 'id' if that’s your PK
        ]);

        // If your column name is 'history_id':
        $updated = History_status::where('history_id', $data['history_id'])
            ->update(['isRead' => 1]);

        // If your PK is 'id', use this instead:
        // $updated = History_status::where('id', $data['history_id'])->update(['isRead' => 1]);

        return response()->json([
            'ok' => (bool) $updated,
        ]);
    }
}
