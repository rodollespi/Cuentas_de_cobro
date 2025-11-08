@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Mis Cuentas de Cobro</h2>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('cuentas-cobro.create') }}" class="btn btn-primary">
            Crear Nueva Cuenta de Cobro
        </a>

        <div class="mb-3">
 
      <a href="{{ route('contratista.documentos') }}" class="btn btn-outline-primary mt-3">
 <i class="fas fa-upload me-2"></i> Subir Documentos
  </a>
</div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Panel del Contratista</h5>
        
            @if($cuentasCobro->count() > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha Emisión</th>
                        <th>Concepto</th>
                        <th>Beneficiario</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cuentasCobro as $cuenta)
                    <tr>
                        <td>{{ $cuenta->id }}</td>
                        <td>{{ $cuenta->fecha_emision }}</td>
                        <td>{{ $cuenta->concepto }}</td>
                        <td>{{ $cuenta->nombre_beneficiario }}</td>
                        <td>${{ number_format($cuenta->total, 2) }}</td>
                        <td>
                            <a href="{{ route('cuentas-cobro.show', $cuenta->id) }}" class="btn btn-info btn-sm">Ver</a>
                            <a href="{{ route('cuentas-cobro.edit', $cuenta->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('cuentas-cobro.destroy', $cuenta->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="alert alert-info">
                No hay cuentas de cobro registradas. 
                <a href="{{ route('cuentas-cobro.create') }}">Crear la primera</a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection