@extends('layouts.app')

@section('content')
    <h1>✏️ Edit User Role</h1>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="role">Role:</label>
        <select name="role" id="role">
            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="driver" {{ $user->role === 'driver' ? 'selected' : '' }}>Driver</option>
            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
        </select>

        <button type="submit">Update Role</button>
    </form>
@endsection
