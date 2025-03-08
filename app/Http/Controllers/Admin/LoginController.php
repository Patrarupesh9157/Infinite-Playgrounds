<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Show the login form for admins
    public function showLoginForm()
    {
        return view('auth.login'); // Make sure this view exists
    }

    // Handle the login request
    public function login(Request $request)
    {
        // Validate the login request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Attempt to log the admin in
        $credentials = $request->only('email', 'password');

        // simple user(web) login
        // if (Auth::attempt($credentials)) {
        //     // Redirect to the intended page or admin dashboard
        //     return redirect()->intended(route('admin.category.concept.index'));
        // }

        //Admin user login 
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended(route('pages-home'));
        }

        // If login fails, redirect back with an error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Handle admin logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
