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
            return response()->error('somthing went wrong', 404);
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
            return response()->error('somthing went wrong', 404);
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
            return response()->error('somthing went wrong', 404);
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
            return response()->error('somthing went wrong', 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        try {
            if ($role->users()->exists()) {
                return response()->error('Role is in use.', 400);
            } else {
                $role->delete();
                return response()->success([], 'Role deleted successfully.');
            }
        } catch (\Throwable $th) {
            return response()->error('Something went wrong.', 404);
        }
    }

    //this function is use to create the duplicate user
    public function edit(Role $role)
    {
        try {
            return Response()->success(Role::create(['name' => $role->name . '-copy','discription' => $role->discription]), 'Role copied successfully');
        } catch (\Throwable $th) {
            return Response()->error('somthing went wrong', 404);
        }
    }

    //this function is use to get the role user list using Pluck to get only name and id
    public function rolesList()
    {
        try {
            return response()->success(Role::pluck('name', 'id'), '');
        } catch (\Throwable $th) {
            return response()->error('Something went wrong: ', 404);
        }
    }
}
