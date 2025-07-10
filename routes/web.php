<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;




// Route::get('/', function () {
//     return view('welcome');
// });


// Route::resource('books', BookController::class);


Route::get('/', [BookController::class, 'index'])->name('books.index');
// Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
//     Route::post('/books', [BookController::class, 'store'])->name('books.store');
//     Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
//     Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
//     Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
// });

// Route::middleware('auth')->group(function () {
//     Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
//     Route::post('/books', [BookController::class, 'store'])->name('books.store');

//     Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
//     Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
//     Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
// });

Route::middleware('auth')->group(function () {
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
});

// 🔒 Only Admins can manage categories
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('categories', CategoryController::class)->except(['show']);
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);


