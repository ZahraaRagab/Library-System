<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth; // Import the Auth facade

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Display a listing of the books
    public function index()
    {
        $books = Book::all();
        $user = auth()->user();
        return view('books.index', compact('books', 'user'));
    }

    // Show the form for creating a new book
    public function create()
    {
        return view('books.create');
    }

    // Store a newly created book in storage
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'author' => 'required|string|max:255',
            'coverImage' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $coverImagePath = null;
        if ($request->hasFile('coverImage')) {
            // Get the uploaded file
            $file = $request->file('coverImage');

            // Store the file and get the path
            $coverImagePath = $file->store('covers', 'public');

            // Debugging output
            \Log::info('Cover image stored at: ' . $coverImagePath);
        } else {
            \Log::info('No cover image uploaded');
        }

        // Create the book
        Book::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'author' => $request->input('author'),
            'coverImage' => $coverImagePath,
        ]);

        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }

    // Display the specified book
    public function show($id)
    {
        $book = Book::findOrFail($id);
        $user = Auth::user();
        $borrowed = Borrow::where('book_id', $book->id)
        ->where('user_id', $user->id)
        ->whereNull('returned_at')
        ->exists();
        return view('books.show', compact('book', 'borrowed'));
    }

    // Show the form for editing the specified book
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('books.edit', compact('book'));
    }

    // Update the specified book in storage
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'author' => 'required|string|max:255',
            'coverImage' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $book = Book::findOrFail($id);

        $coverImagePath = $book->coverImage;
        if ($request->hasFile('coverImage')) {
            // Delete the old cover image if it exists
            if ($coverImagePath && Storage::exists('public/' . $coverImagePath)) {
                Storage::delete('public/' . $coverImagePath);
            }
            $coverImagePath = $request->file('coverImage')->store('covers', 'public');
        }

        $book->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'author' => $request->input('author'),
            'coverImage' => $coverImagePath,
        ]);

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    // Remove the specified book from storage
    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        // Delete the cover image if it exists
        if ($book->coverImage && Storage::exists('public/' . $book->coverImage)) {
            Storage::delete('public/' . $book->coverImage);
        }

        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }
}
