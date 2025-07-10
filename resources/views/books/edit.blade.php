@extends('layout')

@section('content')
<h2>✏️ Edit Book</h2>

<form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $book->title) }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Author</label>
        <input type="text" name="author" class="form-control" value="{{ old('author', $book->author) }}">
    </div>
    <div class="mb-3">
        <label class="form-label">ISBN</label>
        <input type="text" name="isbn" class="form-control" value="{{ old('isbn', $book->isbn) }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Category</label>
        <select name="category_id" class="form-select">
            <option value="">-- Select Category --</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Published Year</label>
        <input type="number" name="published_year" class="form-control" value="{{ old('published_year', $book->published_year) }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control">{{ old('description', $book->description) }}</textarea>
    </div>

    {{-- Show existing cover image --}}
    @if($book->cover_image_path)
    <div class="mb-3">
        <label class="form-label">Current Cover Image</label><br>
        <img src="{{ asset('storage/' . $book->cover_image_path) }}" alt="Cover Image" style="max-height: 200px; max-width: 150px; object-fit: contain;">
    </div>
    @endif

    {{-- New cover image upload --}}
    <div class="mb-3">
        <label class="form-label">Change Cover Image (optional)</label>
        <input type="file" name="cover_image_path" class="form-control" accept="image/*">
    </div>

    <button type="submit" class="btn btn-success">Update Book</button>
</form>
@endsection
