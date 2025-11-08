@extends('layouts.app')

@section('title', 'Panel del Ordenador del Gasto')

@section('content')
<div class="container py-5">

    <!-- Encabezado -->
    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary">
            <i class="fas fa-money-check-alt me-2"></i> Panel del Ordenador del Gasto
        </h2>
        <p class="text-muted mb-0">
            Aquí podrás revisar las cuentas de cobro que han sido aprobadas por Tesorería
            y dar la autorización final para el pago.
        </p>
    </div>

    <!-- Tarjeta de resumen -->
    <div class="row justify-content-center mb-4">
        <div class="col-md-6">
            <div class="card text-center shadow border-0 rounded-4">
                <div class="card-body py-4">
                    <h5 class="card-title text-secondary mb-3">
                        <i class="fas fa-clipboard-list fa-lg me-2"></i> Cuentas Pendientes
                    </h5>
                    <h2 class="fw-bold text-primary display-5 mb-2">0</h2>
                    <p class="text-muted mb-0">No hay cuentas de cobro pendientes por aprobar.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Mensaje visual amigable -->
    <div class="card shadow-sm border-0 rounded-4 mt-4">
        <div class="card-body text-center py-5">
            <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
            <h4 class="fw-semibold text-dark">Todo está al día</h4>
            <p class="text-muted mb-4">
                En este momento, no tienes cuentas de cobro esperando tu aprobación final.
                <br>
                Cuando Tesorería finalice una revisión, aparecerá aquí automáticamente.
            </p>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-primary px-4">
                <i class="fas fa-home me-2"></i> Volver al inicio
            </a>
        </div>
    </div>

</div>
@endsection







