@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Subir Documentos</h2>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Formulario para subir --}}
    <form action="{{ route('contratista.documentos.store') }}" method="POST" enctype="multipart/form-data" class="mb-4">
    @csrf

    <div class="mb-3">
        <label for="nombre" class="form-label">Tipo de Documento</label>
        <select name="nombre" id="nombre" class="form-control" required>
    <option value="">Seleccione un tipo de documento</option>

    <optgroup label="Documentos Jurídicos">
        <option value="Cédula del Representante Legal">Cédula del Representante Legal</option>
        <option value="RUT">RUT</option>
        <option value="Certificado de Existencia y Representación Legal">Certificado de Existencia y Representación Legal</option>
        <option value="Registro Único de Proponentes (RUP)">Registro Único de Proponentes (RUP)</option>
        <option value="Antecedentes Disciplinarios">Antecedentes Disciplinarios</option>
        <option value="Responsabilidad Fiscal">Responsabilidad Fiscal</option>
        <option value="Antecedentes Judiciales">Antecedentes Judiciales</option>
        <option value="Hoja de Vida">Hoja de Vida</option>
    </optgroup>

    <optgroup label="Documentos Financieros">
        <option value="Estados Financieros">Estados Financieros</option>
        <option value="Declaración de Renta">Declaración de Renta</option>
        <option value="Certificación Bancaria">Certificación Bancaria</option>
        <option value="Formato Único de Ingresos">Formato Único de Ingresos</option>
    </optgroup>

    <optgroup label="Documentos de Experiencia">
        <option value="Contratos Ejecutados">Contratos Ejecutados</option>
        <option value="Certificaciones de Experiencia">Certificaciones de Experiencia</option>
        <option value="Soportes de Experiencia">Soportes de Experiencia</option>
    </optgroup>

    <optgroup label="Documentos Técnicos">
        <option value="Propuesta Técnica">Propuesta Técnica</option>
        <option value="Propuesta Económica">Propuesta Económica</option>
        <option value="Cronograma">Cronograma</option>
        <option value="Ficha Técnica">Ficha Técnica</option>
    </optgroup>

    <optgroup label="Otros">
        <option value="Seguro de Cumplimiento">Seguro de Cumplimiento</option>
        <option value="Pago Seguridad Social">Pago Seguridad Social</option>
        <option value="Pólizas">Pólizas</option>
        <option value="Cámara de Comercio">Cámara de Comercio</option>
    </optgroup>
</select>

        
    </div>

    <div class="mb-3">
        <label for="archivo" class="form-label">Selecciona un archivo (PDF, JPG, PNG)</label>
        <input type="file" name="archivo" id="archivo" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Subir documento</button>
</form>


    {{-- Lista de documentos subidos --}}
   
    <h4>Mis documentos enviados</h4>

@if($documentos->isEmpty())
    <p class="text-muted">No has subido documentos aún.</p>
@else
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Comentario</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($documentos as $doc)
                <tr>
                    <td>{{ $doc->nombre }}</td>

                    {{-- ESTADO --}}
                    <td>
                        @if($doc->estado === 'aprobado')
                            <span class="badge bg-success">Aprobado</span>
                        @elseif($doc->estado === 'rechazado')
                            <span class="badge bg-danger">Rechazado</span>
                        @else
                            <span class="badge bg-warning text-dark">Pendiente</span>
                        @endif
                    </td>

                    {{-- COMENTARIO --}}
                    <td>
                        @if($doc->comentario)
                            <span>{{ $doc->comentario }}</span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>

                    {{-- FECHA --}}
                    <td>{{ $doc->created_at->format('d/m/Y H:i') }}</td>

                    {{-- ACCIONES --}}
                    <td>
                     <a href="{{ route('documento.vista', $doc->id) }}" class="btn btn-sm btn-info" target="_blank">
                     <i class="fas fa-eye"></i> Ver
                     </a>
                        @if($doc->estado === 'rechazado')
                            {{-- PERMITIR RESUBIR --}}
                            <form action="{{ route('contratista.documentos.store') }}"
                                  method="POST" enctype="multipart/form-data" class="mt-2">
                                @csrf
                                <input type="hidden" name="nombre" value="{{ $doc->nombre }}">
                                <input type="file" name="archivo" class="form-control form-control-sm mb-1" required>
                                <button type="submit" class="btn btn-sm btn-warning">
                                    Volver a subir
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
</div>
@endsection
