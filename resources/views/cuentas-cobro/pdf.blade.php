<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cuenta de Cobro #{{ $cuentaCobro->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 20px; }
        .section { margin-bottom: 25px; }
        .section-title { background-color: #f8f9fa; padding: 8px; font-weight: bold; border-left: 4px solid #007bff; }
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f8f9fa; }
        .total-section { background-color: #f8f9fa; padding: 15px; margin-top: 20px; }
        .signature-section { margin-top: 50px; }
        .signature-line { border-top: 1px solid #333; width: 300px; margin-top: 60px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>CUENTA DE COBRO</h1>
        <p>N° {{ $cuentaCobro->id }}</p>
    </div>

    <!-- Información de la Alcaldía -->
    <div class="section">
        <div class="section-title">INFORMACIÓN DE LA ALCALDÍA</div>
        <table width="100%">
            <tr>
                <td width="50%"><strong>Nombre:</strong> {{ $cuentaCobro->nombre_alcaldia }}</td>
                <td><strong>NIT:</strong> {{ $cuentaCobro->nit_alcaldia }}</td>
            </tr>
            <tr>
                <td><strong>Dirección:</strong> {{ $cuentaCobro->direccion_alcaldia }}</td>
                <td><strong>Teléfono:</strong> {{ $cuentaCobro->telefono_alcaldia }}</td>
            </tr>
            <tr>
                <td><strong>Ciudad:</strong> {{ $cuentaCobro->ciudad_alcaldia }}</td>
                <td><strong>Fecha Emisión:</strong> {{ $cuentaCobro->fecha_emision->format('d/m/Y') }}</td>
            </tr>
        </table>
    </div>

    <!-- Información del Beneficiario -->
    <div class="section">
        <div class="section-title">INFORMACIÓN DEL BENEFICIARIO</div>
        <table width="100%">
            <tr>
                <td width="50%"><strong>Nombre:</strong> {{ $cuentaCobro->nombre_beneficiario }}</td>
                <td><strong>Documento:</strong> {{ $cuentaCobro->tipo_documento }} {{ $cuentaCobro->numero_documento }}</td>
            </tr>
            <tr>
                <td><strong>Teléfono:</strong> {{ $cuentaCobro->telefono_beneficiario ?? 'N/A' }}</td>
                <td><strong>Dirección:</strong> {{ $cuentaCobro->direccion_beneficiario ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

    <!-- Concepto y Período -->
    <div class="section">
        <div class="section-title">CONCEPTO Y PERÍODO</div>
        <p><strong>Período:</strong> {{ $cuentaCobro->periodo }}</p>
        <p><strong>Concepto:</strong> {{ $cuentaCobro->concepto }}</p>
    </div>

    <!-- Detalle de Items -->
    <div class="section">
        <div class="section-title">DETALLE DE ITEMS</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th width="15%">Cantidad</th>
                    <th width="20%">Valor Unitario</th>
                    <th width="20%">Valor Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cuentaCobro->detalle_items as $item)
                <tr>
                    <td>{{ $item['descripcion'] }}</td>
                    <td>{{ $item['cantidad'] }}</td>
                    <td>${{ number_format($item['valor_unitario'], 2) }}</td>
                    <td>${{ number_format($item['valor_total'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Totales -->
    <div class="total-section">
        <table width="100%">
            <tr>
                <td width="60%"></td>
                <td width="40%">
                    <table width="100%">
                        <tr>
                            <td><strong>Subtotal:</strong></td>
                            <td>${{ number_format($cuentaCobro->subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <td><strong>IVA:</strong></td>
                            <td>${{ number_format($cuentaCobro->iva, 2) }}</td>
                        </tr>
                        <tr>
                            <td><strong>TOTAL:</strong></td>
                            <td><strong>${{ number_format($cuentaCobro->total, 2) }}</strong></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <!-- Información Bancaria -->
    <div class="section">
        <div class="section-title">INFORMACIÓN BANCARIA</div>
        <table width="100%">
            <tr>
                <td width="50%"><strong>Banco:</strong> {{ $cuentaCobro->banco }}</td>
                <td><strong>Tipo de Cuenta:</strong> {{ $cuentaCobro->tipo_cuenta }}</td>
            </tr>
            <tr>
                <td><strong>Número de Cuenta:</strong> {{ $cuentaCobro->numero_cuenta }}</td>
                <td><strong>Titular:</strong> {{ $cuentaCobro->titular_cuenta }}</td>
            </tr>
        </table>
    </div>

    <!-- Firmas -->
    <div class="signature-section">
        <table width="100%">
            <tr>
                <td width="50%" align="center">
                    <div class="signature-line"></div>
                    <p>Firma del Beneficiario</p>
                </td>
                <td width="50%" align="center">
                    <div class="signature-line"></div>
                    <p>Firma de Recepción</p>
                </td>
            </tr>
        </table>
    </div>

    <div style="margin-top: 30px; text-align: center; font-size: 12px; color: #666;">
        <p>Documento generado el {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>