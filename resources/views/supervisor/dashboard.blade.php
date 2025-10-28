@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="text-center mb-4">Panel del Supervisor</h2>

    {{-- Alertas --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Estadísticas --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h5>Total Cuentas</h5>
                    <h2>{{ $total }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <h5>Pendientes</h5>
                    <h2>{{ $pendientes }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h5>Aprobadas</h5>
                    <h2>{{ $aprobadas }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body text-center">
                    <h5>Rechazadas</h5>
                    <h2>{{ $rechazadas }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Gráfico --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="text-center">Resumen Gráfico</h5>
            <canvas id="graficoCuentas"></canvas>
        </div>
    </div>

    {{-- Tabla --}}
    <div class="card">
        <div class="card-body">
            <h5 class="text-center mb-3">Listado de Cuentas de Cobro</h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Beneficiario</th>
                        <th>Concepto</th>
                        <th>Estado</th>
                        <th>Fecha de Emisión</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cuentas as $cuenta)
                        <tr>
                            <td>{{ $cuenta->id }}</td>
                            <td>{{ $cuenta->nombre_beneficiario }}</td>
                            <td>{{ $cuenta->concepto }}</td>
                            <td>
                                <span class="badge 
                                    @if($cuenta->estado == 'pendiente') bg-warning
                                    @elseif($cuenta->estado == 'aprobada') bg-success
                                    @else bg-danger
                                    @endif">
                                    {{ ucfirst($cuenta->estado) }}
                                </span>
                            </td>
                            <td>{{ $cuenta->fecha_emision->format('d/m/Y') }}</td>
                            <td>
                                @if($cuenta->estado === 'pendiente')
                                    <form action="{{ route('supervisor.aprobar', $cuenta->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button class="btn btn-success btn-sm">Aprobar</button>
                                    </form>
                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rechazoModal{{ $cuenta->id }}">Rechazar</button>
                                @else
                                    <em>Sin acciones</em>
                                @endif
                            </td>
                        </tr>

                        {{-- Modal de rechazo --}}
                        <div class="modal fade" id="rechazoModal{{ $cuenta->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('supervisor.rechazar', $cuenta->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Rechazar Cuenta #{{ $cuenta->id }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <label for="observaciones" class="form-label">Observaciones</label>
                                            <textarea name="observaciones" id="observaciones" class="form-control" rows="3" required></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger">Rechazar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr><td colspan="6" class="text-center">No hay cuentas registradas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Script del gráfico --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('graficoCuentas');
new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Pendientes', 'Aprobadas', 'Rechazadas'],
        datasets: [{
            data: [{{ $pendientes }}, {{ $aprobadas }}, {{ $rechazadas }}],
            backgroundColor: ['#ffc107', '#28a745', '#dc3545']
        }]
    }
});
</script>
@endsection
