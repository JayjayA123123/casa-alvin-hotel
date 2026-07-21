<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * List every registered user with their bookings count.
     */
    public function index()
    {
        $users = User::withCount('bookings')->latest()->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Promote/demote a user between 'customer' and 'admin'.
     */
    public function updateRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|in:customer,admin',
        ]);

        // Iwas ma-lock-out ang sarili niyang account bilang huling admin.
        if ($user->id === auth()->id() && $validated['role'] !== 'admin') {
            return back()->withErrors(['role' => 'Hindi mo puwedeng tanggalin ang admin role ng sarili mong account.']);
        }

        $user->update($validated);

        return back()->with('success', "Na-update ang role ni {$user->name} to \"{$validated['role']}\".");
    }
}
