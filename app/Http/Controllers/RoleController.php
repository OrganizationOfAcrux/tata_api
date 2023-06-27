<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
    public function store(Request $request)
    {
        try {
            $data = [
            'name' => $request->name,
            'discription' => $request->discription,
            ];

            $role = Role::create($data);
            return response()->success($role, '');
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
    public function update(Request $request, Role $role)
    {
        try {
            $role->name = $request->name;
            $role->discription = $request->discription;
            $role->update();
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
            $role->delete();
            return response()->success([], "role deleted successfully.");
        } catch (\Throwable $th) {
            return response()->error('Something went wrong.');
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

}
