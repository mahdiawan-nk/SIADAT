<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class AuthController extends Controller
{
    public function _authenticate(Request $request)
    {
        $authUser = [
            'username' => $request->username,
            'password' => $request->password
        ];

        if (Auth::attempt($authUser)) {
            $user = auth()->user();
            return response()->json([
                'status' => 'OK',
                'message' => 'Login Berhasil'
            ], 200);
        } else {
            return response()->json([
                'status' => 'ERROR',
                'message' => 'Login gagal, username atau password salah'
            ], 401);
        }
    }

    public function me()
    {
        $data = auth()->user();
        return response()->json([
            'status' => 'OK',
            'message' => 'Login Ok',
            'data' => $data
        ], 200);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    function registrasi(Request $request)
    {
        // Validasi input menggunakan metode validate
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'id_kenegerian' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|string|min:8|same:password',
            
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'id_kenegerian.required' => 'ID Kenegerian wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password_confirmation.required' => 'Password wajib diisi.',
            'password_confirmation.min' => 'Password minimal 8 karakter.',
            'password_confirmation.same' => 'Konfirmasi password tidak sesuai dengan password.',
        ]);

        // Hash password sebelum menyimpan ke database
        $password = Hash::make($request->password);

        // Buat user baru
        $user = User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'email' => $request->email,
            'id_kenegerian' => $request->id_kenegerian,
            'role'=>2,
            'password' => $password,
        ]);
        return response()->json([
            'status' => 'OK',
            'message' => 'Login Ok',
        ], 200);
    }
}
