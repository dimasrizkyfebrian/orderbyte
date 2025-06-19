<?php

namespace App\Filament\Pages\Auth;

use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AdminLogin extends BaseLogin
{
    public function authenticate(): ?LoginResponse
    {
        // Lakukan proses otentikasi standar dari parent class
        // Ini akan menangani rate limiting, validasi kredensial, dll.
        // Jika otentikasi gagal, method ini akan melempar ValidationException.
        $loginResponse = parent::authenticate();

        // Jika parent::authenticate() tidak melempar exception, otentikasi berhasil.
        // Sekarang, periksa peran pengguna.
        $user = Filament::auth()->user();

        // Pastikan model User Anda memiliki atribut 'role'.
        if ($user instanceof User && $user->role !== 'admin') {
            Filament::auth()->logout(); // Logout pengguna yang bukan admin

            // Lempar ValidationException untuk memberi tahu pengguna.
            // Pesan ini akan ditampilkan di form login.
            throw ValidationException::withMessages([
                'data.email' => 'Anda tidak diizinkan untuk mengakses panel admin.',
            ]);
        }

        // Jika peran adalah 'admin', kembalikan response login asli.
        return $loginResponse;
    }
}
