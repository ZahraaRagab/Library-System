@extends('layouts.app')

@section('content')
<div class="container">
    <h1>My Dashboard</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <h2>Borrowed Books</h2>
    @if($borrowedBooks->isEmpty())
        <p>You have not borrowed any books.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Book Title</th>
                    <th>Borrowed At</th>
                    <th>Return Due At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($borrowedBooks as $borrow)
                    <tr>
                        <td>{{ $borrow->book->title }}</td>
                        <td>{{ $borrow->borrowed_at->format('d-m-Y H:i:s') }}</td>
                        <td>{{ $borrow->return_due_at->format('d-m-Y H:i:s') }}</td>
                        <td>
                            <form action="{{ route('books.return', $borrow->book->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Return Book</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
