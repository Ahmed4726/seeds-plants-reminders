<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;

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
}
