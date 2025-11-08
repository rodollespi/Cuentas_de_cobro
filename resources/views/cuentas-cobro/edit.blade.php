@extends('layouts.app')

@section('title', 'Editar Cuenta de Cobro - CuentasCobro')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-edit me-2"></i>
                        Editar Cuenta de Cobro #{{ $cuentaCobro->id }}
                    </h1>
                    <p class="text-muted mb-0">
                        <span class="badge bg-warning text-dark">
                            {{ $cuentaCobro->estado ?? 'Pendiente' }}
                        </span>
                    </p>
                </div>
                <div>
                    <a href="{{ route('cuentas-cobro.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Volver al Listado
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario -->
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card shadow">
                <div class="card-body">
                    <form action="{{ route('cuentas-cobro.update', $cuentaCobro->id) }}" method="POST" id="cuentaCobroForm">
                        @csrf
                        @method('PUT')

                        <!-- Información de la Alcaldía -->
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-building text-primary me-2"></i>
                                Información de la Alcaldía
                            </h5>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nombreAlcaldia" class="form-label">
                                        Nombre de la Alcaldía <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="nombreAlcaldia" 
                                           name="nombreAlcaldia" 
                                           value="{{ old('nombreAlcaldia', $cuentaCobro->nombre_alcaldia) }}"
                                           required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="nitAlcaldia" class="form-label">
                                        NIT Alcaldía <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="nitAlcaldia" 
                                           name="nitAlcaldia" 
                                           value="{{ old('nitAlcaldia', $cuentaCobro->nit_alcaldia) }}"
                                           required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="direccionAlcaldia" class="form-label">
                                        Dirección <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="direccionAlcaldia" 
                                           name="direccionAlcaldia" 
                                           value="{{ old('direccionAlcaldia', $cuentaCobro->direccion_alcaldia) }}"
                                           required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="telefonoAlcaldia" class="form-label">
                                        Teléfono <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="telefonoAlcaldia" 
                                           name="telefonoAlcaldia" 
                                           value="{{ old('telefonoAlcaldia', $cuentaCobro->telefono_alcaldia) }}"
                                           required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="ciudadAlcaldia" class="form-label">
                                        Ciudad <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="ciudadAlcaldia" 
                                           name="ciudadAlcaldia" 
                                           value="{{ old('ciudadAlcaldia', $cuentaCobro->ciudad_alcaldia) }}"
                                           required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="fechaEmision" class="form-label">
                                        Fecha de Emisión <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" 
                                           class="form-control" 
                                           id="fechaEmision" 
                                           name="fechaEmision" 
                                           value="{{ old('fechaEmision', \Carbon\Carbon::parse($cuentaCobro->fecha_emision)->format('Y-m-d')) }}"
                                           required>
                                </div>
                            </div>
                        </div>

                        <!-- Concepto y Detalle -->
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-file-alt text-primary me-2"></i>
                                Concepto y Detalle
                            </h5>

                            <div class="mb-3">
                                <label for="concepto" class="form-label">Concepto <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="concepto" name="concepto" rows="4" required>{{ old('concepto', $cuentaCobro->concepto) }}</textarea>
                            </div>

                            <!-- Items Detallados -->
                            <div class="mb-4">
                                <h6 class="border-bottom pb-2 mb-3">
                                    <i class="fas fa-list text-primary me-2"></i>
                                    Detalle de Items
                                </h6>

                                @php
                                    $items = is_array($cuentaCobro->detalle_items)
                                        ? $cuentaCobro->detalle_items
                                        : (json_decode($cuentaCobro->detalle_items, true) ?? []);
                                @endphp

                                <div id="items-container">
                                    @php
                                        if (is_array($cuentaCobro->detalle_items)) {
                                            $items = $cuentaCobro->detalle_items;
                                        } elseif (is_string($cuentaCobro->detalle_items)) {
                                            $items = json_decode($cuentaCobro->detalle_items, true) ?? [];
                                        } else {
                                            $items = [];
                                        }
                                    @endphp
                                    @if(!empty($items) && count($items) > 0)
                                        @foreach($items as $index => $item)
                                        <div class="item-row mb-3 p-3 border rounded">
                                            <div class="row">
                                                <div class="col-md-5 mb-2">
                                                    <label class="form-label">Descripción</label>
                                                    <input type="text" 
                                                           class="form-control descripcion" 
                                                           name="descripcion[]" 
                                                           value="{{ $item['descripcion'] ?? '' }}"
                                                           placeholder="Descripción del item">
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <label class="form-label">Cantidad</label>
                                                    <input type="number" 
                                                           class="form-control cantidad" 
                                                           name="cantidad[]" 
                                                           value="{{ $item['cantidad'] ?? 1 }}" 
                                                           min="1"
                                                           step="1">
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <label class="form-label">Valor Unitario</label>
                                                    <input type="number" 
                                                           class="form-control valor-unitario" 
                                                           name="valorUnitario[]" 
                                                           value="{{ $item['valor_unitario'] ?? 0 }}" 
                                                           min="0"
                                                           step="0.01">
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <label class="form-label">Valor Total</label>
                                                    <input type="number" 
                                                           class="form-control valor-total" 
                                                           name="valorTotal[]" 
                                                           value="{{ $item['valor_total'] ?? 0 }}" 
                                                           readonly>
                                                </div>
                                                <div class="col-md-1 mb-2 d-flex align-items-end">
                                                    <button type="button" class="btn btn-danger btn-sm remove-item" {{ $loop->first ? 'disabled' : '' }}>
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="item-row mb-3 p-3 border rounded">
                                            <div class="row">
                                                <div class="col-md-5 mb-2">
                                                    <label class="form-label">Descripción</label>
                                                    <input type="text" class="form-control descripcion" name="descripcion[]" value="">
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <label class="form-label">Cantidad</label>
                                                    <input type="number" class="form-control cantidad" name="cantidad[]" value="1">
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <label class="form-label">Valor Unitario</label>
                                                    <input type="number" class="form-control valor-unitario" name="valorUnitario[]" value="0">
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <label class="form-label">Valor Total</label>
                                                    <input type="number" class="form-control valor-total" name="valorTotal[]" value="0" readonly>
                                                </div>
                                                <div class="col-md-1 mb-2 d-flex align-items-end">
                                                    <button type="button" class="btn btn-danger btn-sm remove-item" disabled>
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <button type="button" class="btn btn-outline-primary btn-sm" id="add-item">
                                    <i class="fas fa-plus me-1"></i> Agregar Item
                                </button>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-between pt-3 border-top">
                            <a href="{{ route('cuentas-cobro.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i> Actualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const itemsContainer = document.getElementById('items-container');
    const addItemBtn = document.getElementById('add-item');

    addItemBtn.addEventListener('click', () => {
        const newItem = document.createElement('div');
        newItem.className = 'item-row mb-3 p-3 border rounded';
        newItem.innerHTML = `
            <div class="row">
                <div class="col-md-5 mb-2">
                    <label class="form-label">Descripción</label>
                    <input type="text" class="form-control descripcion" name="descripcion[]">
                </div>
                <div class="col-md-2 mb-2">
                    <label class="form-label">Cantidad</label>
                    <input type="number" class="form-control cantidad" name="cantidad[]" value="1">
                </div>
                <div class="col-md-2 mb-2">
                    <label class="form-label">Valor Unitario</label>
                    <input type="number" class="form-control valor-unitario" name="valorUnitario[]" value="0">
                </div>
                <div class="col-md-2 mb-2">
                    <label class="form-label">Valor Total</label>
                    <input type="number" class="form-control valor-total" name="valorTotal[]" value="0" readonly>
                </div>
                <div class="col-md-1 mb-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-sm remove-item"><i class="fas fa-times"></i></button>
                </div>
            </div>`;
        itemsContainer.appendChild(newItem);
        updateRemoveButtons();
    });

    itemsContainer.addEventListener('click', e => {
        if (e.target.closest('.remove-item')) {
            e.target.closest('.item-row').remove();
            updateRemoveButtons();
        }
    });

    function updateRemoveButtons() {
        const items = document.querySelectorAll('.item-row');
        document.querySelectorAll('.remove-item').forEach(btn => {
            btn.disabled = items.length <= 1;
        });
    }

    updateRemoveButtons();
});
</script>
@endpush

@push('styles')
<style>
.item-row {
    background-color: #f8f9fa;
    transition: background-color 0.2s;
}
.item-row:hover {
    background-color: #e9ecef;
}
.remove-item:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>
@endpush
@endsection
