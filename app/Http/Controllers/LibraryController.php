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


    public function searchSubject(Request $request)
    {
        try {
            $userId = $request->input('user_id');
            $class = $request->input('class');

            $bookIds = Library::where('user_id', $userId)->pluck('book_id')->toArray();
            $subjects = Book::where('class', $class)->whereNotIn('id', $bookIds)->get(['id', 'subject']);

            return response()->success(['subjects' => $subjects], '');
        } catch (\Throwable $th) {
            return response()->error('Something went wrong: ' . $th->getMessage(), 500);
        }
    }


    public function assignBookToUser(Request $request)
    {
        try {
            // Retrieve the user ID and book IDs from the request
            $userId = $request->input('user_id');
            $bookIds = $request->input('book_ids');

            // Iterate over each book ID and assign it to the user
            foreach ($bookIds as $bookId) {
                $library = new Library();
                $library->user_id = $userId;
                $library->book_id = $bookId;
                $library->save();
            }
            return response()->success('Book assigned to user successfully', '');
        } catch (\Throwable $th) {
            return response()->error('Something went wrong: ' . $th->getMessage(), 404);
        }
    }

    public function destroy(Request $request, Library $library)
    {
        try {
            return response()->success($library->delete(), "deleted successfully.");
        } catch (\Throwable $th) {
            return response()->error('Something went wrong.', 404);
        }
    }

    public function index(Request $request)
    {
        try {
            return response()->success(Library::paginate(), '');
        } catch (\Throwable $th) {
            return response()->error('Something went wrong: ' . $th->getMessage(), 404);
        }
    }

}
