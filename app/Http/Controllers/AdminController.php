<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Borrow; // Import the Borrow model

class AdminController extends Controller
{
    /**
     * Constructor to apply middleware
     */
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('admin'); // Ensures that only admins can access these methods
    }

    /**
     * Show the form for searching users by ID.
     *
     * @return \Illuminate\View\View
     */


      // List all borrowed books
      public function listBorrowedBooks()
      {
          // Get all borrowed books with user and book details
          $borrowedBooks = Borrow::with('book', 'user')->get();

          return view('admin.borrowed-books', compact('borrowedBooks'));
      }

    /**
     * Show the form for updating the admin's profile.
     *
     * @return \Illuminate\View\View
     */
    public function editProfile()
    {
        $admin = Auth::user();
        return view('admin.edit-profile', compact('admin'));
    }

    /**
     * Update the admin's profile.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        $admin = Auth::user();
        $admin->name = $request->input('name');
        $admin->email = $request->input('email');
        $admin->save();

        return redirect()->route('admin.editProfile')->with('success', 'Profile updated successfully.');
    }

    /**
     * Display a listing of all users.
     *
     * @return \Illuminate\View\View
     */
    public function listUsers(Request $request)
    {
        $search = $request->input('search');
        $query = User::query();

        if ($search) {
            $query->where('id', $search)  // Search by user ID
                  ->orWhere('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
        }

        $users = $query->where('isAdmin', false)->get();

        return view('admin.list-users', compact('users'));
    }
    /**
     * Show user details by ID.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function showUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('admin.listUsers')->with('error', 'User not found.');
        }

        return view('admin.user-details', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function editUser($id)
    {
        $user = User::find($id);
        return view('admin.edit-user', compact('user'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('admin.listUsers')->with('error', 'User not found.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'isAdmin' => 'nullable|boolean',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->isAdmin = $request->input('isAdmin', $user->isAdmin);

        $user->save();

        return redirect()->route('admin.showUser', $id)->with('success', 'User profile updated successfully.');
    }
}
