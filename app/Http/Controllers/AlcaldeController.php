<?php

namespace App\Http\Controllers;

use App\Models\CrearCuentaCobro;
use Illuminate\Http\Request;

class AlcaldeController extends Controller
{
    /**
     * Mostrar todas las cuentas de cobro
     */
    public function index(Request $request)
    {
        $query = CrearCuentaCobro::with(['user', 'supervisor']);

        // Filtros opcionales
        if ($request->has('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->has('contratista')) {
            $query->where('user_id', $request->contratista);
        }

        if ($request->has('fecha_desde')) {
            $query->whereDate('fecha_emision', '>=', $request->fecha_desde);
        }

        if ($request->has('fecha_hasta')) {
            $query->whereDate('fecha_emision', '<=', $request->fecha_hasta);
        }

        $cuentasCobro = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('alcalde.cuentas-cobro.index', compact('cuentasCobro'));
    }

    /**
     * Ver detalle de una cuenta de cobro
     */
    public function show($id)
    {
        $cuentaCobro = CrearCuentaCobro::with(['user', 'supervisor'])->findOrFail($id);

        return view('alcalde.cuentas-cobro.show', compact('cuentaCobro'));
    }

    /**
     * Aprobar cuenta de cobro
     */
    public function aprobar(Request $request, $id)
    {
        $request->validate([
            'observaciones' => 'nullable|string|max:1000'
        ]);

        $cuentaCobro = CrearCuentaCobro::findOrFail($id);

        // Verificar que esté en estado correcto
        if (!in_array($cuentaCobro->estado, ['pendiente', 'en_revision'])) {
            return back()->with('error', 'Esta cuenta de cobro no puede ser aprobada en su estado actual.');
        }

        $cuentaCobro->update([
            'estado' => 'aprobado',
            'supervisor_id' => auth()->id(),
            'fecha_revision' => now(),
            'observaciones' => $request->observaciones
        ]);

        return redirect()->route('alcalde.cuentas-cobro.index')
            ->with('success', 'Cuenta de cobro aprobada exitosamente.');
    }

    /**
     * Rechazar cuenta de cobro
     */
    public function rechazar(Request $request, $id)
    {
        $request->validate([
            'observaciones' => 'required|string|max:1000'
        ]);

        $cuentaCobro = CrearCuentaCobro::findOrFail($id);

        $cuentaCobro->update([
            'estado' => 'rechazado',
            'supervisor_id' => auth()->id(),
            'fecha_revision' => now(),
            'observaciones' => $request->observaciones
        ]);

        return redirect()->route('alcalde.cuentas-cobro.index')
            ->with('success', 'Cuenta de cobro rechazada.');
    }

    /**
     * Finalizar cuenta de cobro (marcar como pagada)
     */
    public function finalizar($id)
    {
        $cuentaCobro = CrearCuentaCobro::findOrFail($id);

        if ($cuentaCobro->estado !== 'aprobado') {
            return back()->with('error', 'Solo se pueden finalizar cuentas aprobadas.');
        }

        $cuentaCobro->update([
            'estado' => 'finalizado'
        ]);

        return redirect()->route('alcalde.cuentas-cobro.index')
            ->with('success', 'Cuenta de cobro finalizada exitosamente.');
    }
}