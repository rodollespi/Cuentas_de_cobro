@extends('layouts.app')

@push('styles')
<style>
    /* Aplicar estilos similares al área de Tesorería al contenido existente sin cambiar la estructura */
    .container.mt-4 { padding-top: 1rem; }
    .card.shadow-sm {
        background-color: rgba(255,255,255,0.04) !important;
        color: #fff !important;
        border: none !important;
    }
    .card.shadow-sm .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        color: #fff !important;
        border: none !important;
    }
    .card-body { color: inherit !important; }
    .table.table-bordered {
        background: transparent;
        color: #fff;
    }
    .table.table-bordered thead th {
        background-color: rgba(255,255,255,0.03);
        color: #fff;
    }
    .btn-info.btn-sm {
        background-color: rgba(13,110,253,0.9) !important;
        border-color: rgba(13,110,253,0.9) !important;
        color: #fff !important;
    }
    .btn-success { background-color: #1cc88a; border-color: #1cc88a; }
    .alert { color: inherit; }
</style>
@endpush

@section('content')
<!-- El contenedor para el modal se cargará dinámicamente aquí -->
<div id="modalContainer"></div>
<div class="container mt-4">
  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0">Carga de Documentos</h5>
    </div>

    <div class="card-body">
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      @if($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('contratista.documentos.store') }}" method="POST" enctype="multipart/form-data" class="mb-4">
        @csrf
        <div class="row">
          <div class="col-md-5">
            <label class="form-label">Nombre del documento</label>
            <input type="text" name="nombre" class="form-control" placeholder="Ej: RUT, Antecedentes, Cédula..." required>
          </div>
          <div class="col-md-5">
            <label class="form-label">Archivo (PDF o imagen)</label>
            <input type="file" name="archivo" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
          </div>
          <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-success w-100">Subir</button>
          </div>
        </div>
      </form>

      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Estado</th>
            <th>Comentario</th>
            <th>Acción</th>
          </tr>
        </thead>
        <tbody>
          @foreach($documentos as $doc)
            <tr>
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
                @if($doc->estado == 'rechazado')
                  <form action="{{ route('contratista.documentos.store') }}" method="POST" enctype="multipart/form-data" class="d-inline">
                    @csrf
                    <input type="hidden" name="nombre" value="{{ $doc->nombre }}">
                    <input type="file" name="archivo" class="form-control form-control-sm d-inline-block" required>
                    <button type="submit" class="btn btn-sm btn-outline-primary mt-2">Reemplazar</button>
                  </form>
                @else
                <button type="button" class="btn btn-info btn-sm view-document" 
                        data-document-id="{{ $doc->id }}">
                    <i class="fas fa-eye"></i> Ver
                </button>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const viewButtons = document.querySelectorAll('.view-document');
    
    viewButtons.forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            const documentId = this.getAttribute('data-document-id');
            
            try {
                // Hacer la petición para obtener la vista
                const response = await fetch(`/documento/vista/${documentId}`);
                const html = await response.text();
                
                // Insertar la vista en el contenedor
                document.getElementById('modalContainer').innerHTML = html;
                
                // Inicializar y mostrar el modal
                const modal = new bootstrap.Modal(document.getElementById('pdfViewer'));
                modal.show();
                
                // Limpiar el contenedor cuando se cierre el modal
                const pdfViewer = document.getElementById('pdfViewer');
                pdfViewer.addEventListener('hidden.bs.modal', function () {
                    document.getElementById('modalContainer').innerHTML = '';
                });
            } catch (error) {
                console.error('Error al cargar el documento:', error);
                alert('Error al cargar el documento');
            }
        });
    });
});
</script>
@endpush
@endsection
