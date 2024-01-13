<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class ForgotPasswordController extends Controller
{
    /**
     * Handle the incoming request.
     */
   public function __invoke(Request $request)
{
    $request->validate([
        'email' => 'required|email',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    $token = Str::random(60);

    DB::table('password_resets')->insert([
        'email' => $user->email,
        'token' => $token,
        'created_at' => now(),
    ]);

    // Send email with password reset link here

    return response()->json(['message' => 'Password reset link sent']);
}
}
