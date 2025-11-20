@extends('layouts.app')

@section('title', 'Mis Cuentas de Cobro - CuentasCobro')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-file-invoice-dollar me-2"></i>
                        Mis Cuentas de Cobro
                    </h1>
                    <p class="text-muted mb-0">Gestiona y revisa el estado de tus cuentas de cobro</p>
                </div>
                <div>
                    <a href="{{ route('cuentas-cobro.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        Nueva Cuenta de Cobro
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Resumen Estadístico -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Pendientes
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $cuentasPendientes->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Aprobadas
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $cuentasAprobadas->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Rechazadas
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $cuentasRechazadas->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Aprobado
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                ${{ number_format($estadisticas['total_aprobado'], 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="row mb-4">
        <!-- Gráfico de Estados -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-pie me-2"></i>
                        Distribución por Estado
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="estadoPieChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfico de Ingresos por Mes -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-line me-2"></i>
                        Ingresos por Mes (Aprobados)
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="ingresosLineChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pestañas de Estados -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <ul class="nav nav-pills card-header-pills" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pendientes-tab" data-bs-toggle="tab" 
                                    data-bs-target="#pendientes" type="button" role="tab" 
                                    aria-controls="pendientes" aria-selected="true">
                                <i class="fas fa-clock me-2"></i>
                                Pendientes
                                <span class="badge bg-warning ms-2">{{ $cuentasPendientes->count() }}</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="aprobadas-tab" data-bs-toggle="tab" 
                                    data-bs-target="#aprobadas" type="button" role="tab" 
                                    aria-controls="aprobadas" aria-selected="false">
                                <i class="fas fa-check-circle me-2"></i>
                                Aprobadas
                                <span class="badge bg-success ms-2">{{ $cuentasAprobadas->count() }}</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="rechazadas-tab" data-bs-toggle="tab" 
                                    data-bs-target="#rechazadas" type="button" role="tab" 
                                    aria-controls="rechazadas" aria-selected="false">
                                <i class="fas fa-times-circle me-2"></i>
                                Rechazadas
                                <span class="badge bg-danger ms-2">{{ $cuentasRechazadas->count() }}</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="finalizadas-tab" data-bs-toggle="tab" 
                                    data-bs-target="#finalizadas" type="button" role="tab" 
                                    aria-controls="finalizadas" aria-selected="false">
                                <i class="fas fa-flag-checkered me-2"></i>
                                Finalizadas
                                <span class="badge bg-info ms-2">{{ $cuentasFinalizadas->count() }}</span>
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        
                        <!-- Pestaña Pendientes -->
                        <div class="tab-pane fade show active" id="pendientes" role="tabpanel" 
                             aria-labelledby="pendientes-tab">
                            @if($cuentasPendientes->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Beneficiario</th>
                                                <th>Concepto</th>
                                                <th>Período</th>
                                                <th>Total</th>
                                                <th>Fecha</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cuentasPendientes as $cuenta)
                                            <tr>
                                                <td>#{{ $cuenta->id }}</td>
                                                <td>{{ $cuenta->nombre_beneficiario }}</td>
                                                <td>{{ Str::limit($cuenta->concepto, 50) }}</td>
                                                <td>{{ $cuenta->periodo }}</td>
                                                <td>${{ number_format($cuenta->total, 2) }}</td>
                                                <td>{{ $cuenta->created_at->format('d/m/Y') }}</td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('cuentas-cobro.show', $cuenta->id) }}" 
                                                           class="btn btn-info" title="Ver">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('cuentas-cobro.edit', $cuenta->id) }}" 
                                                           class="btn btn-warning" title="Editar">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('cuentas-cobro.destroy', $cuenta->id) }}" 
                                                              method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger" 
                                                                    title="Eliminar"
                                                                    onclick="return confirm('¿Estás seguro de eliminar esta cuenta de cobro?')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-clock fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No hay cuentas pendientes</h5>
                                    <p class="text-muted">Todas tus cuentas han sido procesadas.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Pestaña Aprobadas -->
                        <div class="tab-pane fade" id="aprobadas" role="tabpanel" 
                             aria-labelledby="aprobadas-tab">
                            @if($cuentasAprobadas->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Beneficiario</th>
                                                <th>Concepto</th>
                                                <th>Período</th>
                                                <th>Total</th>
                                                <th>Fecha Aprobación</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cuentasAprobadas as $cuenta)
                                            <tr>
                                                <td>#{{ $cuenta->id }}</td>
                                                <td>{{ $cuenta->nombre_beneficiario }}</td>
                                                <td>{{ Str::limit($cuenta->concepto, 50) }}</td>
                                                <td>{{ $cuenta->periodo }}</td>
                                                <td>${{ number_format($cuenta->total, 2) }}</td>
                                                <td>{{ $cuenta->updated_at->format('d/m/Y') }}</td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('cuentas-cobro.show', $cuenta->id) }}" 
                                                           class="btn btn-info" title="Ver">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <button class="btn btn-success" title="Descargar PDF"
                                                                onclick="descargarPDF({{ $cuenta->id }})">
                                                            <i class="fas fa-download"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-check-circle fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No hay cuentas aprobadas</h5>
                                    <p class="text-muted">Tus cuentas aprobadas aparecerán aquí.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Pestaña Rechazadas -->
                        <div class="tab-pane fade" id="rechazadas" role="tabpanel" 
                             aria-labelledby="rechazadas-tab">
                            @if($cuentasRechazadas->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Beneficiario</th>
                                                <th>Concepto</th>
                                                <th>Período</th>
                                                <th>Total</th>
                                                <th>Fecha Rechazo</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cuentasRechazadas as $cuenta)
                                            <tr>
                                                <td>#{{ $cuenta->id }}</td>
                                                <td>{{ $cuenta->nombre_beneficiario }}</td>
                                                <td>{{ Str::limit($cuenta->concepto, 50) }}</td>
                                                <td>{{ $cuenta->periodo }}</td>
                                                <td>${{ number_format($cuenta->total, 2) }}</td>
                                                <td>{{ $cuenta->updated_at->format('d/m/Y') }}</td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('cuentas-cobro.show', $cuenta->id) }}" 
                                                           class="btn btn-info" title="Ver">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('cuentas-cobro.edit', $cuenta->id) }}" 
                                                           class="btn btn-warning" title="Editar">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('cuentas-cobro.destroy', $cuenta->id) }}" 
                                                              method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger" 
                                                                    title="Eliminar"
                                                                    onclick="return confirm('¿Estás seguro de eliminar esta cuenta de cobro?')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-times-circle fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No hay cuentas rechazadas</h5>
                                    <p class="text-muted">Tus cuentas rechazadas aparecerán aquí.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Pestaña Finalizadas -->
                        <div class="tab-pane fade" id="finalizadas" role="tabpanel" 
                             aria-labelledby="finalizadas-tab">
                            @if($cuentasFinalizadas->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Beneficiario</th>
                                                <th>Concepto</th>
                                                <th>Período</th>
                                                <th>Total</th>
                                                <th>Fecha Finalización</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cuentasFinalizadas as $cuenta)
                                            <tr>
                                                <td>#{{ $cuenta->id }}</td>
                                                <td>{{ $cuenta->nombre_beneficiario }}</td>
                                                <td>{{ Str::limit($cuenta->concepto, 50) }}</td>
                                                <td>{{ $cuenta->periodo }}</td>
                                                <td>${{ number_format($cuenta->total, 2) }}</td>
                                                <td>{{ $cuenta->updated_at->format('d/m/Y') }}</td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('cuentas-cobro.show', $cuenta->id) }}" 
                                                           class="btn btn-info" title="Ver">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <button class="btn btn-success" title="Descargar PDF"
                                                                onclick="descargarPDF({{ $cuenta->id }})">
                                                            <i class="fas fa-download"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-flag-checkered fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No hay cuentas finalizadas</h5>
                                    <p class="text-muted">Tus cuentas finalizadas aparecerán aquí.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Datos para los gráficos
