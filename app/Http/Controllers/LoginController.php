<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function showLogin()
    {
        // Redirect jika sudah login
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect('/admin/dashboard');
            } elseif ($user->role === 'guru') {
                return redirect('/guru/dashboard');
            } else {
                return redirect('/siswa/dashboard');
            }
        }
        
        return view('auth.login');
    }
    
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        
        // Debug: Log attempt
        \Log::info('Login attempt for: ' . $credentials['username']);
        
        // Cari user berdasarkan username
        $user = User::where('username', $credentials['username'])->first();
        
        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();
            
            // Debug: Log successful login
            \Log::info('Login successful for: ' . $user->username . ' with role: ' . $user->role);
            
            // Redirect berdasarkan role
            if ($user->role === 'admin') {
                \Log::info('Redirecting admin to dashboard');
                return redirect()->intended('/admin/dashboard')->with('success', 'Selamat datang Admin, ' . $user->nama);
            } elseif ($user->role === 'guru') {
                \Log::info('Redirecting guru to dashboard');
                return redirect()->intended('/guru/dashboard')->with('success', 'Selamat datang, ' . $user->nama);
            } else {
                \Log::info('Redirecting siswa to dashboard');
                return redirect()->intended('/siswa/dashboard')->with('success', 'Selamat datang, ' . $user->nama);
            }
        }
        
        \Log::info('Login failed for: ' . $credentials['username']);
        return back()->withErrors(['username' => 'Username atau password salah.']);
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Berhasil logout');
    }
    

}