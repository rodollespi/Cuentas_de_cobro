<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class ConfiguracionController extends Controller
{
    public function index()
    {
        // Obtener configuración actual desde la sesión (si existe)
        $config = [
            'tema' => session('tema', 'claro'),
            'notificaciones' => session('notificaciones', true),
            'lenguaje' => session('lenguaje', 'es'),
        ];

        return view('ordenador.configuracion', compact('config'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'tema' => 'required|in:claro,oscuro',
            'lenguaje' => 'required|in:es,en',
        ]);

        // Guardar configuración en la sesión
        session([
            'tema' => $request->tema,
            'notificaciones' => $request->has('notificaciones'),
            'lenguaje' => $request->lenguaje,
        ]);

        // Cambiar el idioma activo
        App::setLocale($request->lenguaje);

        return back()->with('success', __('Configuración guardada correctamente.'));
    }
}