const estadisticas = @json($estadisticas);

// Gráfico de Pie - Estados
const ctxPie = document.getElementById('estadoPieChart').getContext('2d');
const estadoPieChart = new Chart(ctxPie, {
    type: 'pie',
    data: {
        labels: ['Pendientes', 'Aprobadas', 'Rechazadas', 'Finalizadas'],
        datasets: [{
            data: [
                estadisticas.conteo_por_estado.pendiente || 0,
                estadisticas.conteo_por_estado.aprobado || 0,
                estadisticas.conteo_por_estado.rechazado || 0,
                estadisticas.conteo_por_estado.finalizado || 0
            ],
            backgroundColor: [
                '#ffc107', // Amarillo - Pendientes
                '#28a745', // Verde - Aprobadas
                '#dc3545', // Rojo - Rechazadas
                '#17a2b8'  // Azul - Finalizadas
            ],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',
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

// Gráfico de Línea - Ingresos por Mes
const ctxLine = document.getElementById('ingresosLineChart').getContext('2d');
const ingresosLineChart = new Chart(ctxLine, {
    type: 'line',
    data: {
        labels: estadisticas.meses,
        datasets: [{
            label: 'Ingresos Aprobados',
            data: estadisticas.totales,
            backgroundColor: 'rgba(40, 167, 69, 0.1)',
            borderColor: '#28a745',
            borderWidth: 2,
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '$' + value.toLocaleString();
                    }
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Ingresos: $' + context.parsed.y.toLocaleString();
                    }
                }
            }
        }
    }
});

// Función para descargar PDF (placeholder)
function descargarPDF(id) {
    alert('Función de descarga PDF para cuenta #' + id + ' - En desarrollo');
    // Aquí implementarás la lógica de descarga PDF
    // window.location.href = '/cuentas-cobro/' + id + '/descargar-pdf';
}

// Activar pestañas y mantener estado
document.addEventListener('DOMContentLoaded', function() {
    const tabEl = document.querySelector('button[data-bs-toggle="tab"]');
    if (tabEl) {
        tabEl.addEventListener('shown.bs.tab', function (event) {
            // Guardar la pestaña activa en localStorage
            localStorage.setItem('activeTab', event.target.getAttribute('data-bs-target'));
        });
    }

    // Recuperar pestaña activa
    const activeTab = localStorage.getItem('activeTab');
    if (activeTab) {
        const tab = document.querySelector(`[data-bs-target="${activeTab}"]`);
        if (tab) {
            new bootstrap.Tab(tab).show();
        }
    }
});
</script>

<style>
.chart-pie, .chart-area {
    position: relative;
    height: 300px;
}

.nav-pills .nav-link {
    border-radius: 0.375rem;
    margin-right: 0.5rem;
}

.nav-pills .nav-link.active {
    background-color: #4e73df;
    border-color: #4e73df;
}

.card-header {
    background-color: #f8f9fc;
    border-bottom: 1px solid #e3e6f0;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #6e707e;
}
</style>
@endpush