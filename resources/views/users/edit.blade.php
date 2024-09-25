@extends('layouts.app')

@section('content')
<div class="flex justify-start max-w-2xl" x-data="order"> 
    <div class="container mx-auto p-4 max-w-2xl">  <!-- Adjusted max-w to make it larger -->
        <h1 class="text-2xl font-bold mb-6 text-white text-left">Edit User</h1>
        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('users.update', $user->id) }}" class="bg-gray-800 p-12 rounded-lg shadow-md">
            @csrf
            @method('PUT')  <!-- Include method spoofing for PUT request -->
            
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-300">Username:</label>
                <input type="username" id="username" name="username" value="{{ old('username', $user->username) }}" class="mt-1 block w-full px-3 py-2 border border-gray-400 bg-gray-600 text-white rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500" disabled readonly>
            </div>

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-300">Name:</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full px-3 py-2 border border-gray-700 bg-gray-900 text-white rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-300">Email:</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full px-3 py-2 border border-gray-700 bg-gray-900 text-white rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-300">Password (leave blank to keep current):</label>
                <input type="password" id="password" name="password" class="mt-1 block w-full px-3 py-2 border border-gray-700 bg-gray-900 text-white rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500">
            </div>

             <!-- Dropdown for User Level -->
            <div class="mb-4">
                <label for="level" class="block text-sm font-medium text-gray-300">User Level:</label>
                <select id="level" name="level" class="mt-1 block w-full px-3 py-2 border border-gray-700 bg-gray-900 text-white rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500" required>
                    <option value="" disabled>Select user level</option>
                    <option value="admin" {{ (old('level', $user->level) == 'admin') ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ (old('level', $user->level) == 'user') ? 'selected' : '' }}>User</option>
                </select>
            </div>

            <button type="submit" class="w-full py-2 px-4 bg-blue-600 text-white rounded-md hover:bg-blue-700">Update User</button>
        </form>
    </div>
</div>
@endsection
