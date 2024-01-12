<?php

namespace App\Http\Controllers\Auth;
use App\Http\Requests\Auth\ForgetPasswordRequest;
use App\Notifications\ResetPasswordVerificationNotification;

use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
      public function forgetPassword(ForgetPasswordRequest $request){
            $input = $request->Only('email');
            $user = User::where('email' ,$input)->first();
            $user->notify(new ResetPasswordVerificationNotification());
            $success['success'] = true;
            return response()->json($success,200);


            
      }
}
