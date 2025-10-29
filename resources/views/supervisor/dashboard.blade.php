@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="text-center mb-4">Panel del Supervisor</h2>

    {{-- Alertas --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Estadísticas --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h5>Total Cuentas</h5>
                    <h2>{{ $total }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <h5>Pendientes</h5>
                    <h2>{{ $pendientes }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h5>Aprobadas</h5>
                    <h2>{{ $aprobadas }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body text-center">
                    <h5>Rechazadas</h5>
                    <h2>{{ $rechazadas }}</h2>
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
                    <h5 class="mb-0">Listado de Cuentas de Cobro Pendientes</h5>
                </div>
                <div class="card-body">
                    @include('supervisor.partials.tabla', ['cuentas' => $cuentas->where("estado", "pendiente")])
                </div>
            </div>

            {{-- Aprobadas --}}
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Listado de Cuentas de Cobro Aprobadas</h5>
                </div>
                <div class="card-body">
                    @include('supervisor.partials.tabla', ['cuentas' => $cuentas->where("estado", "aprobada")])
                </div>
            </div>

            {{-- Rechazadas --}}
            <div class="card mb-4">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Listado de Cuentas de Cobro Rechazadas</h5>
                </div>
                <div class="card-body">
                    @include('supervisor.partials.tabla', ['cuentas' => $cuentas->where("estado", "rechazada")])
                </div>
            </div>
        </div>

        {{-- Gráfico --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5>Resumen Gráfico</h5>
                    <canvas id="graficoCuentas" width="250" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script del gráfico --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('graficoCuentas');
new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Pendientes', 'Aprobadas', 'Rechazadas'],
        datasets: [{
            data: [{{ $pendientes }}, {{ $aprobadas }}, {{ $rechazadas }}],
            backgroundColor: ['#ffc107', '#28a745', '#dc3545']
        }]
    },
    options: {
        plugins: { legend: { position: 'bottom' } }
    }
});
</script>
@endsection
