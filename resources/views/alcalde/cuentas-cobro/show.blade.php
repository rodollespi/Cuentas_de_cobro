@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <a href="{{ route('alcalde.cuentas-cobro.index') }}" class="text-blue-600 hover:text-blue-800">
            ← Volver a la lista
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-xl p-8 stats-card">
        <!-- Encabezado -->
        <div class="border-b border-gray-200 pb-6 mb-8">
            <h1 class="text-4xl font-bold text-gray-900">Cuenta de Cobro #{{ $cuentaCobro->id }}</h1>
            <div class="mt-2">
                <span class="px-4 py-2 inline-flex text-sm leading-5 font-bold rounded-lg shadow-sm
                    @if($cuentaCobro->estado == 'aprobado') bg-green-500 text-white
                    @elseif($cuentaCobro->estado == 'rechazado') bg-red-500 text-white
                    @elseif($cuentaCobro->estado == 'finalizado') bg-blue-600 text-white
                    @else bg-yellow-400 text-gray-900
                    @endif">
                    {{ strtoupper($cuentaCobro->estado) }}
                </span>
            </div>
        </div>

        <!-- Información del Contratista -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="stats-card p-4 bg-primary-light rounded-lg">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Información del Contratista</h3>
                <div class="space-y-2">
                    <p><span class="font-medium">Nombre:</span> {{ $cuentaCobro->nombre_beneficiario }}</p>
                    <p><span class="font-medium">{{ $cuentaCobro->tipo_documento }}:</span> {{ $cuentaCobro->numero_documento }}</p>
                    <p><span class="font-medium">Teléfono:</span> {{ $cuentaCobro->telefono_beneficiario }}</p>
                    <p><span class="font-medium">Dirección:</span> {{ $cuentaCobro->direccion_beneficiario }}</p>
                    <p><span class="font-medium">Usuario:</span> {{ $cuentaCobro->user->name }} ({{ $cuentaCobro->user->email }})</p>
                </div>
            </div>

            <div class="stats-card p-4 bg-success-light rounded-lg">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Detalles de la Cuenta</h3>
                <div class="space-y-3">
                    <p class="flex justify-between items-center">
                        <span class="font-medium text-gray-600">Período:</span>
                        <span class="text-gray-900">{{ $cuentaCobro->periodo }}</span>
                    </p>
                    <p class="flex justify-between items-center">
                        <span class="font-medium text-gray-600">Fecha emisión:</span>
                        <span class="text-gray-900">{{ $cuentaCobro->fecha_emision->format('d/m/Y') }}</span>
                    </p>
                    <p class="flex justify-between items-center">
                        <span class="font-medium text-gray-600">Subtotal:</span>
                        <span class="text-gray-900">${{ number_format($cuentaCobro->subtotal, 2) }}</span>
                    </p>
                    <p class="flex justify-between items-center">
                        <span class="font-medium text-gray-600">IVA:</span>
                        <span class="text-gray-900">${{ number_format($cuentaCobro->iva, 2) }}</span>
                    </p>
                    <div class="pt-2 mt-2 border-t border-gray-200 flex justify-between items-center">
                        <span class="font-semibold text-gray-700">Total:</span>
                        <span class="text-2xl font-bold text-green-600">${{ number_format($cuentaCobro->total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información de la Alcaldía -->
        <div class="mb-6 stats-card p-4 bg-warning-light rounded-lg">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Información de la Alcaldía</h3>
            <p><span class="font-medium">Nombre:</span> {{ $cuentaCobro->nombre_alcaldia }}</p>
            <p><span class="font-medium">NIT:</span> {{ $cuentaCobro->nit_alcaldia }}</p>
            <p><span class="font-medium">Dirección:</span> {{ $cuentaCobro->direccion_alcaldia }}</p>
            <p><span class="font-medium">Ciudad:</span> {{ $cuentaCobro->ciudad_alcaldia }}</p>
            <p><span class="font-medium">Teléfono:</span> {{ $cuentaCobro->telefono_alcaldia }}</p>
        </div>

        <!-- Concepto -->
        <div class="mb-6 stats-card p-4 bg-gray-50 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Concepto</h3>
            <p>{{ $cuentaCobro->concepto }}</p>
        </div>

        <!-- Detalle de Items -->
        @php
            $detalleItems = $cuentaCobro->detalle_items;
            if (is_string($detalleItems)) {
                $decoded = json_decode($detalleItems, true);
                $detalleItems = is_array($decoded) ? $decoded : [];
            }
            if (!is_array($detalleItems) && !($detalleItems instanceof \Illuminate\Support\Collection)) {
                $detalleItems = [];
            }
        @endphp

        @if(!empty($detalleItems))
            <div class="mb-6 stats-card p-4 bg-white rounded-lg shadow-lg">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Detalle de Items</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Descripción</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cantidad</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Valor Unitario</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($detalleItems as $item)
                                <tr class="hover:bg-gray-50 transition-all">
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $item['descripcion'] ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $item['cantidad'] ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">${{ number_format($item['valor_unitario'] ?? 0, 2) }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">${{ number_format($item['valor_total'] ?? 0, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Aquí seguirían la Información Bancaria, Historial, Acciones, etc. -->
        <!-- Solo agregando la clase stats-card y colores de fondo para dar más estilo -->

    </div>
</div>
@endsection

@push('styles')
<style>
    /* Cards de estadísticas */
    .stats-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    .bg-primary-light { background-color: rgba(78, 115, 223, 0.1); }
    .bg-success-light { background-color: rgba(28, 200, 138, 0.1); }
    .bg-warning-light { background-color: rgba(246, 194, 62, 0.1); }
    .bg-danger-light { background-color: rgba(231, 74, 59, 0.1); }

    table tbody tr:hover {
        background-color: rgba(78, 115, 223, 0.05);
    }
</style>
@endpush
