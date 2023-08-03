<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class LoginController extends Controller
{
    public function login() {
        Auth::logout();
        return view('login.login');
    }

    public function prosesLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email', 
            'password' => 'required',
		]);

        $password = User::where('email', $request->email)->first();
        if(is_null($password)){
            throw ValidationException::withMessages([
                'email' => 'Email salah atau belum terdaftar'
            ]);
        }
        if ($password) {
            if (!Hash::check($request->password, $password->password)) {
                throw ValidationException::withMessages([
                    'password' => 'Password salah'
                ]);
            }
        }

        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];

        if (Auth::Attempt($data)) {
            return redirect()->route('buku.index');
        } else {
            return redirect('login');
        }
    }

    public function registrasi()
    {
        return view('login.registrasi');
    }

    public function prosesregistrasi(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|email:dns|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $role = 'user';

        $name = $request->old('name');
        $email = $request->old('email');

        $addUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $role
        ]);

        return redirect('login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }

}
