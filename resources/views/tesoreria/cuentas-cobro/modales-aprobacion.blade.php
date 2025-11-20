{{-- Modal para Aprobar --}}
<div class="modal fade" id="aprobarModal{{ $cuenta->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-check me-2"></i>Aprobar Cuenta #{{ $cuenta->id }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('tesoreria.cuentas-cobro.aprobar', $cuenta->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>¿Estás seguro de aprobar esta cuenta de cobro?</p>
                    <div class="mb-3">
                        <label for="observacionesAprobar{{ $cuenta->id }}" class="form-label">
                            Observaciones (opcional):
                        </label>
                        <textarea class="form-control" id="observacionesAprobar{{ $cuenta->id }}" 
                                name="observaciones" rows="3" 
                                placeholder="Observaciones adicionales..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check me-1"></i>Aprobar Cuenta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal para Rechazar --}}
<div class="modal fade" id="rechazarModal{{ $cuenta->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-times me-2"></i>Rechazar Cuenta #{{ $cuenta->id }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('tesoreria.cuentas-cobro.rechazar', $cuenta->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>¿Estás seguro de rechazar esta cuenta de cobro?</p>
                    <div class="mb-3">
                        <label for="observacionesRechazar{{ $cuenta->id }}" class="form-label">
                            Motivo del rechazo <span class="text-danger">*</span>:
                        </label>
                        <textarea class="form-control" id="observacionesRechazar{{ $cuenta->id }}" 
                                name="observaciones" rows="3" required
                                placeholder="Explica el motivo del rechazo..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times me-1"></i>Rechazar Cuenta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>