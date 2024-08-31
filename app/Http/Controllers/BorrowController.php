<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BorrowController extends Controller
{
    // Borrow a book
    public function borrowBook(Book $book)
    {
        $user = Auth::user();

        // Check if the book is already borrowed by the user
        if (Borrow::where('book_id', $book->id)
                  ->where('user_id', $user->id)
                  ->whereNull('returned_at')
                  ->exists()) {
            return redirect()->route('student.dashboard')->with('error', 'You have already borrowed this book.');
        }

        // Borrow the book
        Borrow::create([
            'book_id' => $book->id,
            'user_id' => $user->id,
            'borrowed_at' => Carbon::now(),
            'return_due_at' => Carbon::now()->addWeek(), // Set return date to 1 week later
        ]);

        return redirect()->route('student.dashboard')->with('success', 'Book borrowed successfully.');
    }

    // Return a book
    public function returnBook(Book $book)
    {
        $user = Auth::user();

        // Find the borrowed book record
        $borrow = Borrow::where('book_id', $book->id)
                        ->where('user_id', $user->id)
                        ->whereNull('returned_at')
                        ->first();

        if (!$borrow) {
            return redirect()->route('student.dashboard')->with('error', 'You have not borrowed this book.');
        }

        // Mark the book as returned
        $borrow->returned_at = Carbon::now();
        $borrow->save();

        return redirect()->route('student.dashboard')->with('success', 'Book returned successfully.');
    }


    public function dashboard()
    {
        $user = Auth::user();

        // Get borrowed books
        $borrowedBooks = Borrow::where('user_id', $user->id)
                               ->whereNull('returned_at')
                               ->with('book') // Load book details
                               ->get();

        return view('student.dashboard', compact('borrowedBooks'));
    }
}
