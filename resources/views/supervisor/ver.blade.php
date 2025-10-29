@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3 class="mb-4 text-center">Detalles de la Cuenta de Cobro</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <p><strong>Beneficiario:</strong> {{ $cuenta->nombre_beneficiario }}</p>
            <p><strong>Concepto:</strong> {{ $cuenta->concepto }}</p>
            <p><strong>Valor:</strong> ${{ number_format($cuenta->valor, 0, ',', '.') }}</p>
            <p><strong>Fecha de Emisión:</strong> {{ $cuenta->fecha_emision->format('d/m/Y') }}</p>
            <p><strong>Estado:</strong> 
                <span class="badge 
                    @if($cuenta->estado == 'pendiente') bg-warning
                    @elseif($cuenta->estado == 'aprobada') bg-success
                    @else bg-danger
                    @endif">
                    {{ ucfirst($cuenta->estado) }}
                </span>
            </p>

            @if($cuenta->observacion)
                <p><strong>Observaciones del Supervisor:</strong></p>
                <div class="border rounded p-2 bg-light">{{ $cuenta->observacion }}</div>
            @endif

            @if($cuenta->usuario)
                <p class="mt-3"><strong>Revisado por:</strong> {{ $cuenta->usuario->name }}</p>
            @endif
        </div>
    </div>

    <div class="mt-3 text-center">
        <a href="{{ route('supervisor.dashboard') }}" class="btn btn-secondary">Volver al Panel</a>
    </div>
</div>
@endsection
