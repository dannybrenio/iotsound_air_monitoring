<?php

namespace App\Http\Controllers;

use App\Models\History_status;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
     public function index()
    {
        $notifs = History_status::where('isRead', 0)->orderByDesc('created_at')->get();
        
        $users = User::latest('id') // or any ordering you need
            ->paginate(10);
            
        return view('admin.account.admin_account', compact('users', 'notifs'));
    }
}
