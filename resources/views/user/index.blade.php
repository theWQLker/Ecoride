@extends('layouts.app')

@section('content')
    <h1>👥 User Management</h1>
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>
                    <a href="{{ route('admin.users.edit', $user->id) }}">Edit Role</a>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
