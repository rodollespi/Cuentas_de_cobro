<?php

namespace App\Http\Controllers;

use App\Models\CrearCuentaCobro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Barryvdh\DomPDF\Facade\Pdf; 

class CrearCuentaCobroController extends Controller
{
    /**
     *
     * Display a listing of the resource.
     */
public function index()
{
    $pendientes = CrearCuentaCobro::where('estado', 'pendiente')->orderBy('created_at', 'desc')->get();
    $aprobadas = CrearCuentaCobro::where('estado', 'aprobada')->orderBy('updated_at', 'desc')->get();
    $rechazadas = CrearCuentaCobro::where('estado', 'rechazada')->orderBy('updated_at', 'desc')->get();
    $finalizadas = CrearCuentaCobro::where('estado', 'finalizada')->orderBy('updated_at', 'desc')->get();

    // Para las gráficas
    $conteoEstados = [
        'pendientes' => $pendientes->count(),
        'aprobadas' => $aprobadas->count(),
        'rechazadas' => $rechazadas->count(),
        'finalizadas' => $finalizadas->count(),
    ];

    $totalCuentas = array_sum($conteoEstados);

    return view('cuentas-cobro.index', compact(
        'pendientes',
        'aprobadas',
        'rechazadas',
        'finalizadas',
        'conteoEstados',
        'totalCuentas'
    ));
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cuentas-cobro.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'nombreAlcaldia' => 'required|string|max:255',
            'nitAlcaldia' => 'required|string|max:50',
            'direccionAlcaldia' => 'required|string|max:255',
            'telefonoAlcaldia' => 'required|string|max:20',
            'ciudadAlcaldia' => 'required|string|max:100',
            'fechaEmision' => 'required|date',
            'tipoDocumento' => 'required|string',
            'numeroDocumento' => 'required|string|max:50',
            'nombreBeneficiario' => 'required|string|max:255',
            'concepto' => 'required|string',
            'periodo' => 'required|string|max:100',
            'subtotal' => 'required|numeric',
            'iva' => 'required|numeric',
            'total' => 'required|numeric',
            'banco' => 'required|string|max:100',
            'tipoCuenta' => 'required|string',
            'numeroCuenta' => 'required|string|max:50',
            'titularCuenta' => 'required|string|max:255',
        ]);

        // Preparar el detalle de items
        $detalleItems = [];
        if ($request->has('descripcion')) {
            foreach ($request->descripcion as $index => $descripcion) {
                $detalleItems[] = [
                    'descripcion' => $descripcion,
                    'cantidad' => $request->cantidad[$index] ?? 0,
                    'valor_unitario' => $request->valorUnitario[$index] ?? 0,
                    'valor_total' => $request->valorTotal[$index] ?? 0,
                ];
            }
        }

        // Crear la cuenta de cobro en la base de datos
        CrearCuentaCobro::create([
            'user_id' => auth()->id(), // Asignar el usuario autenticado
            'nombre_alcaldia' => $request->nombreAlcaldia,
            'nit_alcaldia' => $request->nitAlcaldia,
            'direccion_alcaldia' => $request->direccionAlcaldia,
            'telefono_alcaldia' => $request->telefonoAlcaldia,
            'ciudad_alcaldia' => $request->ciudadAlcaldia,
            'fecha_emision' => $request->fechaEmision,
            'tipo_documento' => $request->tipoDocumento,
            'numero_documento' => $request->numeroDocumento,
            'nombre_beneficiario' => $request->nombreBeneficiario,
            'telefono_beneficiario' => $request->telefonoBeneficiario ?? null,
            'direccion_beneficiario' => $request->direccionBeneficiario ?? null,
            'concepto' => $request->concepto,
            'periodo' => $request->periodo,
            'detalle_items' => json_encode($detalleItems),
            'subtotal' => $request->subtotal,
            'iva' => $request->iva,
            'total' => $request->total,
            'banco' => $request->banco,
            'tipo_cuenta' => $request->tipoCuenta,
            'numero_cuenta' => $request->numeroCuenta,
            'titular_cuenta' => $request->titularCuenta,
            'estado' => 'pendiente', // Establecer estado inicial
        ]);

        // Redirigir con mensaje de éxito
        return redirect()->route('cuentas-cobro.index')
                        ->with('success', 'Cuenta de cobro creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $cuentaCobro = CrearCuentaCobro::where('user_id', auth()->id())
                                    ->findOrFail($id);
        
        return view('cuentas-cobro.show', compact('cuentaCobro'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $cuentaCobro = CrearCuentaCobro::where('user_id', auth()->id())
                                    ->findOrFail($id);
        
        // Verificar si puede editarse (solo pendiente o rechazada)
        if (in_array($cuentaCobro->estado, ['aprobado', 'finalizado'])) {
            return redirect()->route('cuentas-cobro.index')
                            ->with('error', 'No se puede editar una cuenta de cobro ' . $cuentaCobro->estado);
        }
        
        return view('cuentas-cobro.edit', compact('cuentaCobro'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        \Log::info('=== ACTUALIZANDO CUENTA DE COBRO ===');
        \Log::info('ID: ' . $id);

        try {
            $cuentaCobro = CrearCuentaCobro::where('user_id', auth()->id())
                                        ->findOrFail($id);

            \Log::info('Cuenta encontrada: ' . $cuentaCobro->id);
            \Log::info('Estado actual: ' . $cuentaCobro->estado);

            // Verificar si puede editarse (solo pendiente o rechazada)
            if (in_array($cuentaCobro->estado, ['aprobado', 'finalizado'])) {
                return redirect()->route('cuentas-cobro.index')
                                ->with('error', 'No se puede editar una cuenta de cobro ' . $cuentaCobro->estado);
            }

            // Validación (igual que en store)
            $request->validate([
                'nombreAlcaldia' => 'required|string|max:255',
                'nitAlcaldia' => 'required|string|max:50',
                'direccionAlcaldia' => 'required|string|max:255',
                'telefonoAlcaldia' => 'required|string|max:20',
                'ciudadAlcaldia' => 'required|string|max:100',
                'fechaEmision' => 'required|date',
                'tipoDocumento' => 'required|string',
                'numeroDocumento' => 'required|string|max:50',
                'nombreBeneficiario' => 'required|string|max:255',
                'concepto' => 'required|string',
                'periodo' => 'required|string|max:100',
                'subtotal' => 'required|numeric',
                'iva' => 'required|numeric',
                'total' => 'required|numeric',
                'banco' => 'required|string|max:100',
                'tipoCuenta' => 'required|string',
                'numeroCuenta' => 'required|string|max:50',
                'titularCuenta' => 'required|string|max:255',
            ]);

            \Log::info('Validación pasada');

            // Preparar el detalle de items (igual que en store)
            $detalleItems = [];
            if ($request->has('descripcion')) {
                foreach ($request->descripcion as $index => $descripcion) {
                    if (!empty($descripcion)) {
                        $detalleItems[] = [
                            'descripcion' => $descripcion,
                            'cantidad' => $request->cantidad[$index] ?? 1,
                            'valor_unitario' => $request->valorUnitario[$index] ?? 0,
                            'valor_total' => $request->valorTotal[$index] ?? 0,
                        ];
                    }
                }
            }

            \Log::info('Items procesados:', $detalleItems);

            // Actualizar la cuenta de cobro (similar a store pero con update)
            $cuentaCobro->update([
                'nombre_alcaldia' => $request->nombreAlcaldia,
                'nit_alcaldia' => $request->nitAlcaldia,
                'direccion_alcaldia' => $request->direccionAlcaldia,
                'telefono_alcaldia' => $request->telefonoAlcaldia,
                'ciudad_alcaldia' => $request->ciudadAlcaldia,
                'fecha_emision' => $request->fechaEmision,
                'tipo_documento' => $request->tipoDocumento,
                'numero_documento' => $request->numeroDocumento,
                'nombre_beneficiario' => $request->nombreBeneficiario,
                'telefono_beneficiario' => $request->telefonoBeneficiario ?? null,
                'direccion_beneficiario' => $request->direccionBeneficiario ?? null,
                'concepto' => $request->concepto,
                'periodo' => $request->periodo,
                'detalle_items' => json_encode($detalleItems),
                'subtotal' => $request->subtotal,
                'iva' => $request->iva,
                'total' => $request->total,
                'banco' => $request->banco,
                'tipo_cuenta' => $request->tipoCuenta,
                'numero_cuenta' => $request->numeroCuenta,
                'titular_cuenta' => $request->titularCuenta,
                // Resetear estado a pendiente cuando se edita
                'estado' => 'pendiente',
            ]);

            \Log::info('Cuenta actualizada exitosamente: ' . $cuentaCobro->id);

            return redirect()->route('cuentas-cobro.show', $cuentaCobro->id)
                             ->with('success', 'Cuenta de cobro actualizada exitosamente');

        } catch (\Exception $e) {
            \Log::error('Error en update: ' . $e->getMessage());
            return redirect()->back()
                             ->with('error', 'Error al actualizar: ' . $e->getMessage())
                             ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cuentaCobro = CrearCuentaCobro::where('user_id', auth()->id())
                                    ->findOrFail($id);
        
        // Verificar si puede eliminarse (solo pendiente o rechazada)
        if (in_array($cuentaCobro->estado, ['aprobado', 'finalizado'])) {
            return redirect()->route('cuentas-cobro.index')
                            ->with('error', 'No se puede eliminar una cuenta de cobro ' . $cuentaCobro->estado);
        }
        
        $cuentaCobro->delete();

        return redirect()->route('cuentas-cobro.index')
                        ->with('success', 'Cuenta de cobro eliminada exitosamente');
    }

    /**
     * Descargar documento
     */
public function descargarPDF($id)
{
    try {
        $cuentaCobro = CrearCuentaCobro::where('user_id', auth()->id())
                                    ->findOrFail($id);
        
        $pdf = PDF::loadView('cuentas-cobro.pdf', compact('cuentaCobro'));
        
        return $pdf->download("cuenta-cobro-{$cuentaCobro->id}.pdf");
        
    } catch (\Exception $e) {
        Log::error('Error al generar PDF: ' . $e->getMessage());
        return redirect()->back()
                        ->with('error', 'Error al generar el PDF: ' . $e->getMessage());
    }
}
}
