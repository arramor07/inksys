<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserRegistrationController extends Controller
{
    // Show pending + approved assistant admins
    public function index()
    {
        $pendingUsers = User::where('status', 'pending')->get();
        $approvedAdmins = User::where('role', 'assistant_admin')->get();

        return view('admin.user-registrations', compact('pendingUsers', 'approvedAdmins'));
    }

    // Approve a user as assistant admin
    public function approve($id)
    {
        $user = User::findOrFail($id);

        $user->status = 'approved';
        $user->role = 'assistant_admin';
        $user->save();

        return back()->with('success', 'User approved as Assistant Admin.');
    }

    // Delete or reject a registration (pending or assistant)
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'User deleted successfully.');
    }

    // Revoke assistant admin role but keep account
    public function revoke($id)
    {
        $user = User::findOrFail($id);

        $user->role = 'user';
        $user->status = 'approved'; // still an approved normal user
        $user->save();

        return back()->with('success', 'Assistant Admin role revoked.');
    }
}
