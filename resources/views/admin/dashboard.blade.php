@extends('layout')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">📊 Admin Dashboard</h2>

    <div class="row text-center mb-4">
        <div class="col-md-6">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <h4>Total Users 👤</h4>
                    <h2>{{ $userCount }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-6 mt-3 mt-md-0">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <h4>Total Articles (Books) 📚</h4>
                    <h2>{{ $bookCount }}</h2>
                </div>
            </div>
        </div>
    </div>

    <h4 class="mb-3">📘 All Articles Overview</h4>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>ISBN</th>
                    <th>Category</th>
                    <th>Published Year</th>
                    <th>Posted By</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                    <tr>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->isbn }}</td>
                        <td>{{ $book->category->name ?? 'N/A' }}</td>
                        <td>{{ $book->published_year }}</td>
                        <td>{{ $book->user->name ?? 'Unknown' }}</td>
                        <td>
                            <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center">No books found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
