<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CrearCuentaCobro;

class OrdenadorController extends Controller
{
    // Mostrar solo las cuentas que Tesorería ya aprobó
    public function index()
    {
        $cuentas = CrearCuentaCobro::where('estado', 'tesoreria_aprobada')->get();
        return view('ordenador.dashboard', compact('cuentas'));
    }

    // Aprobar pago final
    public function aprobarFinal($id)
    {
        $cuenta = CrearCuentaCobro::findOrFail($id);
        $cuenta->estado = 'aprobada_final';
        $cuenta->fecha_revision = now();
        $cuenta->save();

        return redirect()->route('ordenador.dashboard')
                         ->with('success', '✅ Pago final aprobado correctamente.');
    }

    // Rechazar pago final
    public function rechazarFinal($id)
    {
        $cuenta = CrearCuentaCobro::findOrFail($id);
        $cuenta->estado = 'rechazada_final';
        $cuenta->fecha_revision = now();
        $cuenta->save();

        return redirect()->route('ordenador.dashboard')
                         ->with('error', '❌ Cuenta rechazada en la fase final.');
    }
}





