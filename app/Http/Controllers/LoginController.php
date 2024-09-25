<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        
        return view('auth.login');
        return view('auth.login');
    }

   public function login(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // $envUsername = env('LOGIN_USERNAME');
        // $envPassword = env('LOGIN_PASSWORD');
        // // dd($envPassword, $envUsername, $request->username, $request->password);

        // if (
        //     $request->username === $envUsername &&
        //     $request->password === $envPassword
        // ) {
        //     $user = new User();
        //     $user->name = 'Admin Claim';
    
        //     Auth::login($user);
        //     $request->session()->regenerate();

        //     //  \Log::info('Session regenerated', ['session_id' => $request->session()->getId()]);
        //     // dd('Login successful! User:', Auth::user());

        //     // \Log::info('User logged in:', ['user' => Auth::user()]);
        //     return redirect('/dashboard');

        // //    return redirect()->intended('/dashboard');
        // }

        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            // Authentication passed
            return redirect()->intended('/dashboard'); // Change to your desired route
        }

        throw ValidationException::withMessages([
            'username' => __('The provided credentials do not match our records.'),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
