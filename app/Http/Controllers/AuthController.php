<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // PROSES LOGIN
    public function login(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Cek ke Database (Otomatis di-hash)
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // 3. Cek Role: Kamu Siapa?
            $role = Auth::user()->role;

            if ($role === 'seller') {
                return redirect()->intended('/seller'); // Masuk dashboard penjual
            }

            return redirect()->intended('/buyer'); // Masuk halaman pembeli
        }

        // 4. Kalau Gagal
        return back()->withErrors([
            'email' => 'Email atau password salah',
        ])->onlyInput('email');
    }

    // PROSES LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}