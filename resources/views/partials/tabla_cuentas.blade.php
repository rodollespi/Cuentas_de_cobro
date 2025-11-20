<table class="table table-striped table-hover">
    <thead class="table-dark">
        <tr>
            <th width="80">ID</th>
            <th>Alcaldía</th>
            <th width="120">Valor</th>
            <th width="120">Estado</th>
            <th width="120">Fecha</th>
            <th width="250">Acciones</th>
        </tr>
    </thead>

    <tbody>
        @forelse($cuentas as $cuenta)
            <tr>
                <td><strong>#{{ $cuenta->id }}</strong></td>
                <td>
                    <div class="fw-semibold">{{ $cuenta->nombre_alcaldia }}</div>
                    <small class="text-muted">{{ Str::limit($cuenta->concepto, 40) }}</small>
                </td>
                <td class="fw-bold text-success">${{ number_format($cuenta->total, 0, ',', '.') }}</td>
                <td>
                    @php
                        $estadoColor = [
                            'pendiente' => 'warning',
                            'aprobado' => 'success', 
                            'rechazado' => 'danger',
                            'finalizado' => 'info'
                        ][strtolower($cuenta->estado)] ?? 'secondary';
                    @endphp
                    <span class="badge bg-{{ $estadoColor }}">
                        {{ ucfirst($cuenta->estado) }}
                    </span>
                </td>
                <td>
                    <small>{{ $cuenta->created_at->format('d/m/Y') }}</small>
                </td>
                <td>
                    <div class="d-flex gap-1 flex-wrap">
                        <!-- Botón Ver -->
                        <a href="{{ route('cuentas-cobro.show', $cuenta->id) }}" 
                           class="btn btn-outline-primary btn-sm" title="Ver detalles">
                            <i class="fas fa-eye"></i>
                        </a>
                        
                        <!-- Botón Descargar PDF - SIEMPRE VISIBLE -->
                        <a href="{{ route('cuentas-cobro.descargar-pdf', $cuenta->id) }}" 
                           class="btn btn-outline-success btn-sm" title="Descargar PDF" target="_blank">
                            <i class="fas fa-download"></i> PDF
                        </a>

                        <!-- Botones Editar y Eliminar SOLO para pendientes y rechazadas -->
                        @if (in_array(strtolower($cuenta->estado), ['pendiente', 'rechazado']))
                            <a href="{{ route('cuentas-cobro.edit', $cuenta->id) }}" 
                               class="btn btn-outline-warning btn-sm" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <!-- Botón Eliminar -->
                            <form action="{{ route('cuentas-cobro.destroy', $cuenta->id) }}" 
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm"
                                        title="Eliminar"
                                        onclick="return confirm('¿Estás seguro de eliminar esta cuenta de cobro?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center py-5">
                    <div class="text-muted">
                        <i class="fas fa-file-invoice-dollar fa-3x mb-3"></i>
                        <h5>No hay cuentas de cobro</h5>
                        <p class="mb-0">Comienza creando tu primera cuenta de cobro</p>
                    </div>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>