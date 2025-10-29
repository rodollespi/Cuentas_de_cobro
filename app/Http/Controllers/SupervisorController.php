<?php

namespace App\Http\Controllers;

use App\Models\CrearCuentaCobro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class SupervisorController extends Controller
{
    public function dashboard()
    {
        $supervisorId = Auth::id();

        $cuentas = CrearCuentaCobro::with('user')
            ->where(function ($query) use ($supervisorId) {
                $query->where('estado', 'pendiente')
                      ->whereNull('supervisor_id')
                      ->orWhere('supervisor_id', $supervisorId);
            })
            ->orderBy('fecha_emision', 'desc')
            ->get();

        $total = $cuentas->count();
        $pendientes = $cuentas->where('estado', 'pendiente')->count();
        $aprobadas = $cuentas->where('estado', 'aprobada')->count();
        $rechazadas = $cuentas->where('estado', 'rechazada')->count();

        return view('supervisor.dashboard', compact('cuentas','total','pendientes','aprobadas','rechazadas'));
    }

    /**
     * Mostrar la cuenta para revisión detallada (OBLIGATORIO antes de aprobar/rechazar)
     */
    public function revisar($id)
    {
        $cuenta = CrearCuentaCobro::with('user', 'supervisor')->findOrFail($id);

        // Opcional: si la cuenta ya está finalizada o ya fue aprobada, bloquear o mostrar aviso
        if ($cuenta->estado === 'finalizado') {
            return redirect()->route('supervisor.dashboard')
                ->with('error', 'Esta cuenta ya se encuentra finalizada y no puede revisarse.');
        }

        return view('supervisor.revisar', compact('cuenta'));
    }

    /**
     * Aprueba una cuenta de cobro (debe venir desde la vista de revisión)
     */
    public function aprobar($id)
    {
        $cuenta = CrearCuentaCobro::findOrFail($id);

        // Marcar revisión y aprobacion
        $cuenta->update([
            'estado' => 'aprobada',
            'fecha_revision' => now(),
            'supervisor_id' => Auth::id(),
        ]);

        return redirect()->route('supervisor.dashboard')->with('success', 'Cuenta de cobro aprobada correctamente.');
    }

    /**
     * Rechaza una cuenta de cobro (debe venir desde la vista de revisión)
     */
    public function rechazar(Request $request, $id)
    {
        $request->validate([
            'observaciones' => 'required|string|max:1000',
        ]);

        $cuenta = CrearCuentaCobro::findOrFail($id);

        $cuenta->update([
            'estado' => 'rechazada',
            'observaciones' => $request->observaciones,
            'fecha_revision' => now(),
            'supervisor_id' => Auth::id(),
        ]);

        return redirect()->route('supervisor.dashboard')->with('error', 'Cuenta de cobro rechazada correctamente.');
    }
    public function ver($id)
    {
        $cuenta = CrearCuentaCobro::with('user')->findOrFail($id);
        $soloLectura = true; // Variable para indicar que es modo "ver"
        return view('supervisor.revisar', compact('cuenta', 'soloLectura'));
    }

}
