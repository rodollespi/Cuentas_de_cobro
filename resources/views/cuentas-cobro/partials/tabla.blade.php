@if($cuentas->count() > 0)
<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha Emisión</th>
                <th>Concepto</th>
                <th>Estado</th>
                <th>Total</th>
                <th class="no-print">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cuentas as $cuenta)
            <tr>
                <td><strong>#{{ $cuenta->id }}</strong></td>
                <td>{{ \Carbon\Carbon::parse($cuenta->fecha_emision)->format('d/m/Y') }}</td>
                <td>{{ Str::limit($cuenta->concepto, 50) }}</td>
                <td>
                    @php
                        $s = strtolower($cuenta->estado ?? '');
                        if (str_contains($s, 'pendient')) {
                            $badgeClass = 'bg-warning';
                            $label = 'Pendiente';
                        } elseif (str_contains($s, 'aproba')) {
                            $badgeClass = 'bg-success';
                            $label = 'Aprobada';
                        } elseif (str_contains($s, 'rechaz')) {
                            $badgeClass = 'bg-danger';
                            $label = 'Rechazada';
                        } else {
                            $badgeClass = 'bg-secondary';
                            $label = ucfirst($cuenta->estado ?? 'Pendiente');
                        }
                    @endphp
                    <span class="badge {{ $badgeClass }}">
                        {{ $label }}
                    </span>
                </td>
                <td><strong>${{ number_format($cuenta->total, 2) }}</strong></td>
                <td class="no-print">
                    <div class="btn-group">
                        <a href="{{ route('cuentas-cobro.show', $cuenta->id) }}" 
                           class="btn btn-sm btn-info" 
                           title="Ver detalles">
                            <i class="fas fa-eye"></i>
                        </a>
                        @if($cuenta->estado === 'pendiente')
                        <a href="{{ route('cuentas-cobro.edit', $cuenta->id) }}" 
                           class="btn btn-sm btn-warning" 
                           title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('cuentas-cobro.destroy', $cuenta->id) }}" 
                              method="POST" 
                              style="display: inline;"
                              onsubmit="return confirm('¿Estás seguro de eliminar esta cuenta de cobro?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-sm btn-danger" 
                                    title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="alert alert-info">
    <i class="fas fa-info-circle me-2"></i>
    No hay cuentas de cobro en esta categoría.
</div>
@endif