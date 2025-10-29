@extends('layouts.app')

@section('title', 'Cuentas de Cobro - Alcalde')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1 text-gray-800">
                        <i class="fas fa-file-invoice-dollar text-primary me-2"></i>
                        Cuentas de Cobro
                    </h1>
                    <p class="text-muted mb-0">Gestión y aprobación de cuentas de cobro</p>
                </div>
                <div>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Volver al Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <strong>¡Éxito!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Error:</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Estadísticas Rápidas -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stats-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted text-uppercase small mb-1">Total</div>
                            <div class="h4 mb-0 font-weight-bold text-primary">
                                {{ $cuentasCobro->total() }}
                            </div>
                        </div>
                        <div class="icon-circle bg-primary-light">
                            <i class="fas fa-file-invoice text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stats-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted text-uppercase small mb-1">Pendientes</div>
                            <div class="h4 mb-0 font-weight-bold text-warning">
                                {{ $cuentasCobro->where('estado', 'pendiente')->count() }}
                            </div>
                        </div>
                        <div class="icon-circle bg-warning-light">
                            <i class="fas fa-clock text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stats-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted text-uppercase small mb-1">Aprobadas</div>
                            <div class="h4 mb-0 font-weight-bold text-success">
                                {{ $cuentasCobro->where('estado', 'aprobado')->count() }}
                            </div>
                        </div>
                        <div class="icon-circle bg-success-light">
                            <i class="fas fa-check-circle text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stats-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted text-uppercase small mb-1">Rechazadas</div>
                            <div class="h4 mb-0 font-weight-bold text-danger">
                                {{ $cuentasCobro->where('estado', 'rechazado')->count() }}
                            </div>
                        </div>
                        <div class="icon-circle bg-danger-light">
                            <i class="fas fa-times-circle text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h6 class="mb-0 font-weight-bold text-primary">
                <i class="fas fa-filter me-2"></i>
                Filtros de Búsqueda
            </h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('alcalde.cuentas-cobro.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Estado</label>
                        <select name="estado" class="form-select">
                            <option value="">Todos los estados</option>
                            <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>
                                Pendiente
                            </option>
                            <option value="aprobado" {{ request('estado') == 'aprobado' ? 'selected' : '' }}>
                                Aprobado
                            </option>
                            <option value="rechazado" {{ request('estado') == 'rechazado' ? 'selected' : '' }}>
                                Rechazado
                            </option>
                            <option value="finalizado" {{ request('estado') == 'finalizado' ? 'selected' : '' }}>
                                Finalizado
                            </option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small text-muted">Fecha desde</label>
                        <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}" 
                               class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small text-muted">Fecha hasta</label>
                        <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}" 
                               class="form-control">
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-2"></i>
                            Buscar
                        </button>
                    </div>
                </div>

                @if(request()->hasAny(['estado', 'fecha_desde', 'fecha_hasta']))
                <div class="row mt-3">
                    <div class="col-12">
                        <a href="{{ route('alcalde.cuentas-cobro.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>
                            Limpiar filtros
                        </a>
                    </div>
                </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Tabla de Cuentas de Cobro -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-0 font-weight-bold text-primary">
                    <i class="fas fa-list me-2"></i>
                    Listado de Cuentas de Cobro
                </h6>
                <span class="badge bg-primary">
                    {{ $cuentasCobro->total() }} registros
                </span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 80px;">ID</th>
                            <th>Contratista</th>
                            <th>Período</th>
                            <th class="text-end">Valor</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center" style="width: 120px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cuentasCobro as $cuenta)
                            <tr>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark">#{{ $cuenta->id }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-2">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $cuenta->user->name }}</div>
                                            <small class="text-muted">{{ $cuenta->nombre_beneficiario }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <i class="fas fa-calendar-alt text-muted me-1"></i>
                                    {{ $cuenta->periodo }}
                                </td>
                                <td class="text-end">
                                    <span class="fw-bold text-success">
                                        ${{ number_format($cuenta->total, 2) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @php
                                        $estadoConfig = [
                                            'pendiente' => ['class' => 'warning', 'icon' => 'clock'],
                                            'aprobado' => ['class' => 'success', 'icon' => 'check-circle'],
                                            'rechazado' => ['class' => 'danger', 'icon' => 'times-circle'],
                                            'finalizado' => ['class' => 'primary', 'icon' => 'flag-checkered'],
                                        ];
                                        $config = $estadoConfig[$cuenta->estado] ?? ['class' => 'secondary', 'icon' => 'question'];
                                    @endphp
                                    <span class="badge bg-{{ $config['class'] }}">
                                        <i class="fas fa-{{ $config['icon'] }} me-1"></i>
                                        {{ ucfirst($cuenta->estado) }}
                                    </span>
                                </td>
                                <td class="text-center text-muted">
                                    <small>
                                        {{ $cuenta->fecha_emision->format('d/m/Y') }}
                                    </small>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('alcalde.cuentas-cobro.show', $cuenta->id) }}" 
                                       class="btn btn-sm btn-outline-primary"
                                       data-bs-toggle="tooltip" 
                                       title="Ver detalle">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                        <p class="mb-0">No se encontraron cuentas de cobro</p>
                                        @if(request()->hasAny(['estado', 'fecha_desde', 'fecha_hasta']))
                                            <small>Intenta cambiar los filtros de búsqueda</small>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($cuentasCobro->hasPages())
        <div class="card-footer bg-white border-0">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Mostrando {{ $cuentasCobro->firstItem() }} - {{ $cuentasCobro->lastItem() }} 
                    de {{ $cuentasCobro->total() }} registros
                </div>
                <div>
                    {{ $cuentasCobro->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

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

    .icon-circle {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .bg-primary-light {
        background-color: rgba(78, 115, 223, 0.1);
    }

    .bg-success-light {
        background-color: rgba(28, 200, 138, 0.1);
    }

    .bg-warning-light {
        background-color: rgba(246, 194, 62, 0.1);
    }

    .bg-danger-light {
        background-color: rgba(231, 74, 59, 0.1);
    }

    /* Avatar circle */
    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1rem;
    }

    /* Tabla */
    .table > tbody > tr {
        transition: background-color 0.2s;
    }

    .table > tbody > tr:hover {
        background-color: rgba(78, 115, 223, 0.05);
    }

    .table thead th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #6c757d;
        border-bottom: 2px solid #dee2e6;
    }

    /* Badges */
    .badge {
        padding: 0.5rem 0.75rem;
        font-weight: 500;
        font-size: 0.75rem;
    }

    /* Botones */
    .btn {
        transition: all 0.2s;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    /* Form controls */
    .form-control, .form-select {
        border: 1px solid #d1d3e2;
        border-radius: 0.35rem;
        padding: 0.5rem 0.75rem;
        font-size: 0.9rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }

    /* Card headers */
    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        background: white;
        border-bottom: 2px solid #f8f9fc;
    }

    /* Animaciones */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card {
        animation: fadeIn 0.3s ease-in-out;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .stats-card {
            margin-bottom: 1rem;
        }
        
        .table {
            font-size: 0.85rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Inicializar tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Auto-hide alerts después de 5 segundos
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
</script>
@endpush
@endsection