
@extends('tesoreria.layouts.app')

@section('title', 'Contratistas con Documentos Aprobados')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-center">Contratistas con Todos los Documentos Aprobados</h1>

    <div class="card bg-white bg-opacity-10 text-white">
        <div class="card-header">
            <h5><i class="fas fa-list me-1"></i> Lista de Contratistas</h5>
        </div>
        <div class="card-body p-0">

            @if($contratistas->count() === 0)
                <p class="text-center py-3">No hay contratistas con todos los documentos aprobados.</p>
                @else
                <div class="table-responsive">
                    <table class="table table-hover text-white mb-0">
                        <thead>
                            <tr>
                                <th>Contratista</th>
                                <th>Email</th>
                                <th>Total Documentos</th>
                                <th>Documentos Aprobados</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contratistas as $contratista)
                            <tr>
                                <td><strong>{{ $contratista->name }}</strong></td>
                                <td>{{ $contratista->email }}</td>
                                <td>{{ $contratista->total_documentos }}</td>
                                <td>{{ $contratista->documentos_aprobados }}</td>
                                <td>
                                    <a href="{{ route('tesoreria.cuentas-cobro.index', ['contratista' => $contratista->name]) }}" 
                                       class="btn btn-sm btn-outline-light">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
