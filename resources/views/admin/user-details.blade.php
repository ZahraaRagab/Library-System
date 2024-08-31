@extends('layouts.app')

@section('content')
<div class="container">
    <h1>User Details</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $user->name }}</h5>
            <p class="card-text">Email: {{ $user->email }}</p>
            <a href="{{ route('admin.editUser', $user->id) }}" class="btn btn-warning">Edit User</a>
        </div>
    </div>
    <a href="{{ route('admin.listUsers') }}" class="btn btn-secondary mt-3">Back to User List</a>
</div>
@endsection
