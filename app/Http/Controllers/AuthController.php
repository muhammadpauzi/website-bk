<?php

namespace App\Http\Controllers;

use App\Helpers\LogLogin;
use App\Http\Requests\LoginRequests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login', [
            "title" => "Masuk"
        ]);
    }

    public function authenticate(Request $request)
    {
        $remember = $request->boolean('remember');
        $credentials = $request->only(['email', 'password']);

        if (Auth::attempt($credentials, $remember)) { // login gagal
            return redirect()
                ->route('dashboard')
                ->with('success', 'Anda berhasil masuk.');
        }

        return redirect()
            ->route('auth.login')
            ->with('failed', 'Email atau password yang anda masukan salah, Silahkan coba ulang dengan data yang benar.');
    }

    public function logout()
    {
        auth()->logout();

        request()->session()->regenerate();
        request()->session()->regenerateToken();

        return redirect()->route('auth.login')->with('success', 'Anda berhasil keluar.');
    }
}
