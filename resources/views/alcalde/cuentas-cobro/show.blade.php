<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta de Cobro</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
<style>
<style>
    .gradient-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .status-badge {
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 700;
        font-size: 0.875rem;
        letter-spacing: 0.05em;
    }
    
    .info-card {
        border-radius: 1rem;
        transition: transform 0.2s, box-shadow 0.2s;
        border: none;
    }
    
    .info-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15) !important;
    }
    
    .info-card.blue {
        background: linear-gradient(135deg, #e3f2fd 0%, #ffffff 100%);
        border-left: 4px solid #2196F3;
    }
    
    .info-card.green {
        background: linear-gradient(135deg, #e8f5e9 0%, #ffffff 100%);
        border-left: 4px solid #4CAF50;
    }
    
    .info-card.purple {
        background: linear-gradient(135deg, #f3e5f5 0%, #ffffff 100%);
        border-left: 4px solid #9C27B0;
    }
    
    .info-card.yellow {
        background: linear-gradient(135deg, #fffde7 0%, #ffffff 100%);
        border-left: 4px solid #FFC107;
    }
    
    .info-card.indigo {
        background: linear-gradient(135deg, #e8eaf6 0%, #ffffff 100%);
        border-left: 4px solid #3F51B5;
    }
    
    .info-label {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        color: #6c757d;
        margin-bottom: 0.25rem;
    }
    
    .info-value {
        font-size: 0.875rem;
        color: #212529;
        font-weight: 500;
    }
    
    .section-icon {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
    }
    
    .action-card {
        border-radius: 1rem;
        transition: all 0.3s;
    }
    
    .action-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 1rem 2rem rgba(0,0,0,0.15) !important;
    }
    
    .action-card.approve {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        border: 2px solid #28a745;
    }
    
    .action-card.reject {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        border: 2px solid #dc3545;
    }
    
    .status-final-card {
        border-radius: 1rem;
        padding: 2rem;
        text-align: center;
    }
    
    .table-items {
        border-radius: 0.5rem;
        overflow: hidden;
    }
    
    .table-items thead {
        background-color: #f8f9fa;
    }
    
    .table-items tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    .revision-card {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        border-left: 4px solid #2196F3;
        border-radius: 0.5rem;
    }
    
    .user-circle {
        width: 3rem;
        height: 3rem;
        border-radius: 50%;
        background-color: #2196F3;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
</head>
<body>
<div class="container-fluid px-4 py-4">
    <!-- Navegación -->
    <div class="mb-4">
        <a href="{{ route('alcalde.cuentas-cobro.index') }}" class="btn btn-link text-decoration-none">
            <i class="fas fa-arrow-left me-2"></i>
            Volver a la lista
        </a>
    </div>

    <div class="card shadow-lg border-0">
        <!-- Encabezado con gradiente -->
        <div class="gradient-header text-black px-4 py-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h1 class="h2 fw-bold mb-2">Cuenta de Cobro #{{ $cuentaCobro->id }}</h1>
                    <p class="mb-0 opacity-75">
                        <i class="fas fa-calendar-alt me-2"></i>
                        Período: {{ $cuentaCobro->periodo }}
                    </p>
                </div>
                <div class="mt-3 mt-md-0">
                    <span class="status-badge
                        @if($cuentaCobro->estado == 'aprobado') bg-success
                        @elseif($cuentaCobro->estado == 'rechazado') bg-danger
                        @elseif($cuentaCobro->estado == 'finalizado') bg-primary
                        @else bg-warning text-dark
                        @endif">
                        {{ strtoupper($cuentaCobro->estado) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="card-body p-4">
            <!-- Grid de Información Principal -->
            <div class="row g-4 mb-4">
                <!-- Información del Contratista -->
                <div class="col-md-4">
                    <div class="info-card blue shadow-sm p-4 h-100">
                        <div class="d-flex align-items-center mb-3">
                            <div class="section-icon bg-primary me-2">
                                <i class="fas fa-user"></i>
                            </div>
                            <h5 class="mb-0 fw-bold">Información del Contratista</h5>
                        </div>
                        <div class="mb-3">
                            <div class="info-label">Nombre</div>
                            <div class="info-value">{{ $cuentaCobro->nombre_beneficiario }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="info-label">{{ $cuentaCobro->tipo_documento }}</div>
                            <div class="info-value">{{ $cuentaCobro->numero_documento }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="info-label">Teléfono</div>
                            <div class="info-value">{{ $cuentaCobro->telefono_beneficiario }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="info-label">Dirección</div>
                            <div class="info-value">{{ $cuentaCobro->direccion_beneficiario }}</div>
                        </div>
                        <div>
                            <div class="info-label">Usuario</div>
                            <div class="info-value">{{ $cuentaCobro->user->name }}</div>
                        </div>
                    </div>
                </div>

                <!-- Detalles Financieros -->
                <div class="col-md-4">
                    <div class="info-card green shadow-sm p-4 h-100">
                        <div class="d-flex align-items-center mb-3">
                            <div class="section-icon bg-success me-2">
                                <i class="fas fa-calculator"></i>
                            </div>
                            <h5 class="mb-0 fw-bold">Detalles Financieros</h5>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="info-label mb-0">Fecha de emisión</span>
                                <span class="info-value">{{ $cuentaCobro->fecha_emision->format('d/m/Y') }}</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="info-label mb-0">Subtotal</span>
                                <span class="info-value">${{ number_format($cuentaCobro->subtotal, 2) }}</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="info-label mb-0">IVA</span>
                                <span class="info-value">${{ number_format($cuentaCobro->iva, 2) }}</span>
                            </div>
                        </div>
                        <hr class="border-success border-2">
                        <div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-dark">Total</span>
                                <span class="h4 fw-bold text-success mb-0">${{ number_format($cuentaCobro->total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información de la Alcaldía -->
                <div class="col-md-4">
                    <div class="info-card purple shadow-sm p-4 h-100">
                        <div class="d-flex align-items-center mb-3">
                            <div class="section-icon bg-purple me-2" style="background-color: #9C27B0;">
                                <i class="fas fa-building"></i>
                            </div>
                            <h5 class="mb-0 fw-bold">Información de la Alcaldía</h5>
                        </div>
                        <div class="mb-3">
                            <div class="info-label">Nombre</div>
                            <div class="info-value">{{ $cuentaCobro->nombre_alcaldia }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="info-label">NIT</div>
                            <div class="info-value">{{ $cuentaCobro->nit_alcaldia }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="info-label">Dirección</div>
                            <div class="info-value">{{ $cuentaCobro->direccion_alcaldia }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="info-label">Ciudad</div>
                            <div class="info-value">{{ $cuentaCobro->ciudad_alcaldia }}</div>
                        </div>
                        <div>
                            <div class="info-label">Teléfono</div>
                            <div class="info-value">{{ $cuentaCobro->telefono_alcaldia }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grid inferior 2 columnas -->
            <div class="row g-4 mb-4">
                <!-- Concepto -->
                <div class="col-md-6">
                    <div class="info-card yellow shadow-sm p-4 h-100">
                        <div class="d-flex align-items-center mb-3">
                            <div class="section-icon me-2" style="background-color: #FFC107;">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <h5 class="mb-0 fw-bold">Concepto</h5>
                        </div>
                        <p class="mb-0 text-dark">{{ $cuentaCobro->concepto }}</p>
                    </div>
                </div>

                <!-- Información Bancaria -->
                <div class="col-md-6">
                    <div class="info-card indigo shadow-sm p-4 h-100">
                        <div class="d-flex align-items-center mb-3">
                            <div class="section-icon me-2" style="background-color: #3F51B5;">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <h5 class="mb-0 fw-bold">Información Bancaria</h5>
                        </div>
                        <div class="mb-3">
                            <div class="info-label">Banco</div>
                            <div class="info-value">{{ $cuentaCobro->banco }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="info-label">Tipo de cuenta</div>
                            <div class="info-value">{{ $cuentaCobro->tipo_cuenta }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="info-label">Número de cuenta</div>
                            <div class="info-value">{{ $cuentaCobro->numero_cuenta }}</div>
                        </div>
                        <div>
                            <div class="info-label">Titular</div>
                            <div class="info-value">{{ $cuentaCobro->titular_cuenta }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detalle de Items -->
            @php
                $detalleItems = $cuentaCobro->detalle_items;
                if (is_string($detalleItems)) {
                    $decoded = json_decode($detalleItems, true);
                    $detalleItems = is_array($decoded) ? $decoded : [];
                }
                if (!is_array($detalleItems) && !($detalleItems instanceof \Illuminate\Support\Collection)) {
                    $detalleItems = [];
                }
            @endphp

            @if(!empty($detalleItems))
                <div class="mb-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-list me-2 text-primary"></i>
                        Detalle de Items
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-items shadow-sm">
                            <thead>
                                <tr>
                                    <th class="fw-bold">Descripción</th>
                                    <th class="fw-bold text-center">Cantidad</th>
                                    <th class="fw-bold text-end">Valor Unitario</th>
                                    <th class="fw-bold text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($detalleItems as $item)
                                    <tr>
                                        <td>{{ $item['descripcion'] ?? 'N/A' }}</td>
                                        <td class="text-center">{{ $item['cantidad'] ?? 'N/A' }}</td>
                                        <td class="text-end">${{ number_format($item['valor_unitario'] ?? 0, 2) }}</td>
                                        <td class="text-end fw-bold">${{ number_format($item['valor_total'] ?? 0, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- Historial de Revisión -->
            @if($cuentaCobro->supervisor)
                <div class="mb-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-check-circle me-2 text-primary"></i>
                        Historial de Revisión
                    </h5>
                    <div class="revision-card p-4">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="user-circle">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                            </div>
                            <div class="ms-3 flex-grow-1">
                                <p class="fw-bold mb-1">{{ $cuentaCobro->supervisor->name }}</p>
                                <p class="text-muted small mb-2">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $cuentaCobro->fecha_revision ? \Carbon\Carbon::parse($cuentaCobro->fecha_revision)->format('d/m/Y H:i') : 'N/A' }}
                                </p>
                                @if($cuentaCobro->observaciones)
                                    <div class="bg-white rounded p-3 border">
                                        <p class="info-label mb-1">Observaciones</p>
                                        <p class="mb-0">{{ $cuentaCobro->observaciones }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Acciones según estado -->
            @if($cuentaCobro->estado == 'pendiente')
                <div class="border-top pt-4 mt-4">
                    <h4 class="fw-bold text-center mb-4">Acciones Disponibles</h4>
                    <div class="row g-4 justify-content-center">
                        <!-- Aprobar -->
                        <div class="col-md-5">
                            <div class="action-card approve shadow p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="section-icon bg-success me-3">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <h5 class="fw-bold text-success mb-0">Aprobar Cuenta</h5>
                                </div>
                                <form method="POST" action="{{ route('alcalde.cuentas-cobro.aprobar', $cuentaCobro->id) }}">
                                    @csrf
                                    <div class="mb-3">
                                        <textarea name="observaciones" rows="3" class="form-control" placeholder="Observaciones (opcional)"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success w-100 fw-bold">
                                        <i class="fas fa-check-circle me-2"></i>
                                        Aprobar Cuenta de Cobro
                                    </button>
                                </form>
                            </div>
                        </div>
                        <!-- Rechazar -->
                        <div class="col-md-5">
                            <div class="action-card reject shadow p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="section-icon bg-danger me-3">
                                        <i class="fas fa-times"></i>
                                    </div>
                                    <h5 class="fw-bold text-danger mb-0">Rechazar Cuenta</h5>
                                </div>
                                <form method="POST" action="{{ route('alcalde.cuentas-cobro.rechazar', $cuentaCobro->id) }}">
                                    @csrf
                                    <div class="mb-3">
                                        <textarea name="observaciones" rows="3" class="form-control" placeholder="Motivo del rechazo (requerido)" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-danger w-100 fw-bold">
                                        <i class="fas fa-times-circle me-2"></i>
                                        Rechazar Cuenta de Cobro
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($cuentaCobro->estado == 'aprobado')
                <div class="border-top pt-4 mt-4">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="status-final-card shadow" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <i class="fas fa-check-circle text-white" style="font-size: 4rem;"></i>
                                <h3 class="fw-bold text-white mt-3 mb-3">Cuenta Aprobada</h3>
                                <p class="text-white mb-4">Confirma el pago para finalizar esta cuenta de cobro</p>
                                <form method="POST" action="{{ route('alcalde.cuentas-cobro.finalizar', $cuentaCobro->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-light btn-lg fw-bold px-5">
                                        <i class="fas fa-money-check-alt me-2"></i>
                                        Marcar como Finalizada/Pagada
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($cuentaCobro->estado == 'finalizado')
                <div class="border-top pt-4 mt-4">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="status-final-card bg-primary text-white shadow">
                                <i class="fas fa-check-double" style="font-size: 4rem;"></i>
                                <h3 class="fw-bold mt-3 mb-2">Cuenta Finalizada</h3>
                                <p class="mb-0">Esta cuenta de cobro ya fue procesada y pagada</p>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($cuentaCobro->estado == 'rechazado')
                <div class="border-top pt-4 mt-4">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="status-final-card bg-danger text-white shadow">
                                <i class="fas fa-times-circle" style="font-size: 4rem;"></i>
                                <h3 class="fw-bold mt-3 mb-2">Cuenta Rechazada</h3>
                                <p class="mb-0">Esta cuenta de cobro ha sido rechazada</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>