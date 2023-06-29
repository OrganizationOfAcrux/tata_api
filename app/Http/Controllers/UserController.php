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
            $users = User::with('role')->get();
            return response()->success($users, '');
        } catch (\Throwable $th) {
            return response()->error('Something went wrong: ');
        }
    }


    public function store(UserStoreRequest $request)
    {
        try {
            $validatedData = $request->validated();

            // Retrieve the role ID from the request
            $roleId = $request->input('role_id');

            // Create a new user with the role ID assigned
            $user = new User($validatedData);
            $user->role_id = $roleId;
            $user->save();

            // Retrieve the role name associated with the user's role_id
            $roleName = Role::find($roleId)->name;

            // Create a response array with user data and role name
            $responseData = [
                'user' => $user,
                'role_name' => $roleName,
            ];

            return response()->success($responseData, 'User created successfully');
        } catch (\Throwable $th) {
            return response()->error('Something went wrong: '.$th->getMessage());
        }
    }


    public function show(User $user)
    {
        try {
            $user->load('role');
            $roleName = $user->role->name;

            $responseData = [
                'user' => $user,
                'role_name' => $roleName,
            ];

            return response()->success($responseData, 'User retrieved successfully');
        } catch (\Throwable $th) {
            return response()->error('Something went wrong: '.$th->getMessage());
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
