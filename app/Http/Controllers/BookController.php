<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->success(book::paginate(), '');
        } catch (\Throwable $th) {
            return response()->error('somthing went wrong', 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookStoreRequest $request)
    {
        try {
            return response()->success(Book::create($request->validated()), 'created successfully');
        } catch (\Throwable $th) {
            return response()->error('somthing went wrong', 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Book $book)
    {
        try {
            return response()->success($book, 'retrive successfull');
        } catch (\Throwable $th) {
            return response()->error('somthing went wrong', 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookUpdateRequest $request, Book $book)
    {
        try {
            $book->update($request->validated());
            return response()->success($book, 'updated successfully');
        } catch (\Throwable $th) {
            return response()->error('somthing went wrong', 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Book $book)
    {
        try {
            return response()->success($book->delete(), "deleted successfully.");
        } catch (\Throwable $th) {
            return response()->error('Something went wrong.', 404);
        }
    }

}
