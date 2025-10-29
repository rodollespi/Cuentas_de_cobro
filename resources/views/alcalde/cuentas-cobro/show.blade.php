@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <a href="{{ route('alcalde.cuentas-cobro.index') }}" class="text-blue-600 hover:text-blue-800">
            ← Volver a la lista
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <!-- Encabezado -->
        <div class="border-b pb-4 mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Cuenta de Cobro #{{ $cuentaCobro->id }}</h1>
            <div class="mt-2">
                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                    @if($cuentaCobro->estado == 'aprobado') bg-green-100 text-green-800
                    @elseif($cuentaCobro->estado == 'rechazado') bg-red-100 text-red-800
                    @elseif($cuentaCobro->estado == 'finalizado') bg-blue-100 text-blue-800
                    @else bg-yellow-100 text-yellow-800
                    @endif">
                    {{ ucfirst($cuentaCobro->estado) }}
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
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Detalles de la Cuenta</h3>
                <div class="space-y-2">
                    <p><span class="font-medium">Período:</span> {{ $cuentaCobro->periodo }}</p>
                    <p><span class="font-medium">Fecha emisión:</span> {{ $cuentaCobro->fecha_emision->format('d/m/Y') }}</p>
                    <p><span class="font-medium">Subtotal:</span> ${{ number_format($cuentaCobro->subtotal, 2) }}</p>
                    <p><span class="font-medium">IVA:</span> ${{ number_format($cuentaCobro->iva, 2) }}</p>
                    <p><span class="font-medium">Total:</span> <span class="text-xl font-bold text-green-600">${{ number_format($cuentaCobro->total, 2) }}</span></p>
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

        <!-- Concepto y detalles -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Concepto</h3>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-gray-700">{{ $cuentaCobro->concepto }}</p>
            </div>
        </div>

        <!-- Detalle de Items -->
        @if($cuentaCobro->detalle_items)
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
                            @foreach($cuentaCobro->detalle_items as $item)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $item['descripcion'] ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $item['cantidad'] ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">${{ number_format($item['valor_unitario'] ?? 0, 2) }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">${{ number_format($item['total'] ?? 0, 2) }}</td>
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

        <!-- Acciones -->
        @if($cuentaCobro->estado == 'pendiente')
            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Acciones</h3>
                
                <form method="POST" action="{{ route('alcalde.cuentas-cobro.aprobar', $cuentaCobro->id) }}" class="mb-4">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Observaciones (opcional)</label>
                        <textarea name="observaciones" rows="3" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Agregue sus observaciones..."></textarea>
                    </div>
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700">
                        ✓ Aprobar Cuenta de Cobro
                    </button>
                </form>

                <form method="POST" action="{{ route('alcalde.cuentas-cobro.rechazar', $cuentaCobro->id) }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Motivo del rechazo (requerido)</label>
                        <textarea name="observaciones" rows="3" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Explique el motivo del rechazo..." required></textarea>
                    </div>
                    <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-md hover:bg-red-700">
                        ✗ Rechazar Cuenta de Cobro
                    </button>
                </form>
            </div>
        @elseif($cuentaCobro->estado == 'aprobado')
            <div class="border-t pt-6">
                <form method="POST" action="{{ route('alcalde.cuentas-cobro.finalizar', $cuentaCobro->id) }}">
                    @csrf
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                        Marcar como Finalizada/Pagada
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection