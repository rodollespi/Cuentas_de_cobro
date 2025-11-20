<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cuenta de Cobro #{{ $cuentaCobro->id }}</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 12px;
            line-height: 1.4;
        }
        .header { 
            text-align: center; 
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .section { 
            margin-bottom: 15px; 
        }
        .table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 10px 0;
        }
        .table th, .table td { 
            border: 1px solid #ddd; 
            padding: 6px; 
            text-align: left;
        }
        .table th { 
            background-color: #f2f2f2; 
            font-weight: bold;
        }
        .text-right { 
            text-align: right; 
        }
        .text-center { 
            text-align: center; 
        }
        .total-section { 
            margin-top: 20px; 
            border-top: 1px solid #333;
            padding-top: 10px;
        }
        .signature-section {
            margin-top: 50px;
            text-align: center;
        }
        .footer {
            margin-top: 30px;
            font-size: 10px;
            text-align: center;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="margin: 0; font-size: 18px;">CUENTA DE COBRO</h1>
        <p style="margin: 5px 0; font-size: 14px;">N° {{ $cuentaCobro->id }}</p>
        <p style="margin: 0; font-size: 12px;">Fecha de emisión: {{ \Carbon\Carbon::parse($cuentaCobro->fecha_emision)->format('d/m/Y') }}</p>
    </div>

    <div class="section">
        <h3 style="margin: 0 0 8px 0; font-size: 14px; border-bottom: 1px solid #ccc; padding-bottom: 3px;">
            INFORMACIÓN DE LA ALCALDÍA
        </h3>
        <table style="width: 100%;">
            <tr>
                <td style="width: 30%;"><strong>Nombre:</strong></td>
                <td>{{ $cuentaCobro->nombre_alcaldia }}</td>
            </tr>
            <tr>
                <td><strong>NIT:</strong></td>
                <td>{{ $cuentaCobro->nit_alcaldia }}</td>
            </tr>
            <tr>
                <td><strong>Dirección:</strong></td>
                <td>{{ $cuentaCobro->direccion_alcaldia }}</td>
            </tr>
            <tr>
                <td><strong>Teléfono:</strong></td>
                <td>{{ $cuentaCobro->telefono_alcaldia }}</td>
            </tr>
            <tr>
                <td><strong>Ciudad:</strong></td>
                <td>{{ $cuentaCobro->ciudad_alcaldia }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h3 style="margin: 0 0 8px 0; font-size: 14px; border-bottom: 1px solid #ccc; padding-bottom: 3px;">
            INFORMACIÓN DEL BENEFICIARIO
        </h3>
        <table style="width: 100%;">
            <tr>
                <td style="width: 30%;"><strong>Nombre:</strong></td>
                <td>{{ $cuentaCobro->nombre_beneficiario }}</td>
            </tr>
            <tr>
                <td><strong>Documento:</strong></td>
                <td>{{ $cuentaCobro->tipo_documento }} {{ $cuentaCobro->numero_documento }}</td>
            </tr>
            @if($cuentaCobro->telefono_beneficiario)
            <tr>
                <td><strong>Teléfono:</strong></td>
                <td>{{ $cuentaCobro->telefono_beneficiario }}</td>
            </tr>
            @endif
            @if($cuentaCobro->direccion_beneficiario)
            <tr>
                <td><strong>Dirección:</strong></td>
                <td>{{ $cuentaCobro->direccion_beneficiario }}</td>
            </tr>
            @endif
        </table>
    </div>

    <div class="section">
        <h3 style="margin: 0 0 8px 0; font-size: 14px; border-bottom: 1px solid #ccc; padding-bottom: 3px;">
            DETALLE DE LA CUENTA
        </h3>
        <table style="width: 100%;">
            <tr>
                <td style="width: 30%;"><strong>Concepto:</strong></td>
                <td>{{ $cuentaCobro->concepto }}</td>
            </tr>
            <tr>
                <td><strong>Período:</strong></td>
                <td>{{ $cuentaCobro->periodo }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h3 style="margin: 0 0 8px 0; font-size: 14px; border-bottom: 1px solid #ccc; padding-bottom: 3px;">
            DETALLE DE ITEMS
        </h3>
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 50%;">Descripción</th>
                    <th style="width: 15%; text-align: center;">Cantidad</th>
                    <th style="width: 20%; text-align: right;">Valor Unitario</th>
                    <th style="width: 15%; text-align: right;">Valor Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    // Ya no necesitamos json_decode porque el casting lo convierte automáticamente
                    $detalleItems = $cuentaCobro->detalle_items ?? [];
                    $subtotalCalculado = 0;
                @endphp
                
                @if(is_array($detalleItems) && count($detalleItems) > 0)
                    @foreach($detalleItems as $item)
                    @php
                        $valorTotal = $item['valor_total'] ?? 0;
                        $subtotalCalculado += $valorTotal;
                    @endphp
                    <tr>
                        <td>{{ $item['descripcion'] ?? '' }}</td>
                        <td class="text-center">{{ $item['cantidad'] ?? 0 }}</td>
                        <td class="text-right">${{ number_format($item['valor_unitario'] ?? 0, 2) }}</td>
                        <td class="text-right">${{ number_format($valorTotal, 2) }}</td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="text-center">No se encontraron items registrados</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="total-section">
        <table style="width: 300px; margin-left: auto;">
            <tr>
                <td><strong>Subtotal:</strong></td>
                <td class="text-right">${{ number_format($cuentaCobro->subtotal, 2) }}</td>
            </tr>
            <tr>
                <td><strong>IVA ({{ number_format(($cuentaCobro->iva / $cuentaCobro->subtotal) * 100, 0) }}%):</strong></td>
                <td class="text-right">${{ number_format($cuentaCobro->iva, 2) }}</td>
            </tr>
            <tr style="border-top: 1px solid #333; font-weight: bold;">
                <td><strong>TOTAL:</strong></td>
                <td class="text-right">${{ number_format($cuentaCobro->total, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h3 style="margin: 0 0 8px 0; font-size: 14px; border-bottom: 1px solid #ccc; padding-bottom: 3px;">
            INFORMACIÓN BANCARIA
        </h3>
        <table style="width: 100%;">
            <tr>
                <td style="width: 30%;"><strong>Banco:</strong></td>
                <td>{{ $cuentaCobro->banco }}</td>
            </tr>
            <tr>
                <td><strong>Tipo de Cuenta:</strong></td>
                <td>{{ $cuentaCobro->tipo_cuenta }}</td>
            </tr>
            <tr>
                <td><strong>Número de Cuenta:</strong></td>
                <td>{{ $cuentaCobro->numero_cuenta }}</td>
            </tr>
            <tr>
                <td><strong>Titular:</strong></td>
                <td>{{ $cuentaCobro->titular_cuenta }}</td>
            </tr>
        </table>
    </div>

    <div class="signature-section">
        <p>_________________________</p>
        <p><strong>{{ $cuentaCobro->nombre_beneficiario }}</strong></p>
        <p>Firma del Beneficiario</p>
    </div>

    <div class="footer">
        <p>Documento generado el {{ now()->format('d/m/Y H:i:s') }}</p>
        <p>Estado: {{ strtoupper($cuentaCobro->estado) }}</p>
    </div>
</body>
</html>