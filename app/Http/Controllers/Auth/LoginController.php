<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\BitacoraSistema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nombre_usuario' => 'required|string',
            'password'       => 'required|string',
        ], [
            'nombre_usuario.required' => 'El usuario es obligatorio.',
            'password.required'       => 'La contraseña es obligatoria.',
        ]);

        $credenciales = [
            'nombre_usuario' => $request->nombre_usuario,
            'password'       => $request->password,
        ];

        if (Auth::attempt($credenciales, $request->boolean('remember'))) {
            $request->session()->regenerate();

            BitacoraSistema::registrar('LOGIN', 'usuarios', Auth::id(), 'Inicio de sesión exitoso');

            return redirect()->intended(route('dashboard'));
        }

        throw ValidationException::withMessages([
            'nombre_usuario' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }

    public function logout(Request $request)
    {
        BitacoraSistema::registrar('LOGOUT', 'usuarios', Auth::id(), 'Cierre de sesión');

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
