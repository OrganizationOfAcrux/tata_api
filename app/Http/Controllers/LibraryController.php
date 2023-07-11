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

            $assignedBooksCount = Library::where('user_id', $userId)->count();

            // Calculate the remaining available slots for the user
            $availableSlots = 5 - $assignedBooksCount;

            // Check if the user has available slots to assign books
            if ($availableSlots >= count($bookIds)) {
                // Iterate over each book ID and assign it to the user
                foreach ($bookIds as $bookId) {
                    // Check if the user has already taken the book
                    $existingAssignment = Library::where('user_id', $userId)->where('book_id', $bookId)->first();

                    if ($existingAssignment) {
                        return response()->error('you already take this ID ' . $bookId . ' book', 400);
                    }

                    // Assign the book to the user
                    $library = new Library();
                    $library->user_id = $userId;
                    $library->book_id = $bookId;
                    $library->save();
                }

                return response()->success('Book assigned to user successfully', '');
            } else {
                return response()->error('The user has reached the maximum number of books (5) assigned', 400);
            }
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


    public function history(Request $request, $user_id)
    {
        try {
            $libraries = Library::with(['user', 'book'])
                ->withTrashed()
                ->where('user_id', $user_id)
                ->orderBy('created_at', 'desc') // Order by created_at column in descending order
                ->get();

            if ($libraries->isEmpty()) {
                return response()->error('No library entries found for the user', 404);
            }

            $data = $libraries->map(function ($library) {
                return [
                    'id' => $library->id,
                    'user_id' => $library->user_id,
                    'user_name' => $library->user->first_name,
                    'book_name' => $library->book->subject,
                    'created_at' => $library->created_at,
                    'deleted_at' => $library->deleted_at
                ];
            });

            return response()->success(['libraries' => $data], 'Library entries retrieved successfully');
        } catch (\Throwable $th) {
            return response()->error('Something went wrong: ' . $th->getMessage(), 404);
        }
    }
}
