@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">

    <h1 class="text-2xl font-bold mb-6 text-white text-left">Users List</h1>
    <div class="mx-auto p-4">
    <a href="{{ route('users.create') }}"><button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-yellow-600"><i class="fa fa-plus"></i>  Create New User</button></a>
</div>
    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <table class="min-w-full bg-gray-800 border border-gray-700 rounded-lg mx-auto text-white">
            <thead>
                <tr class="bg-gray-900 text-gray-400">
           
                <th class="py-2 px-4 border border-gray-700 text-center">Username</th>
                <th class="py-2 px-4 border border-gray-700 text-center">Name</th>
                <th class="py-2 px-4 border border-gray-700 text-center">Email</th>
                <th class="py-2 px-4 border border-gray-700 text-center">Level</th>
                <th class="py-2 px-4 border border-gray-700 text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr class="hover:bg-gray-700 text-sm">
            <td class="py-2 px-4 border border-gray-700 text-center">{{ $user->username }}</td>
            <td class="py-2 px-4 border border-gray-700 text-center">{{ $user->name }}</td>
            <td class="py-2 px-4 border border-gray-700 text-center">{{ $user->email }}</td>
            <td class="py-2 px-4 border border-gray-700 text-center">{{ $user->level }}</td>
            <td class="py-2 px-4 border border-gray-700 text-center">
                        <a href="{{ route('users.edit', $user) }}">
                            <button class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                                <i class="fa fa-edit"></i> Edit
                            </button>
                        </a>

                        <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 ml-2">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
