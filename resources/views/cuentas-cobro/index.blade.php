@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="text-center mb-4">
        <i class="fas fa-file-invoice-dollar me-2"></i>
        Mis Cuentas de Cobro
    </h2>

    {{-- Alertas --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('cuentas-cobro.create') }}" class="btn btn-primary">
            Crear Nueva Cuenta de Cobro
        </a>

         </a>
             <a href="{{ route('contratista.documentos') }}" class="btn btn-primary">
             <i class="fas fa-upload me-2"></i> Subir Documentos
             </a>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Panel del Contratista</h5>
            
            {{-- TABLA DE CUENTAS --}}
            @if($cuentasCobro->count() > 0)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha Emisión</th>
                            <th>Concepto</th>
                            <th>Beneficiario</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cuentasCobro as $cuenta)
                        <tr>
                            <td>{{ $cuenta->id }}</td>
                            <td>{{ $cuenta->fecha_emision }}</td>
                            <td>{{ $cuenta->concepto }}</td>
                            <td>{{ $cuenta->nombre_beneficiario }}</td>
                            <td>${{ number_format($cuenta->total, 2) }}</td>
                            <td>
                                <a href="{{ route('cuentas-cobro.show', $cuenta->id) }}" class="btn btn-info btn-sm">Ver</a>
                                <a href="{{ route('cuentas-cobro.edit', $cuenta->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('cuentas-cobro.destroy', $cuenta->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            @else
                <div class="alert alert-info mt-3">
                    No hay cuentas de cobro registradas. 
                    <a href="{{ route('cuentas-cobro.create') }}">Crear la primera</a>
                </div>
            @endif

        </div> {{-- card-body --}}
    </div> {{-- card --}}
</div> {{-- container --}}

{{-- Estilos adicionales --}}
@push('styles')
<style>
    @media print {
        .no-print { display: none !important; }
    }
</style>
@endpush

{{-- Script del gráfico --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('estadisticasCuentas');
    if (ctx) {
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Pendientes', 'Aprobadas', 'Rechazadas'],
                datasets: [{
                    data: [
                        {{ $cuentasCobro->filter(fn($c)=> str_contains(strtolower($c->estado ?? ''),'pendient'))->count() }},
                        {{ $cuentasCobro->filter(fn($c)=> str_contains(strtolower($c->estado ?? ''),'aproba'))->count() }},
                        {{ $cuentasCobro->filter(fn($c)=> str_contains(strtolower($c->estado ?? ''),'rechaz'))->count() }}
                    ],
                    backgroundColor: ['#ffc107', '#28a745', '#dc3545']
                }]
            },
            options: {
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    }
});
</script>
@endsection