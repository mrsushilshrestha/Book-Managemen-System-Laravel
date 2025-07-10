@extends('layout')

@section('content')
<h2 class="mb-4 text-center">📘 Book List</h2>

{{-- 🔍 Filter Form --}}
<form method="GET" action="{{ route('books.index') }}" class="row mb-4 g-3">
    <div class="col-md-3">
        <select name="category_id" class="form-select">
            <option value="">-- ALL Category --</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <input type="text" name="author" class="form-control" placeholder="Author" value="{{ request('author') }}">
    </div>
    <div class="col-md-3">
        <input type="number" name="published_year" class="form-control" placeholder="Published Year" value="{{ request('published_year') }}">
    </div>
    <div class="col-md-3">
        <button type="submit" class="btn btn-primary w-100">Filter</button>
    </div>
</form>

{{-- ➕ Add Book (All Authenticated Users) --}}
@auth
    <a href="{{ route('books.create') }}" class="btn btn-success mb-4 d-block mx-auto" style="max-width: 200px;">➕ Add New Book</a>
@endauth

{{-- 📋 Book Cards --}}
<div class="row g-4">
    @forelse($books as $book)
        <div class="col-md-4 d-flex justify-content-center">
            <div class="card shadow-lg rounded-4 p-4" style="width: 100%; max-width: 320px; min-height: 350px; background: linear-gradient(135deg, rgb(233, 167, 140) 0%, rgb(221, 228, 228) 100%); display: flex; flex-direction: column;">

                {{-- 📷 Cover Image --}}
                @if($book->cover_image_path)
                    <img src="{{ asset('storage/' . $book->cover_image_path) }}" 
                         alt="Cover Image" 
                         class="mx-auto mb-3 rounded-3 border"
                         style="width: 160px; height: 260px; object-fit: cover; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                @else
                    <div class="mx-auto mb-3 rounded-3 border d-flex align-items-center justify-content-center" style="width: 160px; height: 260px; background: #e0e0e0;">
                        <span class="text-muted">No Image</span>
                    </div>
                @endif

                {{-- 📄 Book Info --}}
                <h5 class="text-center fw-bold mb-3" style="color: #333;">{{ $book->title }}</h5>
                <p><strong>Author:</strong> <span class="text-secondary">{{ $book->author }}</span></p>
                <p><strong>ISBN:</strong> <span class="text-secondary">{{ $book->isbn }}</span></p>
                <p><strong>Published:</strong> <span class="text-secondary">{{ $book->published_year }}</span></p>
                <p><strong>Category:</strong> <span class="text-secondary">{{ $book->category->name ?? 'N/A' }}</span></p>
                <p><strong>Posted by:</strong> <span class="text-secondary">{{ $book->user->name ?? 'Unknown' }}</span></p>

                {{-- ✏️🗑️ Edit/Delete Buttons (Only for Owner) --}}
                @auth
                    @if(auth()->user()->id === $book->user_id)
                        <div class="mt-auto d-flex justify-content-between">
                            <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-warning shadow-sm" style="width: 48%;">✏️ Edit</a>
                            <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="d-inline" style="width: 48%;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger shadow-sm w-100">🗑️ Delete</button>
                            </form>
                        </div>
                    @endif
                @endauth

            </div>
        </div>
    @empty
        <p class="text-center">No books found.</p>
    @endforelse
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $books->withQueryString()->links('pagination::bootstrap-5') }}
</div>


@endsection
