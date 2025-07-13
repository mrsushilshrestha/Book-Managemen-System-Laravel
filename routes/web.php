<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\Admin\UserController;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
// use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::get('/', [BookController::class, 'index'])->name('books.index');

// Route::middleware('auth')->group(function () {
//     Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
//     Route::post('/books', [BookController::class, 'store'])->name('books.store');
//     Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
//     Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
//     Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
// });

Route::middleware('auth')->group(function () {
    Route::resource('books', BookController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
});

// Authenticated Admin Users with Active Status
Route::middleware(['auth', 'check.status', 'admin'])->prefix('admin')->name('admin.')->group(function () {  
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Manage Users (admin can create/edit/delete users)
    Route::resource('users', UserController::class)->except(['show']);

    // Manage Categories (admin can create/edit/delete categories)
    Route::resource('categories', CategoryController::class)->except(['show']); 

});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);


// ✅ Email verification notice (after register)
Route::get('/email/verify', function () {
    return view('auth.verify_code', [
        'email' => auth()->user()->email
    ]);
})->middleware('auth')->name('verification.notice');


Route::post('/register/complete', [AuthController::class, 'completeRegister'])->name('register.complete');



// ✅ Handle the email verification link
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // Mark email as verified
    return redirect('/'); // or redirect wherever you want
})->middleware(['auth', 'signed'])->name('verification.verify');

// ✅ Resend email verification link
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
