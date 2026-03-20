<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClienteAuthController extends Controller
{
    public function loginForm()
    {
        return view('cliente.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('cliente')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('cliente.dashboard');
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas']);
    }

    public function registerForm()
    {
        $clientes = Cliente::where('estado', 'activo')->whereNull('email')->get();
        return view('cliente.register', compact('clientes'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'email' => 'required|email|unique:clientes,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $cliente = Cliente::findOrFail($validated['cliente_id']);
        $cliente->update([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::guard('cliente')->login($cliente);
        return redirect()->route('cliente.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('cliente')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
