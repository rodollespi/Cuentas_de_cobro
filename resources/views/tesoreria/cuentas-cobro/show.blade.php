@extends('tesoreria.layouts.app')
@section('title', 'Cuenta de Cobro #'.$cuentaCobro->id)

@push('styles')
<style>
    .section-card {
        background-color: #ffffff;
        padding: 1.5rem;
        border-radius: 0.75rem;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        margin-bottom: 1.5rem;
    }
    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
        color: #111827;
    }
    .status-badge {
        padding: 0.25rem 0.75rem;
        font-weight: 600;
        border-radius: 0.5rem;
        text-transform: uppercase;
        font-size: 0.75rem;
        color: white;
    }
    .status-pendiente { background-color: #FACC15; color: #1F2937; }
    .status-aprobado { background-color: #10B981; }
    .status-rechazado { background-color: #EF4444; }
    .status-finalizado { background-color: #3B82F6; }
</style>
@endpush

@section('content')
<h1 class="text-3xl font-bold mb-6">Cuenta de Cobro #{{ $cuentaCobro->id }}</h1>

<!-- Estado -->
<div class="mb-6">
    <span class="status-badge
        @if($cuentaCobro->estado == 'pendiente') status-pendiente
        @elseif($cuentaCobro->estado == 'aprobado') status-aprobado
        @elseif($cuentaCobro->estado == 'rechazado') status-rechazado
        @elseif($cuentaCobro->estado == 'finalizado') status-finalizado
        @endif">
        {{ strtoupper($cuentaCobro->estado) }}
    </span>
</div>

<!-- Información del Beneficiario -->
<div class="section-card">
    <h3 class="section-title">Beneficiario</h3>
    <p><strong>Nombre:</strong> {{ $cuentaCobro->nombre_beneficiario }}</p>
    <p><strong>Documento:</strong> {{ $cuentaCobro->tipo_documento }} - {{ $cuentaCobro->numero_documento }}</p>
    <p><strong>Teléfono:</strong> {{ $cuentaCobro->telefono_beneficiario }}</p>
</div>

<!-- Detalles -->
<div class="section-card">
    <h3 class="section-title">Detalles de la Cuenta</h3>
    <p><strong>Período:</strong> {{ $cuentaCobro->periodo }}</p>
    <p><strong>Fecha emisión:</strong> {{ $cuentaCobro->fecha_emision->format('d/m/Y') }}</p>
    <p><strong>Subtotal:</strong> ${{ number_format($cuentaCobro->subtotal,2) }}</p>
    <p><strong>IVA:</strong> ${{ number_format($cuentaCobro->iva,2) }}</p>
    <p><strong>Total:</strong> ${{ number_format($cuentaCobro->total,2) }}</p>
</div>

<!-- Items -->
@if(!empty($cuentaCobro->detalle_items))
<div class="section-card">
    <h3 class="section-title">Detalle de Items</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Descripción</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Cantidad</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Valor Unitario</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($cuentaCobro->detalle_items as $item)
                    <tr>
                        <td class="px-4 py-2">{{ $item['descripcion'] ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ $item['cantidad'] ?? 'N/A' }}</td>
                        <td class="px-4 py-2">${{ number_format($item['valor_unitario'] ?? 0,2) }}</td>
                        <td class="px-4 py-2">${{ number_format($item['valor_total'] ?? 0,2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<!-- Acciones -->
@if($cuentaCobro->estado == 'pendiente')
<div class="section-card">
    <h3 class="section-title">Procesar Pago</h3>
    <form method="POST" action="{{ route('tesoreria.pagos.confirmar') }}">
        @csrf
        <input type="hidden" name="cuenta_id" value="{{ $cuentaCobro->id }}">
        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Confirmar Pago</button>
    </form>
</div>
@endif

@endsection
