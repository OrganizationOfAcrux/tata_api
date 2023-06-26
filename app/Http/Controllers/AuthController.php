<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
// use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where(['email'=>$request->email])->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->error('The email and password you enter is incorrect');
        } else {
            $request->session()->put('user', $user);
            return response()->success($user, 'login successfull');
        }
    }

    public function forgetPassword(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return response()->error('No user exists with this email');
            } else {
                //this is the method how to give the value ot the reset_token
                $resetToken = Str::random(64);
                $user->reset_token = $resetToken;
                $user->save();

                return response()->success(['token' => $user->reset_token], '');
            }
        } catch (\Throwable $th) {
            return response()->error('somthing went wrong ' . $th->getMessage());
        }
    }


    public function resetPassword(Request $request)
    {
        try {
            $password = $request->input('password');
            $confirmPassword = $request->input('confirm_password');
            $resetToken = $request->input('reset_token');

            // Find the user based on the given reset_token
            $user = User::where('reset_token', $resetToken)->first();

            if ($user) {
                if ($password === $confirmPassword) {
                    $user->password = Hash::make($password);
                    $user->save();

                    //reset_token value null after the password was reset
                    $user->reset_token = null;
                    $user->save();

                    return response()->success([], 'Password reset successfully');
                } else {
                    return response()->error('Confirm password does not match with password');
                }
            } else {
                return response()->error('Invalid reset token');
            }
        } catch (\Throwable $th) {
            return response()->error('Something went wrong');
        }
    }


}
