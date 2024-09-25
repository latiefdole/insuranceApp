<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Hash;

class UserController extends Controller
{
    // Show the list of users
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // Show the form for creating a new user
    public function create()
    {
        return view('users.create');
    }

    // Store a new user
    public function store(Request $request)
    {
        //dd($request->all());
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:5',
            'level' => 'required',
        ], [
            'username.unique' => 'Username sudah ada.',
            'email.unique' => 'Email sudah ada.',
            'password.min' => 'Password minimal 5 karakter.',
            'name.required' => 'Nama diperlukan.',
            'email.required' => 'Email diperlukan.',
            'username.required' => 'Username diperlukan.',
            'password.required' => 'Password diperlukan.',
            'level.required' => 'Password diperlukan.',
        ]);
        $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    // Show the form for editing an existing user
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // Update an existing user
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => '',
            'email' => '',
            'username' => '',
            'password' => 'required|min:5',
            'level' => 'required',
        ], [
           
            'password.min' => 'Password minimal 5 karakter.',
            'password.required' => 'Password diperlukan.',
            'level.required' => 'Password diperlukan.',
        ]);

        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
        } else {
            unset($validatedData['password']);
        }

        $user->update($validatedData);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    // Delete a user
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
}
