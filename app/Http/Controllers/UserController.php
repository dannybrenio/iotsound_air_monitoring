<?php

namespace App\Http\Controllers;

use App\Models\History_status;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
     public function index()
    {
        $notifs = History_status::where('isRead', 0)->get();

        $users = User::all();
        return view('admin.account.admin_account', compact('users', 'notifs'));
    }
}
