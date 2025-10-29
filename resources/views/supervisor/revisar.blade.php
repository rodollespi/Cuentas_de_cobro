@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-3">Revisión - Cuenta de Cobro #{{ $cuenta->id }}</h2>

    {{-- Info del contratista / metadata --}}
    <div class="row mb-3">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                    <h5>Datos del Contratista</h5>
                    <p><strong>Nombre:</strong> {{ $cuenta->user->name ?? 'N/A' }}</p>
                    <p><strong>Documento:</strong> {{ $cuenta->numero_documento ?? 'N/A' }}</p>
                    <p><strong>Teléfono:</strong> {{ $cuenta->telefono_beneficiario ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body">
                    <h5>Detalle de la Cuenta</h5>
                    <p><strong>Concepto:</strong> {{ $cuenta->concepto }}</p>
                    <p><strong>Periodo:</strong> {{ $cuenta->periodo }}</p>
                    <p><strong>Fecha emisión:</strong> {{ optional($cuenta->fecha_emision)->format('d/m/Y') }}</p>
                    <hr>
                    <h6>Ítems</h6>
                    @if(is_array($cuenta->detalle_items) && count($cuenta->detalle_items))
                        <ul>
                        @foreach($cuenta->detalle_items as $item)
                            <li>
                                {{ $item['descripcion'] ?? $item }} -
                                Cant: {{ $item['cantidad'] ?? '-' }} -
                                Valor: {{ $item['valor'] ?? '-' }}
                            </li>
                        @endforeach
                        </ul>
                    @else
                        <p class="text-muted">No hay detalles de items.</p>
                    @endif

                    <hr>
                    <p><strong>Subtotal:</strong> {{ number_format($cuenta->subtotal,2) }}</p>
                    <p><strong>IVA:</strong> {{ number_format($cuenta->iva,2) }}</p>
                    <p><strong>Total:</strong> {{ number_format($cuenta->total,2) }}</p>
                </div>
            </div>

            {{-- Soportes (archivos) --}}
            <div class="card mb-3">
                <div class="card-body">
                    <h5>Soportes</h5>
                    @if(!empty($cuenta->soporte_path))
                        <p><a href="{{ route('cuentas-cobro.descargar', [$cuenta->id, 'soporte']) }}" target="_blank">Descargar soporte</a></p>
                    @else
                        <p class="text-muted">No hay archivos adjuntos.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Panel derecho: acciones (Aprobar / Rechazar) --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5>Acciones</h5>
                    <p><strong>Estado actual:</strong> 
                        <span class="badge 
                            @if($cuenta->estado == 'pendiente') bg-warning
                            @elseif($cuenta->estado == 'aprobada') bg-success
                            @else bg-danger
                            @endif">{{ ucfirst($cuenta->estado) }}
                        </span>
                    </p>
                    <p><strong>Supervisor asignado:</strong> {{ $cuenta->supervisor->name ?? 'Sin asignar' }}</p>
                    <p><strong>Última revisión:</strong> {{ optional($cuenta->fecha_revision)->format('d/m/Y H:i') ?? 'No revisada' }}</p>

                    {{-- Mostrar observaciones si existen --}}
                    @if(!empty($cuenta->observaciones))
                        <div class="mb-3">
                            <label class="form-label"><strong>Observaciones del Supervisor:</strong></label>
                            <div class="border rounded p-2 bg-light text-dark">
                                {{ $cuenta->observaciones }}
                            </div>
                        </div>
                    @endif

                    {{-- Mostrar botones solo si NO está en modo lectura --}}
                    @if(empty($soloLectura))
                        @if($cuenta->estado === 'pendiente' || $cuenta->estado === 'rechazada')
                            <form action="{{ route('supervisor.aprobar', $cuenta->id) }}" method="POST" class="mb-2">
                                @csrf
                                <button type="submit" class="btn btn-success w-100">Aprobar</button>
                            </form>

                            <form action="{{ route('supervisor.rechazar', $cuenta->id) }}" method="POST">
                                @csrf
                                <div class="mb-2">
                                    <label for="observaciones" class="form-label">Observaciones (para el contratista)</label>
                                    <textarea name="observaciones" id="observaciones" class="form-control" rows="4" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-danger w-100">Rechazar</button>
                            </form>
                        @else
                            <div class="alert alert-info">No se pueden realizar acciones sobre esta cuenta.</div>
                        @endif
                    @else
                        {{-- Modo solo lectura --}}
                        <div class="alert alert-secondary">
                            Vista de solo lectura — no se pueden realizar acciones sobre esta cuenta.
                        </div>
                    @endif

                    <a href="{{ route('supervisor.dashboard') }}" class="btn btn-link mt-3">Volver al listado</a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
