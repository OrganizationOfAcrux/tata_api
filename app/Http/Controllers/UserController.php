<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    public function index(Request $request)
    {
        try {
            return response()->success(User::all(), '');
        } catch (\Throwable $th) {
            return response()->error('Something went wrong.', 404);
        }
    }


    public function store(UserStoreRequest $request)
    {
        try {
            return response()->success(User::create($request->validated()), 'User created successfully');
        } catch (\Throwable $th) {
            return response()->error('Something went wrong: ', 404);
        }
    }

    public function show(Request $request, User $user)
    {
        try {
            return response()->success($user, 'User retrieved successfully');
        } catch (\Throwable $th) {
            return response()->error('Something went wrong: ', 404);
        }
    }


    public function update(UserUpdateRequest $request, User $user)
    {
        try {
            $user->update($request->validated());
            return response()->success($user, 'User updated successfully');
        } catch (\Throwable $th) {
            return response()->error('Something went wrong: ', 404);
        }
    }


    public function destroy(Request $request, User $user)
    {
        try {
            return response()->success($user->delete(), "Users deleted successfully.");
        } catch (\Throwable $th) {
            return response()->error('Something went wrong.', 404);
        }
    }

}
