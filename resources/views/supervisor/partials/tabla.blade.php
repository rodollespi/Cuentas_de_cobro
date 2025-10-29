<table class="table table-striped">
    <thead>
        <tr>
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
                        <a href="{{ route('supervisor.revisar', $cuenta->id) }}" class="btn btn-info btn-sm">
                            Revisar
                        </a>
                    @else
                        <a href="{{ route('supervisor.ver', $cuenta->id) }}" class="btn btn-secondary btn-sm">
                            Ver
                        </a>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center">No hay cuentas registradas en esta categoría.</td></tr>
        @endforelse
    </tbody>
</table>
