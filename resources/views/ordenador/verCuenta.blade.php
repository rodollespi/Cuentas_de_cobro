@extends('layouts.app')

@section('title', 'Detalles de la Cuenta')

@section('content')
<div class="container">
    <a href="{{ route('ordenador.dashboard') }}" class="btn btn-outline-secondary mb-3">
        <i class="fas fa-arrow-left"></i> Volver
    </a>

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Cuenta de Cobro #{{ $cuenta->id }}</h5>
        </div>
        <div class="card-body">
            <p><strong>Beneficiario:</strong> {{ $cuenta->nombre_beneficiario }}</p>
            <p><strong>Concepto:</strong> {{ $cuenta->concepto }}</p>
            <p><strong>Periodo:</strong> {{ $cuenta->periodo }}</p>
            <p><strong>Total:</strong> ${{ number_format($cuenta->total, 0, ',', '.') }}</p>
            <p><strong>Estado actual:</strong>
                <span class="badge bg-info">{{ ucfirst($cuenta->estado) }}</span>
            </p>
        </div>
        <div class="card-footer d-flex justify-content-end gap-2">
            <form action="{{ route('ordenador.autorizar', $cuenta->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check"></i> Autorizar
                </button>
            </form>

            <form action="{{ route('ordenador.rechazar', $cuenta->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-times"></i> Rechazar
                </button>
            </form>
        </div>
    </div>
</div>
@endsection



