@extends('layouts.app')

@section('title', 'Cuentas de Cobro')

@push('styles')
<style>
    .section-title {
        font-size: 1.4rem;
        font-weight: bold;
        margin-top: 2rem;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #007bff;
    }
    .status-badge {
        padding: 0.25rem 0.75rem;
        font-weight: 600;
        border-radius: 0.5rem;
        color: white;
        text-transform: uppercase;
        font-size: 0.75rem;
    }
    .status-pendiente { background-color: #f0ad4e; }
    .status-aprobada { background-color: #28a745; }
    .status-rechazada { background-color: #dc3545; }
    .status-finalizada { background-color: #dd3c95ff; }

    #graficaEstados, #graficaTotales {
        max-width: 600px;   
        height: 300px !important; 
        margin: auto;      
        display: block;
    }
    
    .action-buttons {
        margin-bottom: 2rem;
    }
    
    .stats-card {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        margin-bottom: 1rem;
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #6c757d;
    }
</style>
@endpush

@section('content')
<div class="container">

    {{-- ======================= HEADER Y BOTONES ======================= --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Gestión de Cuentas de Cobro</h1>
        <div class="action-buttons">
            <a href="{{ route('cuentas-cobro.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Crear Cuenta de Cobro
            </a>
            <a href="{{ route('contratista.documentos') }}" class="btn btn-outline-primary">
                <i class="fas fa-upload me-2"></i>Subir Documentos
            </a>
        </div>
    </div>

{{-- ======================= ESTADÍSTICAS RÁPIDAS ======================= --}}
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card stats-card bg-primary text-white">
            <div class="card-body text-center">
                <h5 class="card-title">Total</h5>
                <h2 class="mb-0">{{ $totalCuentas }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card stats-card bg-warning text-white">
            <div class="card-body text-center">
                <h5 class="card-title">Pendientes</h5>
                <h2 class="mb-0">{{ $conteoEstados['pendientes'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card stats-card bg-success text-white">
            <div class="card-body text-center">
                <h5 class="card-title">Aprobadas</h5>
                <h2 class="mb-0">{{ $conteoEstados['aprobadas'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card stats-card bg-danger text-white">
            <div class="card-body text-center">
                <h5 class="card-title">Rechazadas</h5>
                <h2 class="mb-0">{{ $conteoEstados['rechazadas'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card bg-info text-white">
            <div class="card-body text-center">
                <h5 class="card-title">Finalizadas</h5>
                <h2 class="mb-0">{{ $conteoEstados['finalizadas'] }}</h2>
            </div>
        </div>
    </div>
</div>

    {{-- ======================= PENDIENTES ======================= --}}
    <div class="section-title">
        <i class="fas fa-clock me-2"></i>Cuentas Pendientes
        <span class="badge bg-warning ms-2">{{ $conteoEstados['pendientes'] }}</span>
    </div>
    @if($pendientes && $pendientes->count() > 0)
        @include('partials.tabla_cuentas', ['cuentas' => $pendientes])
    @else
        <div class="empty-state">
            <i class="fas fa-clock fa-3x mb-3"></i>
            <h5>No hay cuentas pendientes</h5>
            <p>Todas tus cuentas han sido procesadas.</p>
        </div>
    @endif

    {{-- ======================= APROBADAS ======================= --}}
    <div class="section-title">
        <i class="fas fa-check-circle me-2"></i>Cuentas Aprobadas
        <span class="badge bg-success ms-2">{{ $conteoEstados['aprobadas'] }}</span>
    </div>
    @if($aprobadas && $aprobadas->count() > 0)
        @include('partials.tabla_cuentas', ['cuentas' => $aprobadas])
    @else
        <div class="empty-state">
            <i class="fas fa-check-circle fa-3x mb-3"></i>
            <h5>No hay cuentas aprobadas</h5>
            <p>Las cuentas aprobadas aparecerán aquí.</p>
        </div>
    @endif

    {{-- ======================= RECHAZADAS ======================= --}}
    <div class="section-title">
        <i class="fas fa-times-circle me-2"></i>Cuentas Rechazadas
        <span class="badge bg-danger ms-2">{{ $conteoEstados['rechazadas'] }}</span>
    </div>
    @if($rechazadas && $rechazadas->count() > 0)
        @include('partials.tabla_cuentas', ['cuentas' => $rechazadas])
    @else
        <div class="empty-state">
            <i class="fas fa-times-circle fa-3x mb-3"></i>
            <h5>No hay cuentas rechazadas</h5>
            <p>Las cuentas rechazadas aparecerán aquí.</p>
        </div>
    @endif

    {{-- ======================= FINALIZADAS ======================= --}}
    <div class="section-title">
        <i class="fas fa-flag-checkered me-2"></i>Cuentas Finalizadas
        <span class="badge bg-info ms-2">{{ $conteoEstados['finalizadas'] }}</span>
    </div>
    @if($finalizadas && $finalizadas->count() > 0)
        @include('partials.tabla_cuentas', ['cuentas' => $finalizadas])
    @else
        <div class="empty-state">
            <i class="fas fa-flag-checkered fa-3x mb-3"></i>
            <h5>No hay cuentas finalizadas</h5>
            <p>Las cuentas finalizadas aparecerán aquí.</p>
        </div>
    @endif

    {{-- ======================= GRÁFICAS ======================= --}}
    <div class="row mt-5">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Distribución por Estado
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="graficaEstados"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-pie me-2"></i>Resumen General
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="graficaTotales"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gráfica de barras - Estados
    const ctxEstados = document.getElementById('graficaEstados').getContext('2d');
    new Chart(ctxEstados, {
        type: 'bar',
        data: {
            labels: ['Pendientes', 'Aprobadas', 'Rechazadas', 'Finalizadas'],
            datasets: [{
                label: 'Cantidad de Cuentas',
                data: [
                    {{ $conteoEstados['pendientes'] }},
                    {{ $conteoEstados['aprobadas'] }},
                    {{ $conteoEstados['rechazadas'] }},
                    {{ $conteoEstados['finalizadas'] }}
                ],
                backgroundColor: [
                    '#f0ad4e',
                    '#28a745',
                    '#dc3545',
                    '#0275d8'
                ],
                borderColor: [
                    '#ec971f',
                    '#218838',
                    '#c82333',
                    '#025aa5'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Gráfica de doughnut - Total
    const ctxTotal = document.getElementById('graficaTotales').getContext('2d');
    new Chart(ctxTotal, {
        type: 'doughnut',
        data: {
            labels: ['Pendientes', 'Aprobadas', 'Rechazadas', 'Finalizadas'],
            datasets: [{
                data: [
                    {{ $conteoEstados['pendientes'] }},
                    {{ $conteoEstados['aprobadas'] }},
                    {{ $conteoEstados['rechazadas'] }},
                    {{ $conteoEstados['finalizadas'] }}
                ],
                backgroundColor: [
                    '#f0ad4e',
                    '#28a745',
                    '#dc3545',
                    '#0275d8'
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = Math.round((value / total) * 100);
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush