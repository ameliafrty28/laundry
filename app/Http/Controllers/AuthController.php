<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * FORM LOGIN
     */
    public function login()
    {
        if (Auth::check()) {

            $role = strtolower(auth()->user()->user_role);

            if ($role == 'admin') {
                return redirect('/admin/pelanggan');
            }

            if ($role == 'kasir') {
                return redirect('/kasir/transaksi');
            }
        }

        return view('auth.login');
    }

    /**
     * PROSES LOGIN
     */
    public function loginProses(Request $request)
    {
        $request->validate([
            'user_username' => 'required',
            'user_password' => 'required'
        ]);

        $user = User::where('user_username', $request->user_username)->first();

        // cek username
        if (!$user) {
            return back()->with('error','Username tidak ditemukan');
        }

        // cek password
        if (!Hash::check($request->user_password, $user->user_password)) {
            return back()->with('error','Password salah');
        }

        // login
        Auth::login($user);

        // 🔥 NORMALISASI ROLE (PENTING)
        $role = strtolower(trim($user->user_role));

        if ($role == 'admin') {
             return redirect('/admin/pelanggan')->with('success','Login sebagai Admin');
        }

        if ($role == 'kasir') {
            return redirect('/kasir/transaksi')->with('success','Login sebagai Kasir');
        }

        Auth::logout();
        return redirect('/login')->with('error','Role tidak valid');

        // fallback (kalau role tidak dikenali)
        Auth::logout();
        return redirect('/')->with('error','Role tidak valid');
    }

    /**
     * LOGOUT
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success','Berhasil logout');
    }
}