<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;


   

class AuthController extends Controller
{
    //
    public function showLoginForm()
    {
        return view('auth.login');
    }

    
  public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // First, find the user by email
        $user = \App\Models\User::where('email', $request->email)->first();

        // Check if the user exists and is inactive
        if ($user && $user->status === 'inactive') {
            return back()->withErrors([
                'email' => 'Your account is inactive. Please contact the administrator.',
            ]);
        }

        // Attempt login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // protect session from fixation
            return redirect()->route('books.index')->with('success', 'Login successful.');
        }

        // Invalid credentials
        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }


    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }
    

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // public function register(Request $request)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|string',
    //         'email' => 'required|email|unique:users',
    //         'password' => 'required|min:5',
    //         'role' => 'required|in:admin,user'
    //     ]);

    //     $validated['password'] = bcrypt($validated['password']);

    //     User::create($validated);

    //     return redirect('/login')->with('success', 'Account created. Please login.');
    // }

    // public function register(Request $request)
    // {
    //     // Validate input
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|',
    //         'password' => 'required|string|min:6|',
    //     ]);

    //     // Generate 6-digit random verification code
    //     $verificationCode = rand(100000, 999999);

    //     // Store registration data temporarily in session
    //     Session::put('register_data', [
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => bcrypt($request->password),
    //         'code' => $verificationCode,
    //     ]);

    //     // Send the code to the email
    //     Mail::raw("Your verification code is: $verificationCode", function ($message) use ($request) {
    //         $message->to($request->email)
    //                 ->subject('Email Verification Code');
    //     });

    //     return view('auth.verify_code', ['email' => $request->email]);
    // }
    
    public function register(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
    ]);

    // Create user with email_unverified
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    // ✅ Generate 6-digit random code
    $code = rand(100000, 999999);

    // ✅ Store the code and email in session
    session([
        'verification_code' => $code,
        'email_for_verification' => $request->email,
    ]);

    // ✅ Send the code to user's email
    Mail::raw("Your verification code is: $code", function ($message) use ($request) {
        $message->to($request->email)
                ->subject('Verify Your Email - Book Management System');
    });

    // ✅ Redirect to code input page with email
    return view('auth.verify_code', ['email' => $request->email]);
}


public function completeRegister(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'code' => 'required'
    ]);

    $storedCode = session('verification_code');

    if (!$storedCode) {
        return redirect()->route('register')->withErrors(['code' => 'No code stored. Please register again.']);
    }

    if ($request->code == $storedCode) {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->route('register')->withErrors(['email' => 'User not found']);
        }

        $user->email_verified_at = now();
        $user->save();

        session()->forget(['verification_code', 'email_for_verification']);

        Auth::login($user);

        return redirect()->route('books.index')->with('success', 'Successfully verified and registered!');
    } else {
        return back()->withErrors(['code' => 'Invalid verification code']);
    }
}


}
