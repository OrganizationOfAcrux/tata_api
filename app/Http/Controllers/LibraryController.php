<?php

namespace App\Http\Controllers;

use App\Models\Library;
use App\Models\User;
use App\Models\Book;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function getTotalBook()
    {
        try {
            $sum = Book::sum('available');
            $assignedBooks = Library::count();
            $Students = Library::distinct('user_id')->count();
            $remainingBooks = $sum - $assignedBooks;

            return response()->success(['total_books' => $sum , 'assigned_books' => $assignedBooks , 'remaining_books' => $remainingBooks,'students' => $Students,], '');
        } catch (\Throwable $th) {
            return response()->error('somthing went wrong ' . $th->getMessage(), 404);
        }
    }


    public function search($search)
    {
        try {
            $users = User::where('first_name', 'like', "%".$search."%")->get(['id','first_name','last_name']);
            return response()->success($users, '');
        } catch (\Throwable $th) {
            return response()->error('somthing went wrong', 404);
        }
    }


    public function assignBookToUser(Request $request)
    {
        try {
            // Retrieve the user and book IDs from the request
            $userId = $request->input('user_id');
            $bookId = $request->input('book_id');


            $library = new Library();
            $library->user_id = $request->user_id;
            $library->book_id = $request->book_id;
            $library->save();

            return response()->success('Book assigned to user successfully', '');
        } catch (\Throwable $th) {
            return response()->error('Something went wrong: ' . $th->getMessage(), 404);
        }
    }
}
