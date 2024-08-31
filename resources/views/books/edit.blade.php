@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Edit Book</h1>
    <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $book->title }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4">{{ $book->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="author">Author</label>
            <input type="text" class="form-control" id="author" name="author" value="{{ $book->author }}" required>
        </div>
        <div class="form-group">
            <label for="coverImage">Cover Image</label>
            @if ($book->coverImage)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $book->coverImage) }}" class="img-thumbnail" style="width: 150px;" alt="{{ $book->title }}">
                </div>
            @endif
            <input type="file" class="form-control-file" id="coverImage" name="coverImage">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
