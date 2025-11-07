@extends('layouts.app')

@section('title', 'Dashboard - CuentasCobro')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Header del Dashboard -->
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-tachometer-alt me-2"></i>
                        Dashboard
                    </h1>
                    <p class="text-muted mb-0">
                        Bienvenido, <strong>{{ $user->name }}</strong>
                        @if($userRole)
                        - <span class="badge bg-primary">{{ ucfirst(str_replace('_', ' ', $userRole)) }}</span>
                        @endif
                    </p>
                </div>
                <div class="text-end">
                    <small class="text-muted">
                        <i class="fas fa-calendar me-1"></i>
                        {{ now()->format('d/m/Y H:i') }}
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Incluye el dashboard específico para Alcalde -->
    @include('dashboard._alcalde')

    <!-- Incluye el dashboard específico para Supervisor -->
    @include('dashboard._supervisor')

    <!-- Incluye el dashboard específico para Contratista -->
    @include('dashboard._contratista')

    @if(!$userRole)
    <!-- Usuario sin rol asignado -->
    <div class="row">
        <div class="col-12">
            <div class="alert alert-warning" role="alert">
                <h4 class="alert-heading">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Sin rol asignado
                </h4>
                <p>No tienes un rol asignado en el sistema. Contacta al administrador para que te asigne un rol.</p>
                <hr>
                <p class="mb-0">Mientras tanto, puedes explorar las funcionalidades básicas del sistema.</p>
            </div>
        </div>
    </div>
    @endif

    @if(in_array($userRole, ['ordenador_gasto', 'tesoreria', 'contratacion']))
    <!-- Dashboard para otros roles -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body text-center py-5">
                    @switch($userRole)
                        @case('ordenador_gasto')
                            <i class="fas fa-money-check-alt fa-4x text-info mb-3"></i>
                            <h4>Panel de Ordenador del Gasto</h4>
                            <p class="text-muted">Aquí podrás autorizar pagos y gestionar presupuestos.</p>
                            @break
                        @case('tesoreria')
                            <i class="fas fa-coins fa-4x text-success mb-3"></i>
                            <h4>Panel de Tesorería</h4>
                            <p class="text-muted">Aquí podrás procesar pagos y generar reportes financieros.</p>
                            @break
                        @case('contratacion')
                            <i class="fas fa-handshake fa-4x text-primary mb-3"></i>
                            <h4>Panel de Contratación</h4>
                            <p class="text-muted">Aquí podrás gestionar contratos y contratistas.</p>
                            @break
                    @endswitch
                    <p class="text-muted">Esta funcionalidad se implementará próximamente.</p>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@push('styles')
<style>
    .border-left-primary {
        border-left: 0.25rem solid #4e73df !important;
    }
    .border-left-success {
        border-left: 0.25rem solid #1cc88a !important;
    }
    .border-left-info {
        border-left: 0.25rem solid #36b9cc !important;
    }
    .border-left-warning {
        border-left: 0.25rem solid #f6c23e !important;
    }
</style>
@endpush
@endsection