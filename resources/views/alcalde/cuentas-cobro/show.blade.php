@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <a href="{{ route('alcalde.cuentas-cobro.index') }}" class="text-blue-600 hover:text-blue-800">
            ← Volver a la lista
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-xl p-8">
        <!-- Encabezado -->
        <div class="border-b border-gray-200 pb-6 mb-8">
            <h1 class="text-4xl font-bold text-gray-900">Cuenta de Cobro #{{ $cuentaCobro->id }}</h1>
            <div class="mt-2">
                <span class="px-4 py-2 inline-flex text-sm leading-5 font-bold rounded-lg shadow-sm
                    @if($cuentaCobro->estado == 'aprobado') bg-green-500 text-blue-900   
                    @elseif($cuentaCobro->estado == 'rechazado') bg-red-500 text-blue
                    @elseif($cuentaCobro->estado == 'finalizado') bg-blue-600 text-blue
                    @else bg-yellow-400 text-gray-900
                    @endif">
                    {{ strtoupper($cuentaCobro->estado) }}
                </span>
            </div>
        </div>

        <!-- Información del Contratista -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Información del Contratista</h3>
                <div class="space-y-2">
                    <p><span class="font-medium">Nombre:</span> {{ $cuentaCobro->nombre_beneficiario }}</p>
                    <p><span class="font-medium">{{ $cuentaCobro->tipo_documento }}:</span> {{ $cuentaCobro->numero_documento }}</p>
                    <p><span class="font-medium">Teléfono:</span> {{ $cuentaCobro->telefono_beneficiario }}</p>
                    <p><span class="font-medium">Dirección:</span> {{ $cuentaCobro->direccion_beneficiario }}</p>
                    <p><span class="font-medium">Usuario:</span> {{ $cuentaCobro->user->name }} ({{ $cuentaCobro->user->email }})</p>
                </div>
            </div>

            <div>
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Detalles de la Cuenta</h3>
                <div class="space-y-3 bg-gray-50 p-4 rounded-lg">
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
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Información de la Alcaldía</h3>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p><span class="font-medium">Nombre:</span> {{ $cuentaCobro->nombre_alcaldia }}</p>
                <p><span class="font-medium">NIT:</span> {{ $cuentaCobro->nit_alcaldia }}</p>
                <p><span class="font-medium">Dirección:</span> {{ $cuentaCobro->direccion_alcaldia }}</p>
                <p><span class="font-medium">Ciudad:</span> {{ $cuentaCobro->ciudad_alcaldia }}</p>
                <p><span class="font-medium">Teléfono:</span> {{ $cuentaCobro->telefono_alcaldia }}</p>
            </div>
        </div>

        <!-- Concepto -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Concepto</h3>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-gray-700">{{ $cuentaCobro->concepto }}</p>
            </div>
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
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Detalle de Items</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Descripción</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cantidad</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Valor Unitario</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($detalleItems as $item)
                                <tr>
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

        <!-- Información bancaria -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Información Bancaria</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p><span class="font-medium">Banco:</span> {{ $cuentaCobro->banco }}</p>
                    <p><span class="font-medium">Tipo de cuenta:</span> {{ $cuentaCobro->tipo_cuenta }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p><span class="font-medium">Número de cuenta:</span> {{ $cuentaCobro->numero_cuenta }}</p>
                    <p><span class="font-medium">Titular:</span> {{ $cuentaCobro->titular_cuenta }}</p>
                </div>
            </div>
        </div>

        <!-- Historial de revisión -->
        @if($cuentaCobro->supervisor)
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Historial de Revisión</h3>
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="font-medium text-gray-900">Revisado por: {{ $cuentaCobro->supervisor->name }}</p>
                            <p class="text-sm text-gray-600">{{ $cuentaCobro->fecha_revision?->format('d/m/Y H:i') }}</p>
                            @if($cuentaCobro->observaciones)
                                <p class="mt-2 text-sm text-gray-700"><span class="font-medium">Observaciones:</span> {{ $cuentaCobro->observaciones }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Acciones según estado -->
        @if($cuentaCobro->estado == 'pendiente')
            <div class="border-t pt-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-6">Acciones Disponibles</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Aprobar -->
                    <div class="bg-white rounded-lg shadow-lg p-6 border border-gray-100">
                        <h4 class="text-lg font-semibold text-green-600 mb-4">Aprobar Cuenta</h4>
                        <form method="POST" action="{{ route('alcalde.cuentas-cobro.aprobar', $cuentaCobro->id) }}">
                            @csrf
                            <textarea name="observaciones" rows="3" class="w-full border-gray-300 rounded-lg mb-4" placeholder="Observaciones (opcional)"></textarea>
                            <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700">Aprobar</button>
                        </form>
                    </div>
                    <!-- Rechazar -->
                    <div class="bg-white rounded-lg shadow-lg p-6 border border-gray-100">
                        <h4 class="text-lg font-semibold text-red-600 mb-4">Rechazar Cuenta</h4>
                        <form method="POST" action="{{ route('alcalde.cuentas-cobro.rechazar', $cuentaCobro->id) }}">
                            @csrf
                            <textarea name="observaciones" rows="3" class="w-full border-gray-300 rounded-lg mb-4" placeholder="Motivo del rechazo" required></textarea>
                            <button type="submit" class="w-full bg-red-600 text-white py-3 rounded-lg hover:bg-red-700">Rechazar</button>
                        </form>
                    </div>
                </div>
            </div>
        @elseif($cuentaCobro->estado == 'aprobado')
            <div class="border-t pt-8 mt-6">
                <div class="flex justify-center">
                    <form method="POST" action="{{ route('alcalde.cuentas-cobro.finalizar', $cuentaCobro->id) }}">
                        @csrf
                        <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700">Marcar como Finalizada/Pagada</button>
                    </form>
                </div>
            </div>
        @elseif($cuentaCobro->estado == 'finalizado')
            <div class="border-t pt-8 mt-6 text-center text-gray-600 font-semibold">
                Esta cuenta de cobro ya fue finalizada/pagada.
            </div>
        @elseif($cuentaCobro->estado == 'rechazado')
            <div class="border-t pt-8 mt-6 text-center text-red-600 font-semibold">
                Esta cuenta de cobro ha sido rechazada.
            </div>
        @endif

    </div>
</div>
@endsection
