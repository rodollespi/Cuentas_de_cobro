@extends('layouts.app')

@section('content')
<div class="container mt-4">
  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0">Verificación de Documentos</h5>
    </div>
    <div class="card-body">
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      <table class="table table-hover">
        <thead>
          <tr>
            <th>Contratista</th>
            <th>Documento</th>
            <th>Estado</th>
            <th>Comentario</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach($documentos as $doc)
            <tr>
              <td>{{ $doc->user->name ?? 'Sin asignar' }}</td>
              <td>{{ $doc->nombre }}</td>
              <td>
                <span class="badge 
                  @if($doc->estado == 'aprobado') bg-success 
                  @elseif($doc->estado == 'rechazado') bg-danger 
                  @else bg-warning text-dark 
                  @endif">
                  {{ ucfirst($doc->estado) }}
                </span>
              </td>
              <td>{{ $doc->comentario ?? '-' }}</td>
              <td>
                <a href="{{ route('contratacion.ver', $doc->id) }}" class="btn btn-sm btn-outline-primary">Ver</a>

                <!-- Botón para aprobar -->
                <form action="{{ route('contratacion.actualizarEstado', $doc->id) }}" method="POST" class="d-inline">
                  @csrf
                  <input type="hidden" name="estado" value="aprobado">
                  <button type="submit" class="btn btn-sm btn-success">Aprobar</button>
                </form>

                <!-- Botón para rechazar -->
                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rechazoModal{{ $doc->id }}">
                  Rechazar
                </button>

                <!-- Modal de rechazo -->
                <div class="modal fade" id="rechazoModal{{ $doc->id }}" tabindex="-1">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <form method="POST" action="{{ route('contratacion.actualizarEstado', $doc->id) }}">
                        @csrf
                        <div class="modal-header">
                          <h5 class="modal-title">Motivo del Rechazo</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                          <input type="hidden" name="estado" value="rechazado">
                          <textarea name="comentario" class="form-control" rows="3" placeholder="Describe el motivo del rechazo..."></textarea>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                          <button type="submit" class="btn btn-danger">Enviar</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection