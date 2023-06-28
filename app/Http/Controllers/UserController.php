<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    public function index(Request $request)
    {
        try {
            return response()->success(User::all(), '');
        } catch (\Throwable $th) {
            return response()->error('somthing went wrong');
        }
    }


    public function store(UserStoreRequest $request)
    {
        try {
            return response()->success(User::create($request->validated()), '');
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

    public function update(UserUpdateRequest $request, User $user)
    {
        try {
            $user->update($request->validated());
            return response()->success($user, '');
        } catch (\Throwable $th) {
            return response()->error('somthing went wrong');
        }
    }


    public function destroy(Request $request, User $user)
    {
        try {
            $user->delete();
            return response()->success([], "Users deleted successfully.");
        } catch (\Throwable $th) {
            return response()->error('Something went wrong.');
        }
    }

}
