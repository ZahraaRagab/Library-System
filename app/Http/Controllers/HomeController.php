<?php
namespace App\Http\Controllers;

use App\Models\Book; // Import the Book model
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Fetch all books from the database
        $books = Book::all();
        $user = auth()->user();

        // Pass books data to the view
        return view('home', compact('books', 'user'));
    }
}
