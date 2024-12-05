<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->with('error', 'Username atau Password salah, silahkan coba kembali');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'nama' => 'required|min:3|max:50',
            'username' => 'required|min:3|max:50',
            'password' => 'required|confirmed|min:3',
        ], [
            'nama.required' => 'Nama harus diisi.',
            'nama.min' => 'Nama minimal harus memiliki 3 karakter.',
            'nama.max' => 'Nama tidak boleh melebihi 50 karakter.',
            'username.required' => 'Username harus diisi.',
            'username.min' => 'Username minimal harus memiliki 3 karakter.',
            'username.max' => 'Username tidak boleh melebihi 50 karakter.',
            'password.required' => 'Password harus diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal harus memiliki 3 karakter.',
        ]);

        $data = [
            'nama' =>  $validatedData['nama'],
            'username' =>  $validatedData['username'],
            'password' =>  bcrypt($validatedData['password']),
            'role' => 'admin'
        ];

        User::create($data);

        return redirect()->to('/login')->with('success', 'Berhasil membuat akun, silahkan login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
