<?php

namespace App\Http\Controllers;

use App\Models\CrearCuentaCobro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupervisorController extends Controller
{
    /**
     * Muestra el dashboard del supervisor con estadísticas y cuentas asignadas
     */
    public function index()
    {
        $supervisorId = Auth::id();

        // Cuentas asignadas a este supervisor
        $cuentas = CrearCuentaCobro::where('supervisor_id', $supervisorId)->get();

        // Estadísticas
        $total = $cuentas->count();
        $pendientes = $cuentas->where('estado', 'pendiente')->count();
        $aprobadas = $cuentas->where('estado', 'aprobada')->count();
        $rechazadas = $cuentas->where('estado', 'rechazada')->count();

        return view('supervisor.dashboard', compact(
            'cuentas',
            'total',
            'pendientes',
            'aprobadas',
            'rechazadas'
        ));
    }

    /**
     * Aprueba una cuenta de cobro
     */
    public function aprobar($id)
    {
        $cuenta = CrearCuentaCobro::findOrFail($id);
        $cuenta->update([
            'estado' => 'aprobada',
            'fecha_revision' => now(),
            'supervisor_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Cuenta de cobro aprobada correctamente.');
    }

    /**
     * Rechaza una cuenta de cobro con observaciones
     */
    public function rechazar(Request $request, $id)
    {
        $request->validate([
            'observaciones' => 'required|string|max:500',
        ]);

        $cuenta = CrearCuentaCobro::findOrFail($id);
        $cuenta->update([
            'estado' => 'rechazada',
            'observaciones' => $request->observaciones,
            'fecha_revision' => now(),
            'supervisor_id' => Auth::id(),
        ]);

        return redirect()->back()->with('error', 'Cuenta de cobro rechazada correctamente.');
    }
}
