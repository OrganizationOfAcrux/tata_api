<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        try {
            return response()->success(User::all(), '');
        } catch (\Throwable $th) {
            return response()->error('somthing went wrong');
        }
    }


    public function store(Request $request)
    {
        try {
            $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => $request->password,
            ];

            $user = User::create($data);
            return response()->success($user, '');
        } catch (\Throwable $th) {
            return response()->error('somthing went wrong');
        }
    }


    public function show(User $user)
    {
        try {
            return response()->success($user, '');
        } catch (\Throwable $th) {
            return response()->error('somthing went wrong');
        }
    }

    public function update(Request $request, User $user)
    {
        try {
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->phone_number = $request->phone_number;
            $user->update();
            return response()->success($user, '');
        } catch (\Throwable $th) {
            return response()->error('somthing went wrong');
        }
    }

    // this is the function of delete but it's the deleting multiple in the destroy funnction
    public function destroy(Request $request)
    {
        try {
            $message = 'Users deleted successfully.';
            foreach ($request->ids as  $id) {
                $user = User::find($id);

                if ($user->id == session()->get('user')->id) {
                    $message = "You can't delete your self";
                } else {
                    $user->delete();
                }
            }
            return response()->success([], $message);
        } catch (\Throwable $th) {
            return response()->error('Something went wrong.'.$th->getMessage());
        }
    }
}
