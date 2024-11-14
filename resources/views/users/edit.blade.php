@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit User</h2>
    
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" class="form-control" id="role" required>
                <option value="admin" {{ (old('role', $user->role) == 'admin') ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ (old('role', $user->role) == 'user') ? 'selected' : '' }}>User</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update User</button>
    </form>
</div>
@endsection
