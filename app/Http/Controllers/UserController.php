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

            // Retrieve the role ID
            $roleId = $request->input('role_id');

            // Create a user with the role ID
            $user = new User($validatedData);
            $user->role_id = $roleId;
            $user->save();

            // Retrieve the role name related with the user's role_id
            $roleName = Role::find($roleId)->name;

            return response()->success(['user' => $user, 'role_name' => $roleName], 'User created successfully');
        } catch (\Throwable $th) {
            return response()->error('Something went wrong: ');
        }
    }

    public function show(Request $request, User $user)
    {
        try {

            $roleName = $user->role()->value('name');

            return response()->success(['user' => $user,'role_name' => $roleName], 'User retrieved successfully');
        } catch (\Throwable $th) {
            return response()->error('Something went wrong: '.$th->getMessage());
        }
    }


    public function update(UserUpdateRequest $request, User $user)
    {
        try {
            $validatedData = $request->validated();

            // Retrieve the role ID
            $roleId = $request->input('role_id');

            // Update the user's role_id
            $user->role_id = $roleId;
            $user->save();

            return response()->success($user, 'User updated successfully');
        } catch (\Throwable $th) {
            return response()->error('Something went wrong: '.$th->getMessage());
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
