<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\user;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
   
    public function index(Request $request)
{
    $query = Book::with(['category', 'user']);  

    if ($request->filled('author')) {
        $query->where('author', 'like', '%' . $request->author . '%');
        // $query->where('author',$request->author);
    }

    if ($request->filled('published_year')) {
        $query->where('published_year', $request->published_year);
        // $query->publishedAfter($request->published_year);  
    }

    if ($request->filled('category_id')) {
        $query->where('category_id', $request->category_id);
    }

    $books = $query->latest()->paginate(9);
    $categories = Category::all();

    return view('books.index', compact('books', 'categories'));
}

    

    // public function show(Book $book)
    // {
    //     return view('books.show', compact('book'));
    // }

    public function create()
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
        // return view('books.create');
        // return "Create Controller"; 
        
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string',
            'isbn' => 'required|unique:books,isbn',
            'published_year' => 'required|nullable|numeric',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            // 'cover_image_path' => 'nullable|image|max:2048',
            'cover_image_path' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',

        ],
        [
        'title.required' => 'The book title is required.',
        'author.required' => 'Please enter the author name.',
        'isbn.required' => 'ISBN is required.',
        'isbn.unique' => 'This ISBN already exists.',
        'cover_image_path.image' => 'The cover must be an image.',
        'cover_image_path.max' => 'Image must not be larger than 2MB.',
        // 'cover_image_path.mimes'=> 'We only Accept jpeg,jpg,png File Format.'
        ]);
        
        if ($request->hasFile('cover_image_path')) {
            $validated['cover_image_path'] = $request->file('cover_image_path')->store('covers', 'public');
        }
        
        
        $validated['user_id'] = auth()->id();
        
        Book::create($validated);
        

        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }

    public function edit(Book $book)
    {   
        // if (auth()->id() !== $book->user_id && auth()->user()->role !== 'admin') {
        //     abort(403);
        // }
        // if (auth()->user()->role !== 'user' && auth()->user()->role !== 'admin') {
        //     abort(403);
        // }
        if (auth()->id() !== $book->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $categories = Category::all();
        return view('books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {   
        // if (auth()->id() !== $book->user_id && auth()->user()->role !== 'admin') {
        //     abort(403);
        // }
        if (auth()->id() !== $book->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string',
            'isbn' => 'required|unique:books,isbn,' . $book->id,
            'published_year' => 'nullable|numeric',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'cover_image_path' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('cover_image_path')) {
            $validated['cover_image_path'] = $request->file('cover_image_path')->store('covers', 'public');
        }

        $book->update($validated);

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {   
        // if (auth()->id() !== $book->user_id && auth()->user()->role !== 'admin') {
        //     // return redirect()->route('books.index');
        //     abort(403);
        // }
        if (auth()->id() !== $book->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }



    //admin 
    public function dashboard()
    {
        $userCount = User::count();
        $bookCount = Book::count();

        // Fetch all books with their relations
        $books = Book::with(['user', 'category'])->latest()->get();

        return view('admin.dashboard', compact('userCount', 'bookCount', 'books'));
    }

}
