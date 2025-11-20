@extends('layouts.app')

@section('title', 'Detalles de Cuenta de Cobro - CuentasCobro')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-file-invoice-dollar me-2"></i>
                        Cuenta de Cobro #{{ $cuentaCobro->id }}
                    </h1>
                    <p class="text-muted mb-0">
                        <span class="badge {{ $cuentaCobro->estado == 'aprobado' ? 'bg-success' : ($cuentaCobro->estado == 'rechazado' ? 'bg-danger' : 'bg-warning text-dark') }}">
                            {{ ucfirst($cuentaCobro->estado ?? 'pendiente') }}
                        </span>
                        · Creado el {{ $cuentaCobro->created_at->format('d/m/Y') }}
                    </p>
                </div>
                <div class="btn-group">
                    <a href="{{ route('cuentas-cobro.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Volver al Listado
                    </a>
                    <a href="{{ route('cuentas-cobro.edit', $cuentaCobro->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>
                        Editar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Información Principal -->
        <div class="col-lg-8">
            <!-- Datos de la Alcaldía -->
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-building me-2"></i>
                        Información de la Alcaldía
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nombre:</strong><br>{{ $cuentaCobro->nombre_alcaldia }}</p>
                            <p><strong>NIT:</strong><br>{{ $cuentaCobro->nit_alcaldia }}</p>
                            <p><strong>Ciudad:</strong><br>{{ $cuentaCobro->ciudad_alcaldia }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Dirección:</strong><br>{{ $cuentaCobro->direccion_alcaldia }}</p>
                            <p><strong>Teléfono:</strong><br>{{ $cuentaCobro->telefono_alcaldia }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información del Beneficiario -->
            <div class="card shadow mb-4">
                <div class="card-header bg-success text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-user me-2"></i>
                        Información del Beneficiario
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nombre:</strong><br>{{ $cuentaCobro->nombre_beneficiario }}</p>
                            <p><strong>Tipo de Documento:</strong><br>{{ $cuentaCobro->tipo_documento }}</p>
                            <p><strong>Número de Documento:</strong><br>{{ $cuentaCobro->numero_documento }}</p>
                        </div>
                        <div class="col-md-6">
                            @if($cuentaCobro->telefono_beneficiario)
                            <p><strong>Teléfono:</strong><br>{{ $cuentaCobro->telefono_beneficiario }}</p>
                            @endif
                            @if($cuentaCobro->direccion_beneficiario)
                            <p><strong>Dirección:</strong><br>{{ $cuentaCobro->direccion_beneficiario }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detalles de la Cuenta -->
            <div class="card shadow mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-file-alt me-2"></i>
                        Detalles de la Cuenta de Cobro
                    </h6>
                </div>
                <div class="card-body">
                    <p><strong>Fecha de Emisión:</strong><br>
                       {{ \Carbon\Carbon::parse($cuentaCobro->fecha_emision)->format('d/m/Y') }}
                    </p>
                    
                    <p><strong>Concepto:</strong><br>{{ $cuentaCobro->concepto }}</p>
                    
                    <p><strong>Período:</strong><br>{{ $cuentaCobro->periodo }}</p>

                    <!-- Items Detallados -->
                    @php
                        // Aceptar tanto array como JSON string (el modelo ya puede castear a array)
                        if (is_array($cuentaCobro->detalle_items)) {
                            $items = $cuentaCobro->detalle_items;
                        } elseif (is_string($cuentaCobro->detalle_items)) {
                            $items = json_decode($cuentaCobro->detalle_items, true) ?? [];
                        } else {
                            $items = [];
                        }
                    @endphp
                    @if(!empty($items) && count($items) > 0)
                    <div class="mt-4">
                        <h6 class="border-bottom pb-2">Items Detallados</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>Descripción</th>
                                        <th>Cantidad</th>
                                        <th>Valor Unitario</th>
                                        <th>Valor Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                    <tr>
                                        <td>{{ $item['descripcion'] ?? '' }}</td>
                                        <td>{{ $item['cantidad'] ?? 0 }}</td>
                                        <td>${{ number_format($item['valor_unitario'] ?? 0, 2, ',', '.') }}</td>
                                        <td>${{ number_format($item['valor_total'] ?? 0, 2, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar con Resumen -->
        <div class="col-lg-4">
            <!-- Resumen de Valores -->
            <div class="card shadow mb-4">
                <div class="card-header bg-warning text-dark">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-calculator me-2"></i>
                        Resumen de Valores
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <span class="fw-bold">Subtotal:</span>
                        <span class="h5 mb-0">${{ number_format($cuentaCobro->subtotal, 2, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <span class="fw-bold">IVA:</span>
                        <span class="h5 mb-0">${{ number_format($cuentaCobro->iva, 2, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="h6 fw-bold">TOTAL:</span>
                        <span class="h4 text-success fw-bold">${{ number_format($cuentaCobro->total, 2, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Información Bancaria -->
            <div class="card shadow mb-4">
                <div class="card-header bg-secondary text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-university me-2"></i>
                        Información Bancaria
                    </h6>
                </div>
                <div class="card-body">
                    <p><strong>Banco:</strong><br>{{ $cuentaCobro->banco }}</p>
                    <p><strong>Tipo de Cuenta:</strong><br>{{ $cuentaCobro->tipo_cuenta }}</p>
                    <p><strong>Número de Cuenta:</strong><br>{{ $cuentaCobro->numero_cuenta }}</p>
                    <p><strong>Titular:</strong><br>{{ $cuentaCobro->titular_cuenta }}</p>
                </div>
            </div>

            <!-- Acciones Rápidas -->
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-bolt me-2"></i>
                        Acciones Rápidas
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('cuentas-cobro.edit', $cuentaCobro->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Editar Cuenta
                        </a>
                        <form action="{{ route('cuentas-cobro.destroy', $cuentaCobro->id) }}" method="POST" class="d-grid">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" 
                                    onclick="return confirm('¿Estás seguro de que quieres eliminar esta cuenta de cobro?')">
                                <i class="fas fa-trash me-2"></i>Eliminar
                            </button>
                        </form>
                        <a href="{{ route('cuentas-cobro.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-list me-2"></i>Ver Todas las Cuentas
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Observaciones -->
    @if($cuentaCobro->observaciones)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow border-warning">
                <div class="card-header bg-warning text-dark">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        Observaciones
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $cuentaCobro->observaciones }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@push('styles')
<style>
    .card {
        border: none;
        border-radius: 0.5rem;
    }
    .card-header {
        border-radius: 0.5rem 0.5rem 0 0 !important;
    }
    p {
        margin-bottom: 0.8rem;
    }
</style>
@endpush
@endsection