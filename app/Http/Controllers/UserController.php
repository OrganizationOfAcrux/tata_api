<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    // this function show all user
    public function index(Request $request)
    {
        try {
            // $perPage = $request->query('limit', 10); // Get the limit (number of users per page) from the request

            // $users = User::paginate($perPage); // Paginate the users with default pagination settings

            return response()->success(User::all(), '');
        } catch (\Throwable $th) {
            return response()->error('Something went wrong.', 404);
        }
    }

    // this is store function to store the user in DB
    public function store(UserStoreRequest $request)
    {
        try {
            return response()->success(User::create($request->validated()), 'User created successfully');
        } catch (\Throwable $th) {
            return response()->error('Something went wrong: ', 404);
        }
    }

    //this is show function to show the user by selecting the id of the user
    public function show(Request $request, User $user)
    {
        try {
            return response()->success($user, 'User retrieved successfully');
        } catch (\Throwable $th) {
            return response()->error('Something went wrong: ', 404);
        }
    }

    // this is update function to update the user record
    public function update(UserUpdateRequest $request, User $user)
    {
        try {
            $user->update($request->validated());
            return response()->success($user, 'User updated successfully');
        } catch (\Throwable $th) {
            return response()->error('Something went wrong: ', 404);
        }
    }

    // this is the delete function to delete the user
    public function destroy(Request $request, User $user)
    {
        try {
            return response()->success($user->delete(), "Users deleted successfully.");
        } catch (\Throwable $th) {
            return response()->error('Something went wrong.', 404);
        }
    }
}
