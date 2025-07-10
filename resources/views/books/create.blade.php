 @extends('layout')

@section('content')
<h2>Add New Book</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('books.store') }}" method="POST"  enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" value="{{ old('title') }}"required>
    </div>
    <div class="mb-3">
        <label class="form-label">Author</label>
        <input type="text" name="author" class="form-control" value="{{ old('author') }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">ISBN</label>
        <input type="text" name="isbn" class="form-control" value="{{ old('isbn') }}" required>
    </div>
    <div class="mb-3">
    <label class="form-label">Category</label>
    <select name="category_id" class="form-control">
        <option value="{{ old('category_id') }}">Select a Category</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Published Year</label>
        <input type="number" name="published_year" class="form-control" value="{{ old('published_year') }}" required>
    </div>
    
    <div class="mb-3">
    <label class="form-label">Cover Image</label>
    <input type="file" name="cover_image_path" class="form-control">
    @error('cover_image_path')
        <div class="text-danger">{{ $message }}</div>
    @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" value="{{ old('description') }}"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Save Book</button>
</form>
@endsection 

