@extends('layout')

@section('content')
<h2>Add Category</h2>

<form action="{{ route('admin.categories.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Name:</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Description:</label>
        <textarea name="description" class="form-control"></textarea>
    </div>
    <button class="btn btn-success">Save</button>
</form>
@endsection
