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
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Obtener las cuentas de cobro del usuario autenticado separadas por estado
            // CORREGIDO: había un error tipográfico en "getCuentaPorEstado" (faltaba la 's')
            $cuentasPendientes = $this->getCuentasPorEstado('pendiente');
            $cuentasAprobadas = $this->getCuentasPorEstado('aprobado');
            $cuentasRechazadas = $this->getCuentasPorEstado('rechazado'); // CORREGIDO
            $cuentasFinalizadas = $this->getCuentasPorEstado('finalizado');

            // Datos para el gráfico
            $estadisticas = $this->obtenerEstadisticas();

            // Depuración
            Log::info('Cuentas encontradas:', [
                'pendientes' => $cuentasPendientes->count(),
                'aprobadas' => $cuentasAprobadas->count(),
                'rechazadas' => $cuentasRechazadas->count(),
                'finalizadas' => $cuentasFinalizadas->count()
            ]);

            return view('cuentas-cobro.index', compact(
                'cuentasPendientes',
                'cuentasAprobadas',
                'cuentasRechazadas',
                'cuentasFinalizadas',
                'estadisticas'
            ));

        } catch (\Exception $e) {
            Log::error('Error en index: ' . $e->getMessage());
            
            // En caso de error, crear colecciones vacías para todas las variables
            $cuentasPendientes = new Collection();
            $cuentasAprobadas = new Collection();
            $cuentasRechazadas = new Collection();
            $cuentasFinalizadas = new Collection();
            
            $estadisticas = [
                'conteo_por_estado' => [
                    'pendiente' => 0,
                    'aprobado' => 0,
                    'rechazado' => 0,
                    'finalizado' => 0
                ],
                'meses' => ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
                'totales' => [0, 0, 0, 0, 0, 0],
                'total_general' => 0,
                'total_aprobado' => 0,
            ];

            return view('cuentas-cobro.index', compact(
                'cuentasPendientes',
                'cuentasAprobadas',
                'cuentasRechazadas',
                'cuentasFinalizadas',
                'estadisticas'
            ));
        }
    }

    /**
     * Obtener cuentas por estado de forma segura
     */
    private function getCuentasPorEstado($estado)
    {
        try {
            $cuentas = CrearCuentaCobro::where('user_id', auth()->id())
                                ->where('estado', $estado)
                                ->latest()
                                ->get();
            
            // Asegurarse de que siempre retorne una colección
            return $cuentas instanceof Collection ? $cuentas : new Collection();
            
        } catch (\Exception $e) {
            Log::error("Error obteniendo cuentas $estado: " . $e->getMessage());
            return new Collection();
        }
    }

    /**
     * Obtener estadísticas para gráficos
     */
    private function obtenerEstadisticas()
    {
        $userId = auth()->id();

        try {
            // Conteo por estado - asegurarnos de que siempre retorne un array
            $conteoPorEstado = CrearCuentaCobro::where('user_id', $userId)
                ->select('estado', DB::raw('COUNT(*) as count'))
                ->groupBy('estado')
                ->pluck('count', 'estado')
                ->toArray();

            // Inicializar todos los estados con 0
            $estadosDefault = [
                'pendiente' => 0,
                'aprobado' => 0,
                'rechazado' => 0,
                'finalizado' => 0
            ];

            $conteoPorEstado = array_merge($estadosDefault, $conteoPorEstado);

            // Total por mes (últimos 6 meses)
            $totalesPorMes = CrearCuentaCobro::where('user_id', $userId)
                ->where('estado', 'aprobado')
                ->where('created_at', '>=', now()->subMonths(6))
                ->select(
                    DB::raw('YEAR(created_at) as year'),
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('COALESCE(SUM(total), 0) as total')
                )
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->get();

            // Preparar datos para el gráfico de meses
            $meses = [];
            $totales = [];
            
            foreach ($totalesPorMes as $dato) {
                $meses[] = $this->obtenerNombreMes($dato->month) . ' ' . $dato->year;
                $totales[] = floatval($dato->total);
            }

            // Si no hay datos, crear arrays vacíos
            if (empty($meses)) {
                $meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'];
                $totales = [0, 0, 0, 0, 0, 0];
            }

            return [
                'conteo_por_estado' => $conteoPorEstado,
                'meses' => $meses,
                'totales' => $totales,
                'total_general' => floatval(CrearCuentaCobro::where('user_id', $userId)->sum('total') ?? 0),
                'total_aprobado' => floatval(CrearCuentaCobro::where('user_id', $userId)->where('estado', 'aprobado')->sum('total') ?? 0),
            ];

        } catch (\Exception $e) {
            Log::error('Error obteniendo estadísticas: ' . $e->getMessage());
            
            // Retornar datos por defecto en caso de error
            return [
                'conteo_por_estado' => [
                    'pendiente' => 0,
                    'aprobado' => 0,
                    'rechazado' => 0,
                    'finalizado' => 0
                ],
                'meses' => ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
                'totales' => [0, 0, 0, 0, 0, 0],
                'total_general' => 0,
                'total_aprobado' => 0,
            ];
        }
    }

    /**
     * Obtener nombre del mes
     */
    private function obtenerNombreMes($mes)
    {
        $meses = [
            1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr',
            5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago',
            9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'
        ];
        return $meses[$mes] ?? 'Mes';
    }

    /**
     * Show the form for creating a new resource.
     */
