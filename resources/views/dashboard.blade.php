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

    {{-- DASHBOARD ALCALDE --}}
    @if($userRole === 'alcalde')
        @include('dashboard._alcalde')
    @endif

    {{-- DASHBOARD SUPERVISOR --}}
    @if($userRole === 'supervisor')
        @include('dashboard._supervisor')
    @endif

    {{-- DASHBOARD CONTRATISTA --}}
    @if(strtolower($userRole) === 'contratista')
        @include('dashboard._contratista')
    @endif

    {{-- USUARIO SIN ROL --}}
    @if(!$userRole)
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

    {{-- OTROS ROLES: ordenador_gasto, tesoreria, contratacion --}}
    @if(in_array($userRole, ['ordenador_gasto', 'tesoreria', 'contratacion']))
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
                            <a href="{{ route('tesoreria.dashboard') }}" class="text-decoration-none">
                                <i class="fas fa-coins fa-4x text-success mb-3"></i>
                                <h4>Panel de Tesorería</h4>
                                <p class="text-muted">Procesar pagos y generar reportes financieros.</p>
                            </a>
                            @break

                        @case('contratacion')
                            <i class="fas fa-handshake fa-4x text-primary mb-3"></i>
                            <h4>Panel de Contratación</h4>
                            <p class="text-muted">Gestionar contratos y verificar documentos.</p>

                            <a href="{{ route('contratacion.index') }}" class="btn btn-outline-primary mt-3">
                                <i class="fas fa-file-alt me-2"></i> Verificar Documentos
                            </a>
                            @break

                        @default
                            <i class="fas fa-user-cog fa-4x text-secondary mb-3"></i>
                            <h4>Panel de {{ ucfirst(str_replace('_', ' ', $userRole)) }}</h4>
                            <p class="text-muted">Gestión de funcionalidades asignadas.</p>

                    @endswitch

                </div>
            </div>
        </div>
    </div>
    @endif

</div>

@push('styles')
<style>
    .border-left-primary { border-left: 0.25rem solid #4e73df !important; }
    .border-left-success { border-left: 0.25rem solid #1cc88a !important; }
    .border-left-info    { border-left: 0.25rem solid #36b9cc !important; }
    .border-left-warning { border-left: 0.25rem solid #f6c23e !important; }
</style>
@endpush

@endsection
