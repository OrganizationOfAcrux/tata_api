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

            $user = User::find($userId);
            if ($user) {
                foreach ($bookIds as $bookId) {
                    if ($user->books->contains($bookId)) {
                        // User has already taken the book
                        $book = $user->books->find($bookId);
                        $book->makeHidden(['subject']);
                    }
                }
            }


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
            $libraries = Library::with(['user' => function ($query) {
                $query->select('id', 'first_name');
            }, 'book' => function ($query) {
                $query->select('id', 'subject', 'class');
            }])->get(['id', 'user_id', 'book_id']);

            $formattedLibraries = $libraries->map(function ($library) {
                return [
                    'user_name' => $library->user->first_name,
                    'book_name' => $library->book->subject,
                    'class' => $library->book->class,
                ];
            });

            return response()->success(['libraries' => $formattedLibraries], '');
        } catch (\Throwable $th) {
            return response()->error('Something went wrong.'. $th->getMessage(), 404);
        }
    }
}
