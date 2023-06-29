<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->success(Role::all(), '');
        } catch (\Throwable $th) {
            return response()->error('somthing went wrong');
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleStoreRequest $request)
    {
        try {
            return response()->success(Role::create($request->validated()), '');
        } catch (\Throwable $th) {
            return response()->error('somthing went wrong');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        try {
            return response()->success($role, '');
        } catch (\Throwable $th) {
            return response()->error('somthing went wrong');
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        try {
            $role->update($request->validated());
            return response()->success($role, '');
        } catch (\Throwable $th) {
            return response()->error('somthing went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        try {
            // Check if the role is in use by any user
            $usersWithRole = User::where('role_id', $role->id)->exists();

            if ($usersWithRole) {
                return response()->error('Cannot delete the role. It is in use by some users.');
            }

            // Delete the role
            $role->delete();

            return response()->success([], 'Role deleted successfully.');
        } catch (\Throwable $th) {
            return response()->error('Something went wrong.'. $th->getMessage());
        }
    }


    public function edit(Role $role)
    {
        try {
            $roleCopy = new Role();
            $roleCopy->name = $role->name .'-copy';
            $roleCopy->discription = $role->discription;
            $roleCopy->save();

            return Response()->success($roleCopy, 'Role copied successfully');
        } catch (\Throwable $th) {
            return Response()->error('Something went wrong');
        }
    }


    //this is for get all the roles from the DB
    public function rolesList()
    {
        try {
            return response()->success(Role::get(['id','name']), '');
        } catch (\Throwable $th) {
            return response()->error('Something went wrong: ');
        }
    }
    public function rolesListPluck()
    {
        try {
            return response()->success(Role::pluck('name', 'id'), '');
        } catch (\Throwable $th) {
            return response()->error('Something went wrong: ');
        }
    }
}
