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


    public function searchSubject(Request $request, $class)
    {
        try {
            $subjects = Book::where('class', $class)->get(['id', 'subject']);

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

            $errorMessage = '';

            // Iterate over each book ID and check if it is already assigned to the user
            foreach ($bookIds as $bookId) {
                $existingAssignment = Library::where('user_id', $userId)->where('book_id', $bookId)->first();

                // If the book is already assigned to the user, add an error message
                if ($existingAssignment) {
                    $errorMessage .= "Book with ID $bookId is already assigned to you. ";
                    continue;
                }

                // Assign the book to the user
                $library = new Library();
                $library->user_id = $userId;
                $library->book_id = $bookId;
                $library->save();
            }

            if (!empty($errorMessage)) {
                return response()->error($errorMessage, 400);
            }
            return response()->success('Book assigned to user successfully', '');
        } catch (\Throwable $th) {
            return response()->error('Something went wrong: ' . $th->getMessage(), 404);
        }
    }
}
