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
}
