@extends('layouts.app')

@section('content')
<div class="container">
    <h1>All Users</h1>

    <!-- Search Form -->
    <form action="{{ route('admin.listUsers') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by ID, name, or email" value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>

    <div class="row">
        @if($users->isEmpty())
            <p>No users found.</p>
        @else
            @foreach ($users as $user)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">ID: {{ $user->id }}</h5>
                            <h5 class="card-title">Name: {{ $user->name }}</h5>
                            <p class="card-text">Email: {{ $user->email }}</p>
                            <a href="{{ route('admin.showUser', $user->id) }}" class="btn btn-info">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
