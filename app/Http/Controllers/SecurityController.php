<?php

namespace App\Http\Controllers;

use App\Customer;
use App\User;
use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecurityController extends Controller
{
    /**
     * Handle user login process.
     */
    public function login(Request $request)
    {
        // Validate username and password fields
        $this->validate($request,
            [
                'username' => 'required',
                'password' => 'required|min:3'
            ],
            ['username.required' => 'Email or Username should be provided!']
        );

        // Encrypt the entered password using the custom encryption class
        $advanceEncryption = (new \App\MyResources\AdvanceEncryption($request->get('password'), "Nova6566", 256));
        $encryptedPassword = $advanceEncryption->encrypt();

        // Find the user by username and encrypted password
        $userData = User::where('user_name', strtolower($request->get('username')))
                        ->where('password', $encryptedPassword)
                        ->first();

        // Check if user exists
        if ($userData) {

            // Check whether the user account is active
            if ($userData->status == 1) {

                // Log the user into the system
                Auth::login($userData);

                // Regenerate session ID for security
                session()->regenerate();

                // Redirect to dashboard after successful login
                return redirect()->route('dashboard');

            } else {

                // Display warning if user account is suspended
                return back()->with('warning', 'User has been suspended! Contact your System Administrator.');
            }

        } else {

            // Display error for invalid login credentials
            return back()->with('error', 'Incorrect login details! Check Username and Password');
        }
    }

    /**
     * Logout the currently logged-in user.
     */
    public function logout(Request $request)
    {
        // Remove user authentication
        Auth::logout();

        // Invalidate the current session
        $request->session()->invalidate();

        // Redirect to the client interface page
        return redirect('/clientInterface');
    }

    /**
     * Display the client registration page.
     */
    public function signup()
    {
        // Return the client signup view
        return view('clientSignup');
    }
}