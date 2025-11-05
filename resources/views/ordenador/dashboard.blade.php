@extends('layouts.app')

@section('title', 'Panel del Ordenador del Gasto')

@section('content')
<div class="container">
    <h2 class="mb-4">
        <i class="fas fa-clipboard-list me-2"></i> Cuentas de Cobro Pendientes
    </h2>

    @if($cuentas->isEmpty())
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            No hay cuentas pendientes por revisar.
        </div>
    @else
        <div class="table-responsive shadow rounded">
            <table class="table table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Nombre Beneficiario</th>
                        <th>Concepto</th>
                        <th>Periodo</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cuentas as $cuenta)
                    <tr>
                        <td>{{ $cuenta->id }}</td>
                        <td>{{ $cuenta->nombre_beneficiario }}</td>
                        <td>{{ Str::limit($cuenta->concepto, 40) }}</td>
                        <td>{{ $cuenta->periodo }}</td>
                        <td>${{ number_format($cuenta->total, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge 
                                @if($cuenta->estado == 'pendiente') bg-warning text-dark
                                @elseif($cuenta->estado == 'Revisada') bg-info
                                @else bg-secondary @endif">
                                {{ ucfirst($cuenta->estado) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('ordenador.show', $cuenta->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i> Ver
                            </a>

                            <!-- Botón para modal de autorizar -->
                            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalAutorizar{{ $cuenta->id }}">
                                <i class="fas fa-check"></i> Autorizar
                            </button>

                            <!-- Botón para modal de rechazar -->
                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalRechazar{{ $cuenta->id }}">
                                <i class="fas fa-times"></i> Rechazar
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Autorizar -->
                    <div class="modal fade" id="modalAutorizar{{ $cuenta->id }}" tabindex="-1" aria-labelledby="modalAutorizarLabel{{ $cuenta->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-success text-white">
                                    <h5 class="modal-title" id="modalAutorizarLabel{{ $cuenta->id }}">
                                        Confirmar autorización
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    ¿Estás seguro de que deseas <strong>autorizar</strong> la cuenta de cobro
                                    <strong>#{{ $cuenta->id }}</strong> del beneficiario
                                    <strong>{{ $cuenta->nombre_beneficiario }}</strong>?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <form action="{{ route('ordenador.autorizar', $cuenta->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Sí, autorizar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Rechazar -->
                    <div class="modal fade" id="modalRechazar{{ $cuenta->id }}" tabindex="-1" aria-labelledby="modalRechazarLabel{{ $cuenta->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title" id="modalRechazarLabel{{ $cuenta->id }}">
                                        Confirmar rechazo
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p>¿Estás seguro de que deseas <strong>rechazar</strong> esta cuenta de cobro?</p>
                                    <form action="{{ route('ordenador.rechazar', $cuenta->id) }}" method="POST" id="formRechazar{{ $cuenta->id }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="observaciones{{ $cuenta->id }}" class="form-label">Motivo del rechazo:</label>
                                            <textarea name="observaciones" id="observaciones{{ $cuenta->id }}" class="form-control" rows="3" placeholder="Escribe una observación..."></textarea>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" form="formRechazar{{ $cuenta->id }}" class="btn btn-danger">
                                        Sí, rechazar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection




