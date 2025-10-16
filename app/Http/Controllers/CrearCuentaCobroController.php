<?php

namespace App\Http\Controllers;

use App\Models\CrearCuentaCobro;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CrearCuentaCobroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('CuentasDeCobro');
    }

     public function almacenar(Request $request)
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

        // Preparar el detalle de items (descripción, cantidad, valores)
        $detalleItems = [];
        if ($request->has('descripcion')) {
            foreach ($request->descripcion as $index => $descripcion) {
                $detalleItems[] = [
                    'descripcion' => $descripcion,
                    'cantidad' => $request->cantidad[$index],
                    'valor_unitario' => $request->valorUnitario[$index],
                    'valor_total' => $request->valorTotal[$index],
                ];
            }
        }

        // Crear la cuenta de cobro en la base de datos
        CrearCuentaCobro::create([
            'nombre_alcaldia' => $request->nombreAlcaldia,
            'nit_alcaldia' => $request->nitAlcaldia,
            'direccion_alcaldia' => $request->direccionAlcaldia,
            'telefono_alcaldia' => $request->telefonoAlcaldia,
            'ciudad_alcaldia' => $request->ciudadAlcaldia,
            'fecha_emision' => $request->fechaEmision,
            'tipo_documento' => $request->tipoDocumento,
            'numero_documento' => $request->numeroDocumento,
            'nombre_beneficiario' => $request->nombreBeneficiario,
            'telefono_beneficiario' => $request->telefonoBeneficiario,
            'direccion_beneficiario' => $request->direccionBeneficiario,
            'concepto' => $request->concepto,
            'periodo' => $request->periodo,
            'detalle_items' => $detalleItems,
            'subtotal' => $request->subtotal,
            'iva' => $request->iva,
            'total' => $request->total,
            'banco' => $request->banco,
            'tipo_cuenta' => $request->tipoCuenta,
            'numero_cuenta' => $request->numeroCuenta,
            'titular_cuenta' => $request->titularCuenta,
        ]);

        // Redirigir con mensaje de éxito
        return redirect()->route('dashboard')->with('success', 'Cuenta de cobro creada exitosamente');
    }


public function subirDocumento(Request $request)
{
    $request->validate([
        'documento_pdf' => 'required|file|mimes:pdf|max:5120', // Máx 5MB
    ]);

    // Guardar el archivo en storage/app/public/documentos_pdf
    $pdfPath = $request->file('documento_pdf')->store('documentos_pdf', 'public');

    // Aquí puedes registrar el archivo en la base de datos si lo deseas
    // Ejemplo:
    // Documento::create([
    //     'ruta' => $pdfPath,
    //     'usuario_id' => auth()->id(),
    // ]);

    return redirect()->back()->with('success', 'Documento PDF subido correctamente.');
}
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CrearCuentaCobro $crearCuentaCobro)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CrearCuentaCobro $crearCuentaCobro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CrearCuentaCobro $crearCuentaCobro)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CrearCuentaCobro $crearCuentaCobro)
    {
        //
    }
}
