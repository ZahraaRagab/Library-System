@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit User</h1>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.updateUser', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div><br>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div><br>

        <div class="form-group">
            <label for="isAdmin">Admin Status</label>
            <select name="isAdmin" id="isAdmin" class="form-control">
                <option value="1" {{ $user->isAdmin ? 'selected' : '' }}>Admin</option>
                <option value="0" {{ !$user->isAdmin ? 'selected' : '' }}>Regular User</option>
            </select>
        </div><br>

        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
    <a href="{{ route('admin.showUser', $user->id) }}" class="btn btn-secondary mt-3">Back to Details</a>
</div>
@endsection
