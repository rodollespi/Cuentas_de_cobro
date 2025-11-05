<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CrearCuentaCobro;

class OrdenadorController extends Controller
{
    /**
     * Mostrar todas las cuentas de cobro pendientes o revisadas.
     */
    public function index()
    {
        // Solo mostrar las cuentas pendientes o revisadas
        $cuentas = CrearCuentaCobro::whereIn('estado', ['pendiente', 'Revisada'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('ordenador.dashboard', compact('cuentas'));
    }

    /**
     * Mostrar detalles de una cuenta específica.
     */
    public function show($id)
    {
        $cuenta = CrearCuentaCobro::findOrFail($id);
        return view('ordenador.verCuenta', compact('cuenta'));
    }

    /**
     * Autorizar una cuenta de cobro.
     */
    public function autorizar($id)
    {
        $cuenta = CrearCuentaCobro::findOrFail($id);
        $cuenta->estado = 'Autorizada';
        $cuenta->save();

        return redirect()->route('ordenador.dashboard')->with('success', 'Cuenta de cobro autorizada correctamente.');
    }

    /**
     * Rechazar una cuenta de cobro.
     */
    public function rechazar($id, Request $request)
    {
        $cuenta = CrearCuentaCobro::findOrFail($id);
        $cuenta->estado = 'Rechazada';
        $cuenta->observaciones = $request->input('observaciones', 'Sin observaciones');
        $cuenta->save();

        return redirect()->route('ordenador.dashboard')->with('error', 'Cuenta de cobro rechazada.');
    }
}



