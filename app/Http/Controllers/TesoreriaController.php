<?php

namespace App\Http\Controllers;

use App\Models\CrearCuentaCobro;
use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TesoreriaController extends Controller
{
    /**
     * Dashboard principal de Tesorería
     */
    public function index()
    {
        // Estadísticas para el dashboard
        $stats = [
            'pendientes' => CrearCuentaCobro::where('estado', 'aprobado')->count(),
            'pagados_hoy' => Pago::whereDate('fecha_pago', today())->count(),
            'total_pagados_hoy' => Pago::whereDate('fecha_pago', today())->sum('monto'),
            'total_por_pagar' => CrearCuentaCobro::where('estado', 'aprobado')->sum('total'),
            'pagos_mes' => Pago::whereMonth('fecha_pago', now()->month)->count(),
            'monto_mes' => Pago::whereMonth('fecha_pago', now()->month)->sum('monto'),
        ];

        return view('tesoreria.dashboard', [
            'stats' => $stats,
            'user' => auth()->user(),
            'userRole' => auth()->user()->role?->name
        ]);
    }

    /**
     * Lista de cuentas de cobro aprobadas
     */
    public function cuentasCobro(Request $request)
    {
        $query = CrearCuentaCobro::with('user', 'supervisor');

        // Filtros
        if ($request->has('estado')) {
            $query->where('estado', $request->estado);
        } else {
            $query->where('estado', 'aprobado');
        }

        if ($request->has('periodo')) {
            $query->where('periodo', 'like', '%' . $request->periodo . '%');
        }

        if ($request->has('contratista')) {
            $query->where('nombre_beneficiario', 'like', '%' . $request->contratista . '%');
        }

        $cuentasCobro = $query->orderBy('fecha_emision', 'desc')->paginate(15);

        return view('tesoreria.cuentas-cobro.index', compact('cuentasCobro'));
    }

    /**
     * Ver detalle de cuenta de cobro
     */
    public function verCuentaCobro($id)
    {
        $cuentaCobro = CrearCuentaCobro::with('user', 'supervisor', 'pagos')
            ->findOrFail($id);

        return view('tesoreria.cuentas-cobro.show', compact('cuentaCobro'));
    }

    /**
     * Generar cheque
     */
    public function generarCheque(Request $request)
    {
        $request->validate([
            'cuenta_cobro_id' => 'required|exists:crear_cuenta_cobros,id',
            'numero_cheque' => 'required|string|unique:pagos,referencia',
            'fecha_emision' => 'required|date',
            'banco_emisor' => 'required|string',
            'observaciones' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $cuentaCobro = CrearCuentaCobro::findOrFail($request->cuenta_cobro_id);

            $pago = Pago::create([
                'cuenta_cobro_id' => $cuentaCobro->id,
                'metodo_pago' => 'cheque',
                'referencia' => $request->numero_cheque,
                'fecha_pago' => $request->fecha_emision,
                'monto' => $cuentaCobro->total,
                'banco_emisor' => $request->banco_emisor,
                'observaciones' => $request->observaciones,
                'estado' => 'procesado',
                'procesado_por' => Auth::id(),
            ]);

            $cuentaCobro->update([
                'estado' => 'finalizado',
                'fecha_pago' => now(),
            ]);

            DB::commit();

            return redirect()
                ->route('tesoreria.cuentas-cobro.index')
                ->with('success', 'Cheque generado exitosamente. Número: ' . $request->numero_cheque);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al generar el cheque: ' . $e->getMessage());
        }
    }

    /**
     * Procesar transferencia bancaria
     */
    public function procesarTransferencia(Request $request)
    {
        $request->validate([
            'cuenta_cobro_id' => 'required|exists:crear_cuenta_cobros,id',
            'referencia' => 'required|string|unique:pagos,referencia',
            'fecha_transferencia' => 'required|date',
            'descripcion' => 'nullable|string',
            'comprobante' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
        ]);

        DB::beginTransaction();
        try {
            $cuentaCobro = CrearCuentaCobro::findOrFail($request->cuenta_cobro_id);

            $comprobantePath = null;
            if ($request->hasFile('comprobante')) {
                $comprobantePath = $request->file('comprobante')
                    ->store('comprobantes/transferencias', 'public');
            }

            $pago = Pago::create([
                'cuenta_cobro_id' => $cuentaCobro->id,
                'metodo_pago' => 'transferencia',
                'referencia' => $request->referencia,
                'fecha_pago' => $request->fecha_transferencia,
                'monto' => $cuentaCobro->total,
                'descripcion' => $request->descripcion,
                'comprobante' => $comprobantePath,
                'estado' => 'procesado',
                'procesado_por' => Auth::id(),
            ]);

            $cuentaCobro->update([
                'estado' => 'finalizado',
                'fecha_pago' => now(),
            ]);

            DB::commit();

            return redirect()
                ->route('tesoreria.cuentas-cobro.index')
                ->with('success', 'Transferencia procesada exitosamente. Referencia: ' . $request->referencia);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al procesar la transferencia: ' . $e->getMessage());
        }
    }

    /**
     * Confirmar pago realizado
     */
    public function confirmarPago(Request $request)
    {
        $request->validate([
            'cuenta_cobro_id' => 'required|exists:crear_cuenta_cobros,id',
            'metodo_pago' => 'required|in:transferencia,cheque,consignacion,pago_electronico',
            'referencia' => 'required|string',
            'fecha_pago' => 'required|date',
            'monto' => 'required|numeric',
            'comprobante' => 'required|file|mimes:pdf,jpg,png|max:5120',
            'observaciones' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $cuentaCobro = CrearCuentaCobro::findOrFail($request->cuenta_cobro_id);

            $comprobantePath = $request->file('comprobante')
                ->store('comprobantes/pagos', 'public');

            $pago = Pago::create([
                'cuenta_cobro_id' => $cuentaCobro->id,
                'metodo_pago' => $request->metodo_pago,
                'referencia' => $request->referencia,
                'fecha_pago' => $request->fecha_pago,
                'monto' => $request->monto,
                'comprobante' => $comprobantePath,
                'observaciones' => $request->observaciones,
                'estado' => 'confirmado',
                'procesado_por' => Auth::id(),
            ]);

            $cuentaCobro->update([
                'estado' => 'finalizado',
                'fecha_pago' => $request->fecha_pago,
            ]);

            DB::commit();

            return redirect()
                ->route('tesoreria.cuentas-cobro.index')
                ->with('success', 'Pago confirmado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al confirmar el pago: ' . $e->getMessage());
        }
    }

    /**
     * Historial de pagos
     */
    public function historial(Request $request)
    {
        $query = Pago::with('cuentaCobro', 'procesadoPor');

        if ($request->has('fecha_desde')) {
            $query->whereDate('fecha_pago', '>=', $request->fecha_desde);
        }

        if ($request->has('fecha_hasta')) {
            $query->whereDate('fecha_pago', '<=', $request->fecha_hasta);
        }

        if ($request->has('metodo_pago')) {
            $query->where('metodo_pago', $request->metodo_pago);
        }

        $pagos = $query->orderBy('fecha_pago', 'desc')->paginate(20);

        return view('tesoreria.historial', compact('pagos'));
    }

    /**
     * Vista de reportes
     */
    public function reportes()
    {
        return view('tesoreria.reportes');
    }

    /**
     * Generar reporte personalizado
     */
    public function generarReporte(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:pagos_realizados,cuentas_pendientes,historico,por_contratista',
            'fecha_desde' => 'required|date',
            'fecha_hasta' => 'required|date',
            'formato' => 'required|in:xlsx,pdf,csv',
        ]);

        return back()->with('success', 'Reporte generado exitosamente.');
    }

    /**
     * Ver comprobante de pago
     */
    public function verComprobante($id)
    {
        $pago = Pago::with('cuentaCobro')->findOrFail($id);
        return view('tesoreria.comprobante', compact('pago'));
    }

    /**
     * Descargar comprobante
     */
    public function descargarComprobante($id)
    {
        $pago = Pago::findOrFail($id);

        if (!$pago->comprobante) {
            return back()->with('error', 'No hay comprobante disponible.');
        }

        return response()->download(storage_path('app/public/' . $pago->comprobante));
    }
}
