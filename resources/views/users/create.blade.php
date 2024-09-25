@extends('layouts.app')

@section('content')
<div class="flex justify-start max-w-2xl"> 
    <div class="container mx-auto p-4 max-w-2xl">  <!-- Adjusted max-w to make it larger -->
        <h1 class="text-2xl font-bold mb-6 text-white text-left">Create New User</h1>
        
        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('users.store') }}" class="bg-gray-800 p-12 rounded-lg shadow-md">
            @csrf
            
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-300">Name:</label>
                <input type="text" id="name" name="name" class="mt-1 block w-full px-3 py-2 border border-gray-700 bg-gray-900 text-white rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-300">Email:</label>
                <input type="email" id="email" name="email" class="mt-1 block w-full px-3 py-2 border border-gray-700 bg-gray-900 text-white rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500" required>
            </div>
            
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-300">Username:</label>
                <input type="text" id="username" name="username" class="mt-1 block w-full px-3 py-2 border border-gray-700 bg-gray-900 text-white rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-300">Password:</label>
                <input type="password" id="password" name="password" class="mt-1 block w-full px-3 py-2 border border-gray-700 bg-gray-900 text-white rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500" required>
            </div>

            <!-- Dropdown for User Level -->
            <div class="mb-4">
                <label for="level" class="block text-sm font-medium text-gray-300">User Level:</label>
                <select id="level" name="level" class="mt-1 block w-full px-3 py-2 border border-gray-700 bg-gray-900 text-white rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500" required>
                    <option value="" disabled selected>Select user level</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>

            <button type="submit" class="w-full py-2 px-4 bg-blue-600 text-white rounded-md hover:bg-blue-700">Create User</button>
        </form>
    </div>
</div>
@endsection
