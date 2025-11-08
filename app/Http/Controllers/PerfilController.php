<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    public function index()
    {
       return view('ordenador.perfil');

    }

    public function update(Request $request)
    {
        $user = auth()->user();

        // Validación
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|min:6|confirmed',
        ]);

        // Actualización básica
        $user->name = $request->name;
        $user->email = $request->email;

        // Solo si escribió una nueva contraseña
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Perfil actualizado correctamente.');
    }
}


