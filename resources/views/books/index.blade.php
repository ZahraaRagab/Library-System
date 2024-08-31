@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Books</h1>
    @if($user->isAdmin)
    <a href="{{ route('books.create') }}" class="btn btn-primary mb-3">Add New Book</a>
    @endif
    <div class="row">
        @foreach ($books as $book)
            <div class="col-md-4 mb-4">
                <div class="card">
                    @if ($book->coverImage)
                        <img src="{{ asset('storage/' . $book->coverImage) }}" class="card-img-top" alt="{{ $book->title }}">
                    @else
                        <img src="https://via.placeholder.com/150" class="card-img-top" alt="Placeholder Image">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $book->title }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">by {{ $book->author }}</h6>
                        <p class="card-text">{{ Str::limit($book->description, 100) }}</p>
                        <a href="{{ route('books.show', $book->id) }}" class="btn btn-info">View</a>
                        @if($user->isAdmin)
                       <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        @endif

                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