// En el método create()
public function create()
{
    // Obtener los documentos aprobados del usuario
    $documentosAprobados = \App\Models\Documento::where('user_id', auth()->id())
                                ->where('estado', 'aprobado')
                                ->get();
    
    return view('cuentas-cobro.create', compact('documentosAprobados'));
}

// En el método store() - actualizado
public function store(Request $request)
{
    // Validación existente más la nueva validación para documentos
    $validated = $request->validate([
        'nombreAlcaldia' => 'required|string|max:255',
        'nitAlcaldia' => 'required|string|max:50',
        'direccionAlcaldia' => 'required|string|max:255',
        'telefonoAlcaldia' => 'required|string|max:20',
        'ciudadAlcaldia' => 'required|string|max:100',
        'fechaEmision' => 'required|date',
        'tipoDocumento' => 'required|string',
        'numeroDocumento' => 'required|string|max:50',
        'nombreBeneficiario' => 'required|string|max:255',
        'telefonoBeneficiario' => 'nullable|string|max:20',
        'direccionBeneficiario' => 'nullable|string|max:255',
        'concepto' => 'required|string',
        'periodo' => 'required|string|max:100',
        'subtotal' => 'required|numeric|min:0',
        'iva' => 'required|numeric|min:0',
        'total' => 'required|numeric|min:0',
        'banco' => 'required|string|max:100',
        'tipoCuenta' => 'required|string',
        'numeroCuenta' => 'required|string|max:50',
        'titularCuenta' => 'required|string|max:255',
        'descripcion' => 'required|array|min:1',
        'descripcion.*' => 'required|string',
        'cantidad' => 'required|array|min:1',
        'cantidad.*' => 'required|numeric|min:1',
        'valorUnitario' => 'required|array|min:1',
        'valorUnitario.*' => 'required|numeric|min:0',
        'valorTotal' => 'required|array|min:1',
        'valorTotal.*' => 'required|numeric|min:0',
        'documentos_seleccionados' => 'required|array|min:1',
        'documentos_seleccionados.*' => 'exists:documentos,id'
    ]);

    try {
        // Preparar el detalle de items
        $detalleItems = [];
        foreach ($request->descripcion as $index => $descripcion) {
            $cantidad = (int) $request->cantidad[$index];
            $valorUnitario = (float) $request->valorUnitario[$index];
            $valorTotal = (float) $request->valorTotal[$index];
            
            $detalleItems[] = [
                'descripcion' => $descripcion,
                'cantidad' => $cantidad,
                'valor_unitario' => $valorUnitario,
                'valor_total' => $valorTotal,
            ];
        }

        // ✅ PREPARAR DOCUMENTOS ASOCIADOS
        $documentosAsociados = [];
        foreach ($request->documentos_seleccionados as $documentoId) {
            $documento = \App\Models\Documento::find($documentoId);
            if ($documento) {
                $documentosAsociados[] = [
                    'id' => $documento->id,
                    'nombre' => $documento->nombre,
                    'ruta' => $documento->ruta_archivo, // ajusta según tu campo
                    'fecha_subida' => $documento->created_at->toDateString(),
                    'estado' => $documento->estado
                ];
            }
        }

        // Convertir valores numéricos principales
        $subtotal = (float) $validated['subtotal'];
        $iva = (float) $validated['iva'];
        $total = (float) $validated['total'];

        // Crear la cuenta de cobro
        CrearCuentaCobro::create([
            'user_id' => auth()->id(),
            'nombre_alcaldia' => $validated['nombreAlcaldia'],
            'nit_alcaldia' => $validated['nitAlcaldia'],
            'direccion_alcaldia' => $validated['direccionAlcaldia'],
            'telefono_alcaldia' => $validated['telefonoAlcaldia'],
            'ciudad_alcaldia' => $validated['ciudadAlcaldia'],
            'fecha_emision' => $validated['fechaEmision'],
            'tipo_documento' => $validated['tipoDocumento'],
            'numero_documento' => $validated['numeroDocumento'],
            'nombre_beneficiario' => $validated['nombreBeneficiario'],
            'telefono_beneficiario' => $validated['telefonoBeneficiario'] ?? null,
            'direccion_beneficiario' => $validated['direccionBeneficiario'] ?? null,
            'concepto' => $validated['concepto'],
            'periodo' => $validated['periodo'],
            'detalle_items' => $detalleItems,
            'subtotal' => $subtotal,
            'iva' => $iva,
            'total' => $total,
            'banco' => $validated['banco'],
            'tipo_cuenta' => $validated['tipoCuenta'],
            'numero_cuenta' => $validated['numeroCuenta'],
            'titular_cuenta' => $validated['titularCuenta'],
            'estado' => 'pendiente',
            'documentos_asociados' => $documentosAsociados, // ✅ GUARDAR DOCUMENTOS
        ]);

        return redirect()->route('cuentas-cobro.index')
                        ->with('success', 'Cuenta de cobro creada exitosamente con ' . count($documentosAsociados) . ' documentos asociados');

    } catch (\Exception $e) {
        Log::error('Error al crear cuenta de cobro: ' . $e->getMessage());
        return redirect()->back()
                        ->with('error', 'Error al crear la cuenta de cobro: ' . $e->getMessage())
                        ->withInput();
    }
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
        
        // Verificar si puede editarse
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
        Log::info('=== ACTUALIZANDO CUENTA DE COBRO ===');
        Log::info('ID: ' . $id);

        try {
            $cuentaCobro = CrearCuentaCobro::where('user_id', auth()->id())
                                        ->findOrFail($id);

            Log::info('Cuenta encontrada: ' . $cuentaCobro->id);
            Log::info('Estado actual: ' . $cuentaCobro->estado);

            // Verificar si puede editarse
            if (in_array($cuentaCobro->estado, ['aprobado', 'finalizado'])) {
                return redirect()->route('cuentas-cobro.index')
                                ->with('error', 'No se puede editar una cuenta de cobro ' . $cuentaCobro->estado);
            }

            // Depurar los datos recibidos
            Log::info('Datos recibidos:', [
                'descripcion' => $request->descripcion,
                'cantidad' => $request->cantidad,
                'valorUnitario' => $request->valorUnitario,
                'valorTotal' => $request->valorTotal
            ]);

            // Validación completa con mejor manejo de tipos
            $validated = $request->validate([
                'nombreAlcaldia' => 'required|string|max:255',
                'nitAlcaldia' => 'required|string|max:50',
                'direccionAlcaldia' => 'required|string|max:255',
                'telefonoAlcaldia' => 'required|string|max:20',
                'ciudadAlcaldia' => 'required|string|max:100',
                'fechaEmision' => 'required|date',
                'tipoDocumento' => 'required|string',
                'numeroDocumento' => 'required|string|max:50',
                'nombreBeneficiario' => 'required|string|max:255',
                'telefonoBeneficiario' => 'nullable|string|max:20',
                'direccionBeneficiario' => 'nullable|string|max:255',
                'concepto' => 'required|string',
                'periodo' => 'required|string|max:100',
                'subtotal' => 'required|numeric|min:0',
                'iva' => 'required|numeric|min:0',
                'total' => 'required|numeric|min:0',
                'banco' => 'required|string|max:100',
                'tipoCuenta' => 'required|string',
                'numeroCuenta' => 'required|string|max:50',
                'titularCuenta' => 'required|string|max:255',
                'descripcion' => 'required|array|min:1',
                'descripcion.*' => 'required|string',
                'cantidad' => 'required|array|min:1',
                'cantidad.*' => 'required|numeric|min:1',
                'valorUnitario' => 'required|array|min:1',
                'valorUnitario.*' => 'required|numeric|min:0',
                'valorTotal' => 'required|array|min:1',
                'valorTotal.*' => 'required|numeric|min:0',
            ]);

            Log::info('Validación pasada');

            // Preparar el detalle de items con conversión de tipos
            $detalleItems = [];
            foreach ($request->descripcion as $index => $descripcion) {
                // Convertir a los tipos correctos
                $cantidad = (int) $request->cantidad[$index];
                $valorUnitario = (float) $request->valorUnitario[$index];
                $valorTotal = (float) $request->valorTotal[$index];
                
                $detalleItems[] = [
                    'descripcion' => $descripcion,
                    'cantidad' => $cantidad,
                    'valor_unitario' => $valorUnitario,
                    'valor_total' => $valorTotal,
                ];
            }

            Log::info('Items procesados:', $detalleItems);

            // Convertir valores numéricos principales
            $subtotal = (float) $validated['subtotal'];
            $iva = (float) $validated['iva'];
            $total = (float) $validated['total'];

            // Actualizar la cuenta de cobro
            $cuentaCobro->update([
                'nombre_alcaldia' => $validated['nombreAlcaldia'],
                'nit_alcaldia' => $validated['nitAlcaldia'],
                'direccion_alcaldia' => $validated['direccionAlcaldia'],
                'telefono_alcaldia' => $validated['telefonoAlcaldia'],
                'ciudad_alcaldia' => $validated['ciudadAlcaldia'],
                'fecha_emision' => $validated['fechaEmision'],
                'tipo_documento' => $validated['tipoDocumento'],
                'numero_documento' => $validated['numeroDocumento'],
                'nombre_beneficiario' => $validated['nombreBeneficiario'],
                'telefono_beneficiario' => $validated['telefonoBeneficiario'] ?? null,
                'direccion_beneficiario' => $validated['direccionBeneficiario'] ?? null,
                'concepto' => $validated['concepto'],
                'periodo' => $validated['periodo'],
                'detalle_items' => json_encode($detalleItems),
                'subtotal' => $subtotal,
                'iva' => $iva,
                'total' => $total,
                'banco' => $validated['banco'],
                'tipo_cuenta' => $validated['tipoCuenta'],
                'numero_cuenta' => $validated['numeroCuenta'],
                'titular_cuenta' => $validated['titularCuenta'],
                // Resetear estado a pendiente cuando se edita
                'estado' => 'pendiente',
            ]);

            Log::info('Cuenta actualizada exitosamente: ' . $cuentaCobro->id);

            return redirect()->route('cuentas-cobro.show', $cuentaCobro->id)
                             ->with('success', 'Cuenta de cobro actualizada exitosamente');

        } catch (\Exception $e) {
            Log::error('Error en update: ' . $e->getMessage());
            Log::error('Trace: ' . $e->getTraceAsString());
            return redirect()->back()
                             ->with('error', 'Error al actualizar la cuenta de cobro: ' . $e->getMessage())
                             ->withInput();
        }
    }

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $cuentaCobro = CrearCuentaCobro::where('user_id', auth()->id())
                                        ->findOrFail($id);
            
            // Verificar si puede eliminarse
            if (in_array($cuentaCobro->estado, ['aprobado', 'finalizado'])) {
                return redirect()->route('cuentas-cobro.index')
                                ->with('error', 'No se puede eliminar una cuenta de cobro ' . $cuentaCobro->estado);
            }
            
            $cuentaCobro->delete();

            return redirect()->route('cuentas-cobro.index')
                            ->with('success', 'Cuenta de cobro eliminada exitosamente');

        } catch (\Exception $e) {
            Log::error('Error al eliminar cuenta de cobro: ' . $e->getMessage());
            return redirect()->route('cuentas-cobro.index')
                            ->with('error', 'Error al eliminar la cuenta de cobro: ' . $e->getMessage());
        }
    }
}