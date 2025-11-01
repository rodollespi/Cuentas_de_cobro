@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Panel del Ordenador de Gasto</h1>
    <p>Bienvenida, {{ Auth::user()->name }}</p>

    <div class="card mt-3 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Acciones disponibles</h5>
            <ul>
                <li><a href="#">Ver cuentas de cobro pendientes</a></li>
                <li><a href="#">Autorizar pagos</a></li>
                <li><a href="#">Historial de gastos aprobados</a></li>
            </ul>
        </div>
    </div>
</div>
@endsection
