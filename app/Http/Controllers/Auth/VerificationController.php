<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class VerificationController extends Controller
{
    public function verify($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->email_verified_at = now();
            $user->save();

            return redirect('/')->with('success', 'Email verified successfully.');
        }

        return redirect('/')->with('error', 'Invalid verification link.');
    }

    public function verifyEmail($id, $hash)
    {
        $user = User::findOrFail($id);

        // Verify the hash of the user's email
        // if (! Hash::check($user->getEmailForVerification(), $hash)) {
        //     abort(403, 'Invalid verification link.');
        // }

        // Mark the user as verified
        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return redirect()->route('login')->with('success', 'Your email has been verified. You can now log in.');
    }
}
