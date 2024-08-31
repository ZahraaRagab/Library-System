<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\BorrowController;



Route::get('/', function () {
    return view('welcome');


    // Authentication Routes...
Auth::routes();
});

Auth::routes();




Route::resource('books', BookController::class);

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/', [HomeController::class, 'index'])->name('home');




Route::prefix('admin')->middleware(['auth', AdminMiddleware::class])->group(function () {
    // Route::get('/profile/edit', [AdminController::class, 'editProfile'])->name('admin.editProfile');
    // Route::post('/profile/update', [AdminController::class, 'updateProfile'])->name('admin.updateProfile');
    Route::get('/users', [AdminController::class, 'listUsers'])->name('admin.listUsers');
    Route::get('/users/{id}', [AdminController::class, 'showUser'])->name('admin.showUser');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.editUser');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('admin.updateUser');
    Route::get('/borrowed-books', [AdminController::class, 'listBorrowedBooks'])->name('admin.borrowedBooks');
});



// Routes for borrowing and returning books
Route::middleware('auth')->group(function () {
    Route::post('/books/{book}/borrow', [BorrowController::class, 'borrowBook'])->name('books.borrow');
    Route::post('/books/{book}/return', [BorrowController::class, 'returnBook'])->name('books.return');
});


// Routes for student dashboard
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [BorrowController::class, 'dashboard'])->name('student.dashboard');
});
