@extends('layouts.app')

@section('content')
<div class="container">
    <h1>All Borrowed Books</h1>

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

    @if($borrowedBooks->isEmpty())
        <p>No books have been borrowed.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Book Title</th>
                    <th>Borrowed By</th>
                    <th>Borrowed At</th>
                    <th>Return Due At</th>
                    <th>Returned At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($borrowedBooks as $borrow)
                    <tr>
                        <td>{{ $borrow->book->title }}</td>
                        <td>{{ $borrow->user->name }}</td>
                        <td>{{ $borrow->borrowed_at->format('d-m-Y H:i:s') }}</td>
                        <td>{{ $borrow->return_due_at->format('d-m-Y H:i:s') }}</td>
                        <td>{{ $borrow->returned_at ? $borrow->returned_at->format('d-m-Y H:i:s') : 'Not Returned' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
