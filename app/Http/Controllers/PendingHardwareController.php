<?php

namespace App\Http\Controllers;

use App\Models\History_status;
use App\Models\Pending_hardware;

use Illuminate\Http\Request;

class PendingHardwareController extends Controller
{
    public function index(){
        $notifs = History_status::where('isRead', 0)->orderByDesc('created_at')->get();

        $pending_hardwares = Pending_hardware::all();
        return view('admin.pending.admin_pending_hardware', compact('pending_hardwares', 'notifs'));
    }
}
