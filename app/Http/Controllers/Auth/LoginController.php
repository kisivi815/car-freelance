<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->intended('view-stock');
        }else{
            return view('auth.login');
        }
       
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();
    
        if ($user && $user->password === $credentials['password']) {
            Auth::login($user);
            return redirect()->intended('view-stock');
        } else {
            return redirect()->back()->withErrors(['email' => 'Invalid credentials']);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
