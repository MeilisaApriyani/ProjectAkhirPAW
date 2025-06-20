<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use App\Models\Pengguna; 


class LoginController extends Controller
{
    
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->isAdmin()) {
                return redirect()->route('home');
            } else {
                return redirect()->route('user');
            }
        }

        throw ValidationException::withMessages([
            'email' => 'Email atau password salah',
        ])->redirectTo(route('login'));
        
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:penggunas', 
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        $pengguna = new Pengguna();
        $pengguna->email = $request->email;
        $pengguna->password = Hash::make($request->password);
        $pengguna->save(); 

        return redirect()->route('login')->with('success', 'Registrasi telah berhasil. Silakan masuk.');
    }
    

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}