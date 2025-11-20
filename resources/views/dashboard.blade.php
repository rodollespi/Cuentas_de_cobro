@extends('layouts.app')

@section('title', 'Dashboard - Sistema de Cuentas de Cobro Municipal')

@section('content')
<div class="container-fluid bg-gradient-primary py-4">
    <div class="row">
        <!-- Header del Dashboard - Reorganizado en barra superior -->
        <div class="col-12">
            <div class="card border-0 shadow-lg rounded-pill mb-4" style="background: linear-gradient(135deg, #1e4a82 0%, #2c6bb3 100%);">
                <div class="card-body d-flex justify-content-between align-items-center py-3">
                    <div>
                        <h1 class="h4 mb-1 text-white">
                            <i class="fas fa-chart-line me-2"></i>
                            Panel de Control Municipal
                        </h1>
                        <p class="text-white-50 mb-0 small">
                            Hola, <strong>{{ $user->name }}</strong>
                            @if($userRole)
                                - <span class="badge bg-warning text-dark">{{ ucfirst(str_replace('_', ' ', $userRole)) }}</span>
                            @endif
                        </p>
                    </div>
                    <div class="text-end">
                        <small class="text-white-75">
                            <i class="fas fa-clock me-1"></i>
                            {{ now()->format('d/m/Y H:i') }}
                        </small>
                    </div>
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
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="alert alert-danger border-0 shadow-sm rounded-3" role="alert" style="background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%); color: #fff;">
                <h4 class="alert-heading">
                    <i class="fas fa-user-times me-2"></i>
                    Rol No Asignado
                </h4>
                <p>No tienes un rol asignado. Contacta al admin para asignarte uno.</p>
                <hr class="bg-white opacity-50">
                <p class="mb-0">Explora las funciones básicas mientras tanto.</p>
            </div>
        </div>
    </div>
    @endif

    {{-- OTROS ROLES: ordenador_gasto, tesoreria, contratacion --}}
    @if(in_array($userRole, ['ordenador_gasto', 'tesoreria', 'contratacion']))
    <div class="row g-4">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-lg border-0 rounded-4 h-100" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); transition: transform 0.3s;">
                <div class="card-body text-center py-5">
                    @switch($userRole)
                        @case('ordenador_gasto')
                            <i class="fas fa-wallet fa-4x text-info mb-3"></i>
                            <h5 class="text-dark">Panel Ordenador del Gasto</h5>
                            <p class="text-muted small">Autoriza pagos y gestiona presupuestos.</p>
                            @break

                        @case('tesoreria')
                            <a href="{{ route('tesoreria.dashboard') }}" class="text-decoration-none">
                                <i class="fas fa-piggy-bank fa-4x text-success mb-3"></i>
                                <h5 class="text-dark">Panel Tesorería</h5>
                                <p class="text-muted small">Procesa pagos y reportes financieros.</p>
                            </a>
                            @break

                        @case('contratacion')
                            <i class="fas fa-file-contract fa-4x text-primary mb-3"></i>
                            <h5 class="text-dark">Panel Contratación</h5>
                            <p class="text-muted small">Gestiona contratos y verifica docs.</p>
                            <a href="{{ route('contratacion.index') }}" class="btn btn-outline-primary btn-sm mt-3 rounded-pill">
                                <i class="fas fa-search me-1"></i> Verificar Docs
                            </a>
                            @break

                        @default
                            <i class="fas fa-cogs fa-4x text-secondary mb-3"></i>
                            <h5 class="text-dark">Panel {{ ucfirst(str_replace('_', ' ', $userRole)) }}</h5>
                            <p class="text-muted small">Funcionalidades asignadas.</p>
                    @endswitch
                </div>
            </div>
        </div>
    </div>
    @endif

</div>

@push('styles')
<style>
    .bg-gradient-primary { background: linear-gradient(135deg, #1e4a82 0%, #2c6bb3 100%) !important; }
    .card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.2) !important; }
    .border-left-custom { border-left: 0.25rem solid #ff6b6b !important; }
    .text-white-50 { color: rgba(255,255,255,0.5) !important; }
    .text-white-75 { color: rgba(255,255,255,0.75) !important; }
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
</style>
@endpush

@endsection