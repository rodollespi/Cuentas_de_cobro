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

    {{-- Estadísticas --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h5>Total Cuentas</h5>
                    <h2>{{ $cuentasCobro->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <h5>Pendientes</h5>
                    <h2>{{ $cuentasCobro->filter(function($cuenta) { $s = strtolower($cuenta->estado ?? ''); return str_contains($s, 'pendient'); })->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h5>Aprobadas</h5>
                    <h2>{{ $cuentasCobro->filter(function($cuenta) { $s = strtolower($cuenta->estado ?? ''); return str_contains($s, 'aproba'); })->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body text-center">
                    <h5>Rechazadas</h5>
                    <h2>{{ $cuentasCobro->filter(function($cuenta) { $s = strtolower($cuenta->estado ?? ''); return str_contains($s, 'rechaz'); })->count() }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Contenedor principal: Listados y gráfico --}}
    <div class="row">
        {{-- Listado de cuentas --}}
        <div class="col-md-8">
            {{-- Pendientes --}}
            <div class="card mb-4">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">Cuentas de Cobro Pendientes</h5>
                </div>
                <div class="card-body">
                    @include('cuentas-cobro.partials.tabla', ['cuentas' => $cuentasCobro->filter(function($cuenta) { $s = strtolower($cuenta->estado ?? ''); return str_contains($s, 'pendient'); })])
                </div>
            </div>

            {{-- Aprobadas --}}
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Cuentas de Cobro Aprobadas</h5>
                </div>
                <div class="card-body">
                    @include('cuentas-cobro.partials.tabla', ['cuentas' => $cuentasCobro->filter(function($cuenta) { $s = strtolower($cuenta->estado ?? ''); return str_contains($s, 'aproba'); })])
                </div>
            </div>

            {{-- Rechazadas --}}
            <div class="card mb-4">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Cuentas de Cobro Rechazadas</h5>
                </div>
                <div class="card-body">
                    @include('cuentas-cobro.partials.tabla', ['cuentas' => $cuentasCobro->filter(function($cuenta) { $s = strtolower($cuenta->estado ?? ''); return str_contains($s, 'rechaz'); })])
                </div>
            </div>
        </div>

        {{-- Gráfico y Acciones --}}
        <div class="col-md-4">
            {{-- Gráfico --}}
            <div class="card mb-4">
                <div class="card-body text-center">
                    <h5>Resumen Gráfico</h5>
                    <canvas id="estadisticasCuentas" width="250" height="250"></canvas>
                </div>
            </div>

            {{-- Acciones Rápidas --}}
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>
                        Acciones Rápidas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('cuentas-cobro.create') }}" class="btn btn-success btn-lg">
                            <i class="fas fa-plus-circle me-2"></i>
                            Nueva Cuenta de Cobro
                        </a>
                        <button class="btn btn-info btn-lg" onclick="window.print()">
                            <i class="fas fa-print me-2"></i>
                            Imprimir Listado
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Pendientes', 'Aprobadas', 'Rechazadas'],
            datasets: [{
                data: [
                    {{ $cuentasCobro->filter(function($cuenta) { $s = strtolower($cuenta->estado ?? ''); return str_contains($s, 'pendient'); })->count() }},
                    {{ $cuentasCobro->filter(function($cuenta) { $s = strtolower($cuenta->estado ?? ''); return str_contains($s, 'aproba'); })->count() }},
                    {{ $cuentasCobro->filter(function($cuenta) { $s = strtolower($cuenta->estado ?? ''); return str_contains($s, 'rechaz'); })->count() }}
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
});
</script>
@endsection