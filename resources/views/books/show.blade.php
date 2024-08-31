@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">{{ $book->title }}</h1>
    @if ($book->coverImage)
        <img src="{{ asset('storage/' . $book->coverImage) }}" class="img-fluid mb-4" alt="{{ $book->title }}">
    @else
        <img src="https://via.placeholder.com/400" class="img-fluid mb-4" alt="Placeholder Image">
    @endif
    <p><strong>Author:</strong> {{ $book->author }}</p>
    <p><strong>Description:</strong> {{ $book->description }}</p>
    @auth
                        @if ($borrowed)
                            <form action="{{ route('books.return', $book->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Return Book</button>
                            </form>
                        @else
                            <form action="{{ route('books.borrow', $book->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">Borrow Book</button>
                            </form>
                        @endif
                    @endauth
</div>
@endsection
