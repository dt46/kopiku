<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;

class SignInController extends Controller
{
    /**
     * Display the login form.
     */
    public function index()
    {
        return view("auth.login");
    }

    public function indexAdmin()
    {
        return view("auth.login-main");
    }

    /**
     * Handle user login.
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
    
            if (Auth::user()->role && Auth::user()->role->name == 'reseller') {
                session(['user_role' => 'reseller']);
                return redirect()->route('index-reseller');
            } 
            if (Auth::user()->role && Auth::user()->role->name == 'admin') {
                session(['user_role' => 'admin']);
                return redirect()->route('index');
            }
        } else {
            return back()->with('loginFailed', 'Username atau Password salah');
        }
    }

    /**
     * Logout the user.
     */
    public function logout(Request $request)
    {
        $user_role = session()->get('user_role');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        if ($user_role == 'reseller') {
            return redirect()->route('index');
        } else {
            return redirect()->route('indexAdmin');
        }
    }
}
