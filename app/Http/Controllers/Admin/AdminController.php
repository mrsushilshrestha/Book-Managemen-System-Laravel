<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use App\Models\Category;

class AdminController extends Controller
{
    
     //dashboard
    public function dashboard()
    {
        $userCount = User::count();
        $bookCount = Book::count();

        // Fetch all books with their relations
        $books = Book::with(['user', 'category'])->latest()->get();

        return view('admin.dashboard', compact('userCount', 'bookCount', 'books'));
    }

}
