<?php

namespace App\Http\Controllers;

use App\Mail\VerificationEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        $user = Auth::user();

        // Check if email has changed
        if ($user->email !== $request->email) {
            $user->email = $request->email;
            $user->email_verified_at = null; // Set email_verified_at to null
            // Send email notification
            Mail::to($user->email)->send(new VerificationEmail($user));
        }

        $user->name = $request->name;
        $user->save();

        return back()->with('success', 'Profile updated successfully');
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with(['error' => 'Current password is incorrect']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password updated successfully');
    }

    public function destroy()
    {
        $user = Auth::user();
        Auth::logout();

        $user->delete();

        return redirect('/login')->with('error', 'Account deleted successfully');
    }
}
