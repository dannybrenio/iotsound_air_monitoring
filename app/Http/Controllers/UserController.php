<?php

namespace App\Http\Controllers;

use App\Models\History_status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $notifs = History_status::where('isRead', 0)->orderByDesc('created_at')->get();

        $users = User::latest('id')->paginate(10);

        return view('admin.account.admin_account', compact('users', 'notifs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'   => ['required', 'string', 'max:255'],
            'middle_name'  => ['nullable', 'string', 'max:255'],
            'last_name'    => ['required', 'string', 'max:255'],
            'barangay'     => ['required', 'string', 'max:255'],

            'email'        => ['required', 'email', 'max:255', 'unique:users,email'],
            'username'     => ['required', 'string', 'max:255', 'unique:users,username'],

            'password'     => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'first_name'  => $validated['first_name'],
            'middle_name' => $validated['middle_name'] ?? null,
            'last_name'   => $validated['last_name'],
            'barangay'    => $validated['barangay'],
            'email'       => $validated['email'],
            'username'    => $validated['username'],
            'password'    => Hash::make($validated['password']),
            // email_verified_at stays null by default
        ]);

        return redirect()
            ->route('account')
            ->with('success', 'Account created successfully!');
    }
    
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'first_name'  => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name'   => 'required|string|max:255',
            'barangay'    => 'required|string|max:255',
    
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
    
            'password' => 'nullable|string|min:8',
        ]);
    
        $user->update([
            'first_name'  => $validated['first_name'],
            'middle_name' => $validated['middle_name'] ?? null,
            'last_name'   => $validated['last_name'],
            'barangay'    => $validated['barangay'],
            'email'       => $validated['email'],
            'username'    => $validated['username'],
        ]);
    
        // Only update password if admin entered one
        if (!empty($validated['password'])) {
            $user->update([
                'password' => Hash::make($validated['password']),
            ]);
        }
    
        return back()->with('success', 'User updated successfully.');
    }
    
    public function destroy(User $user)
    {
        $user->delete();
    
        return back()->with('success', 'User deleted successfully.');
    }
}
