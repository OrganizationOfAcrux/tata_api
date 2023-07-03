<?php

namespace App\Http\Controllers;

use App\Models\Library;
use Illuminate\Http\Request;
use App\Http\Requests\LibraryStoreRequest;
use App\Http\Requests\LibraryUpdateRequest;

class LibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->success(Library::all(), '');
        } catch (\Throwable $th) {
            return response()->error('somthing went wrong', 404);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(LibraryStoreRequest $request)
    {
        try {
            return response()->success(Library::create($request->validated()), 'created successfully');
        } catch (\Throwable $th) {
            return response()->error('somthing went wrong', 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Library $library)
    {
        try {
            return response()->success($library, 'retrive successfull');
        } catch (\Throwable $th) {
            return response()->error('somthing went wrong', 404);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(LibraryUpdateRequest $request, Library $library)
    {
        try {
            $library->update($request->validated());
            return response()->success($library, 'updated successfully');
        } catch (\Throwable $th) {
            return response()->error('somthing went wrong', 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Library $library)
    {
        try {
            return response()->success($library->delete(), "deleted successfully.");
        } catch (\Throwable $th) {
            return response()->error('Something went wrong.', 404);
        }
    }
}
