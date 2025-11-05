@extends('layouts.app')

@section('title', 'Cuentas de Cobro - Tesorería')

@push('styles')
<style>
    /* Estados */
    .status-badge {
        padding: 0.35rem 0.85rem;
        font-weight: 600;
        border-radius: 9999px; /* estilo píldora */
        color: white;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
    .status-pendiente { background-color: #FACC15; color: #1F2937; }
    .status-aprobado { background-color: #10B981; }
    .status-rechazado { background-color: #EF4444; }
    .status-finalizado { background-color: #3B82F6; }

    /* Tabla */
    .table-card {
        background: #ffffff;
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    .table-card thead {
        background-color: #f3f4f6;
    }
    .table-card tbody tr:nth-child(even) {
        background-color: #f9fafb;
    }
    .table-card tbody tr:hover {
        background-color: #e0e7ff;
        transition: background-color 0.3s ease;
    }

    /* Botones */
    .btn-action {
        padding: 0.25rem 0.75rem;
        font-weight: 600;
        border-radius: 0.5rem;
        text-transform: uppercase;
        font-size: 0.75rem;
        transition: all 0.2s;
    }
    .btn-view { background-color: #3B82F6; color: white; }
    .btn-view:hover { background-color: #2563eb; }

    .btn-pay { background-color: #10B981; color: white; }
    .btn-pay:hover { background-color: #059669; }
</style>
@endpush

@section('content')
<h1 class="text-3xl font-bold mb-6">Cuentas de Cobro</h1>

<div class="overflow-x-auto">
    <table class="min-w-full table-card divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Beneficiario</th>
                <th class="px-6 py-3 text-right text-sm font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-600 uppercase tracking-wider">Estado</th>
                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cuentasCobro as $cuenta)
            <tr>
                <td class="px-6 py-4 font-medium text-gray-700">{{ $cuenta->id }}</td>
                <td class="px-6 py-4 text-gray-800">{{ $cuenta->nombre_beneficiario }}</td>
                <td class="px-6 py-4 text-right text-gray-700 font-semibold">${{ number_format($cuenta->total, 2) }}</td>
                <td class="px-6 py-4 text-center">
                    <span class="status-badge 
                        @if($cuenta->estado == 'pendiente') status-pendiente
                        @elseif($cuenta->estado == 'aprobado') status-aprobado
                        @elseif($cuenta->estado == 'rechazado') status-rechazado
                        @elseif($cuenta->estado == 'finalizado') status-finalizado
                        @endif">
                        {{ strtoupper($cuenta->estado) }}
                    </span>
                </td>
                <td class="px-6 py-4 text-center space-x-2">
                    <a href="{{ route('tesoreria.cuentas-cobro.show', $cuenta->id) }}" class="btn-action btn-view">Ver</a>
                    @if($cuenta->estado == 'pendiente')
                    <form action="{{ route('tesoreria.pagos.confirmar') }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="cuenta_id" value="{{ $cuenta->id }}">
                        <button type="submit" class="btn-action btn-pay">Pagar</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $cuentasCobro->links() }}
</div>
@endsection
