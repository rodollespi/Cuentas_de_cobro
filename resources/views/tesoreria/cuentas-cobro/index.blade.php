@extends('layouts.app')

@section('title', 'Cuentas de Cobro - Tesorería')

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
    /* Mejoras visuales generales */
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-radius: 0 0 1rem 1rem;
    }

    .card-container {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    /* Estados mejorados */
    .status-badge {
        padding: 0.5rem 1rem;
        font-weight: 700;
        border-radius: 50px;
        color: white;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        display: inline-block;
        min-width: 120px;
        text-align: center;
    }
    
    .status-pendiente { 
        background: linear-gradient(135deg, #FACC15, #EAB308);
        color: #1F2937;
    }
    .status-aprobado { 
        background: linear-gradient(135deg, #10B981, #059669);
    }
    .status-aprobado_tesoreria { 
        background: linear-gradient(135deg, #059669, #047857);
        box-shadow: 0 2px 8px rgba(5, 150, 105, 0.3);
    }
    .status-rechazado_supervisor { 
        background: linear-gradient(135deg, #EF4444, #DC2626);
    }
    .status-rechazado_tesoreria { 
        background: linear-gradient(135deg, #DC2626, #B91C1C);
    }
    .status-finalizado { 
        background: linear-gradient(135deg, #3B82F6, #2563EB);
    }

    /* Tabla mejorada */
    .table-improved {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .table-improved thead {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    }
    
    .table-improved thead th {
        padding: 1.25rem 1.5rem;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0;
    }
    
    .table-improved tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .table-improved tbody tr:hover {
        background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    
    .table-improved tbody td {
        padding: 1.25rem 1.5rem;
        font-weight: 500;
        color: #475569;
        border-bottom: 1px solid #f8fafc;
    }

    /* Botones mejorados */
    .btn-improved {
        padding: 0.6rem 1.2rem;
        font-weight: 600;
        border-radius: 8px;
        font-size: 0.8rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .btn-improved:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .btn-view { 
        background: linear-gradient(135deg, #3B82F6, #2563eb);
        color: white;
    }
    .btn-view:hover { 
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
    }

    .btn-approve { 
        background: linear-gradient(135deg, #10B981, #059669);
        color: white;
    }
    .btn-approve:hover { 
        background: linear-gradient(135deg, #059669, #047857);
    }

    .btn-reject { 
        background: linear-gradient(135deg, #EF4444, #DC2626);
        color: white;
    }
    .btn-reject:hover { 
        background: linear-gradient(135deg, #DC2626, #B91C1C);
    }

    /* Badges mejorados */
    .badge-ready { 
        background: linear-gradient(135deg, #059669, #047857);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        box-shadow: 0 2px 8px rgba(5, 150, 105, 0.3);
    }

    .badge-finalized { 
        background: linear-gradient(135deg, #3B82F6, #2563EB);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
    }
    .bg-white {
    --bs-bg-opacity: 1;
    background-color: rgba(13, 110, 253, 0.25) !important;
}

    /* Alertas mejoradas */
    .alert-improved {
        padding: 1rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        border: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .alert-success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
        border-left: 4px solid #10B981;
    }

    .alert-error {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
        border-left: 4px solid #EF4444;
    }

    /* Estado vacío mejorado */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border-radius: 1rem;
        margin: 2rem 0;
    }

    .empty-state i {
        font-size: 4rem;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 1rem;
    }

    /* Paginación mejorada */
    .pagination-improved .page-link {
        border: none;
        border-radius: 8px;
        margin: 0 0.25rem;
        color: #475569;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .pagination-improved .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .pagination-improved .page-link:hover {
        background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
        color: #4f46e5;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .table-improved {
            font-size: 0.875rem;
        }
        
        .table-improved thead th,
        .table-improved tbody td {
            padding: 0.75rem 1rem;
        }
        
        .btn-improved {
            padding: 0.5rem 1rem;
            font-size: 0.75rem;
        }
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">
                    <i class="fas fa-file-invoice-dollar mr-3"></i>
                    Cuentas de Cobro - Tesorería
                </h1>
                <p class="text-blue-100 opacity-90">Gestiona y revisa las cuentas de cobro aprobadas por supervisores</p>
            </div>
            <div class="text-right">
                <div class="bg-white bg-opacity-20 px-4 py-2 rounded-lg">
                    <div class="text-sm text-blue-100">Total pendientes</div>
                    <div class="text-2xl font-bold text-white">{{ $cuentasCobro->total() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto px-4">
    {{-- Alertas --}}
    @if(session('success'))
        <div class="alert-improved alert-success">
            <i class="fas fa-check-circle mr-2"></i>
            <strong>Éxito!</strong> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-improved alert-error">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <strong>Error!</strong> {{ session('error') }}
        </div>
    @endif

    <div class="card-container">
        <div class="overflow-x-auto">
            <table class="table-improved">
                <thead>
                    <tr>
                        <th class="text-left">ID</th>
                        <th class="text-left">Beneficiario</th>
                        <th class="text-left">Alcaldía</th>
                        <th class="text-right">Total</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cuentasCobro as $cuenta)
                    <tr>
                        <td class="font-bold text-gray-900">#{{ $cuenta->id }}</td>
                        <td>
                            <div class="font-semibold text-gray-900">{{ $cuenta->nombre_beneficiario }}</div>
                            <div class="text-sm text-gray-500">{{ $cuenta->concepto }}</div>
                        </td>
                        <td class="text-gray-700">{{ $cuenta->nombre_alcaldia }}</td>
                        <td class="text-right font-bold text-green-600 text-lg">${{ number_format($cuenta->total, 2) }}</td>
                        <td class="text-center">
                            <span class="status-badge 
                                @if($cuenta->estado == 'pendiente') status-pendiente
                                @elseif($cuenta->estado == 'aprobado') status-aprobado
                                @elseif($cuenta->estado == 'aprobado_tesoreria') status-aprobado_tesoreria
                                @elseif($cuenta->estado == 'rechazado_supervisor') status-rechazado_supervisor
                                @elseif($cuenta->estado == 'rechazado_tesoreria') status-rechazado_tesoreria
                                @elseif($cuenta->estado == 'finalizado') status-finalizado
                                @endif">
                                <i class="fas 
                                    @if($cuenta->estado == 'pendiente') fa-clock
                                    @elseif(in_array($cuenta->estado, ['aprobado', 'aprobado_tesoreria'])) fa-check-circle
                                    @elseif(str_contains($cuenta->estado, 'rechazado')) fa-times-circle
                                    @elseif($cuenta->estado == 'finalizado') fa-flag-checkered
                                    @endif mr-1">
                                </i>
                                {{ str_replace('_', ' ', strtoupper($cuenta->estado)) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="flex items-center justify-center gap-2 flex-wrap">
                                {{-- Botón Ver siempre disponible --}}
                                <a href="{{ route('tesoreria.cuentas-cobro.show', $cuenta->id) }}" 
                                   class="btn-improved btn-view" title="Ver detalles completos">
                                    <i class="fas fa-eye"></i>
                                    <span>Ver</span>
                                </a>

                                {{-- Botones de Aprobar/Rechazar para cuentas aprobadas por supervisor --}}
                                @if($cuenta->estado == 'aprobado')
                                    <button type="button" 
                                            class="btn-improved btn-approve"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#aprobarModal{{ $cuenta->id }}"
                                            title="Aprobar cuenta">
                                        <i class="fas fa-check"></i>
                                        <span>Aprobar</span>
                                    </button>
                                    <button type="button" 
                                            class="btn-improved btn-reject"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#rechazarModal{{ $cuenta->id }}"
                                            title="Rechazar cuenta">
                                        <i class="fas fa-times"></i>
                                        <span>Rechazar</span>
                                    </button>

                                    {{-- Incluir modales --}}
                                    @include('tesoreria.cuentas-cobro.modales-aprobacion', ['cuenta' => $cuenta])
                                @endif

                                {{-- Indicador para cuentas aprobadas por tesorería --}}
                                @if($cuenta->estado == 'aprobado_tesoreria')
                                    <span class="badge-ready">
                                        <i class="fas fa-check-double mr-1"></i>Lista para pago
                                    </span>
                                @endif

                                {{-- Indicador para cuentas finalizadas --}}
                                @if($cuenta->estado == 'finalizado')
                                    <span class="badge-finalized">
                                        <i class="fas fa-flag-checkered mr-1"></i>Finalizada
                                    </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Paginación --}}
    @if($cuentasCobro->hasPages())
        <div class="mt-6 pagination-improved">
            {{ $cuentasCobro->links() }}
        </div>
    @endif

    {{-- Mensaje cuando no hay cuentas --}}
    @if($cuentasCobro->count() == 0)
        <div class="empty-state">
            <i class="fas fa-file-invoice-dollar"></i>
            <h3 class="text-2xl font-bold text-gray-700 mb-2">No hay cuentas para revisión</h3>
            <p class="text-gray-500 text-lg">Todas las cuentas aprobadas por el supervisor han sido procesadas.</p>
        </div>
    @endif
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endpush

@endsection