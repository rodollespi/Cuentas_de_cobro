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
                                           class="form-control @error('nombreAlcaldia') is-invalid @enderror" 
                                           id="nombreAlcaldia" 
                                           name="nombreAlcaldia" 
                                           value="{{ old('nombreAlcaldia', $cuentaCobro->nombre_alcaldia) }}"
                                           placeholder="Ej: Alcaldía Municipal de Bogotá"
                                           required>
                                    @error('nombreAlcaldia')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="nitAlcaldia" class="form-label">
                                        NIT Alcaldía <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('nitAlcaldia') is-invalid @enderror" 
                                           id="nitAlcaldia" 
                                           name="nitAlcaldia" 
                                           value="{{ old('nitAlcaldia', $cuentaCobro->nit_alcaldia) }}"
                                           placeholder="Ej: 800.123.456-7"
                                           required>
                                    @error('nitAlcaldia')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="direccionAlcaldia" class="form-label">
                                        Dirección <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('direccionAlcaldia') is-invalid @enderror" 
                                           id="direccionAlcaldia" 
                                           name="direccionAlcaldia" 
                                           value="{{ old('direccionAlcaldia', $cuentaCobro->direccion_alcaldia) }}"
                                           placeholder="Ej: Carrera 8 #10-65"
                                           required>
                                    @error('direccionAlcaldia')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="telefonoAlcaldia" class="form-label">
                                        Teléfono <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('telefonoAlcaldia') is-invalid @enderror" 
                                           id="telefonoAlcaldia" 
                                           name="telefonoAlcaldia" 
                                           value="{{ old('telefonoAlcaldia', $cuentaCobro->telefono_alcaldia) }}"
                                           placeholder="Ej: 6013813000"
                                           required>
                                    @error('telefonoAlcaldia')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="ciudadAlcaldia" class="form-label">
                                        Ciudad <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('ciudadAlcaldia') is-invalid @enderror" 
                                           id="ciudadAlcaldia" 
                                           name="ciudadAlcaldia" 
                                           value="{{ old('ciudadAlcaldia', $cuentaCobro->ciudad_alcaldia) }}"
                                           placeholder="Ej: Bogotá"
                                           required>
                                    @error('ciudadAlcaldia')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="fechaEmision" class="form-label">
                                        Fecha de Emisión <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" 
                                           class="form-control @error('fechaEmision') is-invalid @enderror" 
                                           id="fechaEmision" 
                                           name="fechaEmision" 
                                           value="{{ old('fechaEmision', $cuentaCobro->fecha_emision->format('Y-m-d')) }}"
                                           required>
                                    @error('fechaEmision')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Información del Beneficiario -->
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-user text-primary me-2"></i>
                                Información del Beneficiario
                            </h5>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nombreBeneficiario" class="form-label">
                                        Nombre Completo <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('nombreBeneficiario') is-invalid @enderror" 
                                           id="nombreBeneficiario" 
                                           name="nombreBeneficiario" 
                                           value="{{ old('nombreBeneficiario', $cuentaCobro->nombre_beneficiario) }}"
                                           placeholder="Nombre del beneficiario"
                                           required>
                                    @error('nombreBeneficiario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="tipoDocumento" class="form-label">
                                        Tipo de Documento <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control @error('tipoDocumento') is-invalid @enderror" 
                                            id="tipoDocumento" 
                                            name="tipoDocumento"
                                            required>
                                        <option value="">Seleccionar...</option>
                                        <option value="Cédula" {{ old('tipoDocumento', $cuentaCobro->tipo_documento) == 'Cédula' ? 'selected' : '' }}>Cédula</option>
                                        <option value="NIT" {{ old('tipoDocumento', $cuentaCobro->tipo_documento) == 'NIT' ? 'selected' : '' }}>NIT</option>
                                        <option value="Pasaporte" {{ old('tipoDocumento', $cuentaCobro->tipo_documento) == 'Pasaporte' ? 'selected' : '' }}>Pasaporte</option>
                                        <option value="Cédula Extranjería" {{ old('tipoDocumento', $cuentaCobro->tipo_documento) == 'Cédula Extranjería' ? 'selected' : '' }}>Cédula Extranjería</option>
                                    </select>
                                    @error('tipoDocumento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="numeroDocumento" class="form-label">
                                        Número de Documento <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('numeroDocumento') is-invalid @enderror" 
                                           id="numeroDocumento" 
                                           name="numeroDocumento" 
                                           value="{{ old('numeroDocumento', $cuentaCobro->numero_documento) }}"
                                           placeholder="Número de documento"
                                           required>
                                    @error('numeroDocumento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="telefonoBeneficiario" class="form-label">
                                        Teléfono
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('telefonoBeneficiario') is-invalid @enderror" 
                                           id="telefonoBeneficiario" 
                                           name="telefonoBeneficiario" 
                                           value="{{ old('telefonoBeneficiario', $cuentaCobro->telefono_beneficiario) }}"
                                           placeholder="Teléfono de contacto">
                                    @error('telefonoBeneficiario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 mb-3">
                                    <label for="direccionBeneficiario" class="form-label">
                                        Dirección
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('direccionBeneficiario') is-invalid @enderror" 
                                           id="direccionBeneficiario" 
                                           name="direccionBeneficiario" 
                                           value="{{ old('direccionBeneficiario', $cuentaCobro->direccion_beneficiario) }}"
                                           placeholder="Dirección completa">
                                    @error('direccionBeneficiario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Concepto y Valores -->
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-file-alt text-primary me-2"></i>
                                Concepto y Valores
                            </h5>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="periodo" class="form-label">
                                        Período <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('periodo') is-invalid @enderror" 
                                           id="periodo" 
                                           name="periodo" 
                                           value="{{ old('periodo', $cuentaCobro->periodo) }}"
                                           placeholder="Ej: Enero 2024"
                                           required>
                                    @error('periodo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 mb-3">
                                    <label for="concepto" class="form-label">
                                        Concepto <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control @error('concepto') is-invalid @enderror" 
                                              id="concepto" 
                                              name="concepto" 
                                              rows="4"
                                              placeholder="Describe detalladamente el concepto de la cuenta de cobro..."
                                              required>{{ old('concepto', $cuentaCobro->concepto) }}</textarea>
                                    @error('concepto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Items Detallados -->
                            <div class="mb-4">
                                <h6 class="border-bottom pb-2 mb-3">
                                    <i class="fas fa-list text-primary me-2"></i>
                                    Detalle de Items
                                </h6>
                                
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
                                        </div>
                                        @endforeach
                                    @else
                                        <!-- Item por defecto si no hay items -->
                                        <div class="item-row mb-3 p-3 border rounded">
                                            <div class="row">
                                                <div class="col-md-5 mb-2">
                                                    <label class="form-label">Descripción</label>
                                                    <input type="text" 
                                                           class="form-control descripcion" 
                                                           name="descripcion[]" 
                                                           value="{{ old('descripcion.0') }}"
                                                           placeholder="Descripción del item">
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <label class="form-label">Cantidad</label>
                                                    <input type="number" 
                                                           class="form-control cantidad" 
                                                           name="cantidad[]" 
                                                           value="{{ old('cantidad.0', 1) }}" 
                                                           min="1"
                                                           step="1">
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <label class="form-label">Valor Unitario</label>
                                                    <input type="number" 
                                                           class="form-control valor-unitario" 
                                                           name="valorUnitario[]" 
                                                           value="{{ old('valorUnitario.0', 0) }}" 
                                                           min="0"
                                                           step="0.01">
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <label class="form-label">Valor Total</label>
                                                    <input type="number" 
                                                           class="form-control valor-total" 
                                                           name="valorTotal[]" 
                                                           value="{{ old('valorTotal.0', 0) }}" 
                                                           readonly>
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

                            <!-- Resumen de Valores -->
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="subtotal" class="form-label">
                                        Subtotal <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" 
                                               class="form-control @error('subtotal') is-invalid @enderror" 
                                               id="subtotal" 
                                               name="subtotal" 
                                               value="{{ old('subtotal', $cuentaCobro->subtotal) }}"
                                               placeholder="0.00"
                                               step="0.01"
                                               min="0"
                                               required>
                                        @error('subtotal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="iva" class="form-label">
                                        IVA <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" 
                                               class="form-control @error('iva') is-invalid @enderror" 
                                               id="iva" 
                                               name="iva" 
                                               value="{{ old('iva', $cuentaCobro->iva) }}"
                                               placeholder="0.00"
                                               step="0.01"
                                               min="0"
                                               required>
                                        @error('iva')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="total" class="form-label">
                                        Total <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" 
                                               class="form-control @error('total') is-invalid @enderror" 
                                               id="total" 
                                               name="total" 
                                               value="{{ old('total', $cuentaCobro->total) }}"
                                               placeholder="0.00"
                                               step="0.01"
                                               min="0"
                                               required>
                                        @error('total')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información Bancaria -->
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-university text-primary me-2"></i>
                                Información Bancaria
                            </h5>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="banco" class="form-label">
                                        Banco <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('banco') is-invalid @enderror" 
                                           id="banco" 
                                           name="banco" 
                                           value="{{ old('banco', $cuentaCobro->banco) }}"
                                           placeholder="Ej: Bancolombia"
                                           required>
                                    @error('banco')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="tipoCuenta" class="form-label">
                                        Tipo de Cuenta <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control @error('tipoCuenta') is-invalid @enderror" 
                                            id="tipoCuenta" 
                                            name="tipoCuenta"
                                            required>
                                        <option value="">Seleccionar...</option>
                                        <option value="Ahorros" {{ old('tipoCuenta', $cuentaCobro->tipo_cuenta) == 'Ahorros' ? 'selected' : '' }}>Ahorros</option>
                                        <option value="Corriente" {{ old('tipoCuenta', $cuentaCobro->tipo_cuenta) == 'Corriente' ? 'selected' : '' }}>Corriente</option>
                                    </select>
                                    @error('tipoCuenta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="numeroCuenta" class="form-label">
                                        Número de Cuenta <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('numeroCuenta') is-invalid @enderror" 
                                           id="numeroCuenta" 
                                           name="numeroCuenta" 
                                           value="{{ old('numeroCuenta', $cuentaCobro->numero_cuenta) }}"
                                           placeholder="Número de cuenta bancaria"
                                           required>
                                    @error('numeroCuenta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="titularCuenta" class="form-label">
                                        Titular de la Cuenta <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('titularCuenta') is-invalid @enderror" 
                                           id="titularCuenta" 
                                           name="titularCuenta" 
                                           value="{{ old('titularCuenta', $cuentaCobro->titular_cuenta) }}"
                                           placeholder="Nombre del titular"
                                           required>
                                    @error('titularCuenta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="d-flex justify-content-between pt-3 border-top">
                            <a href="{{ route('cuentas-cobro.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>
                                Actualizar Cuenta de Cobro
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
        
        // Agregar nuevo item
        addItemBtn.addEventListener('click', function() {
            const newItem = document.createElement('div');
            newItem.className = 'item-row mb-3 p-3 border rounded';
            newItem.innerHTML = `
                <div class="row">
                    <div class="col-md-5 mb-2">
                        <label class="form-label">Descripción</label>
                        <input type="text" class="form-control descripcion" name="descripcion[]" placeholder="Descripción del item">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label class="form-label">Cantidad</label>
                        <input type="number" class="form-control cantidad" name="cantidad[]" value="1" min="1" step="1">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label class="form-label">Valor Unitario</label>
                        <input type="number" class="form-control valor-unitario" name="valorUnitario[]" value="0" min="0" step="0.01">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label class="form-label">Valor Total</label>
                        <input type="number" class="form-control valor-total" name="valorTotal[]" value="0" readonly>
                    </div>
                    <div class="col-md-1 mb-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-sm remove-item">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            `;
            itemsContainer.appendChild(newItem);
            
            // Agregar event listeners a los nuevos campos
            const cantidadInput = newItem.querySelector('.cantidad');
            const valorUnitarioInput = newItem.querySelector('.valor-unitario');
            
            cantidadInput.addEventListener('input', calcularValores);
            valorUnitarioInput.addEventListener('input', calcularValores);
            
            // Actualizar botones de eliminar
            updateRemoveButtons();
        });
        
        // Calcular valores de items
        function calcularValores() {
            let subtotalGeneral = 0;
            
            document.querySelectorAll('.item-row').forEach(row => {
                const cantidad = parseFloat(row.querySelector('.cantidad').value) || 0;
                const valorUnitario = parseFloat(row.querySelector('.valor-unitario').value) || 0;
                const valorTotal = cantidad * valorUnitario;
                
                // Actualizar valor total del item
                row.querySelector('.valor-total').value = valorTotal.toFixed(2);
                subtotalGeneral += valorTotal;
            });
            
            // Actualizar subtotal general
            document.getElementById('subtotal').value = subtotalGeneral.toFixed(2);
            
            // Calcular total general
            calcularTotalGeneral();
        }
        
        // Calcular total general (subtotal + IVA)
        function calcularTotalGeneral() {
            const subtotal = parseFloat(document.getElementById('subtotal').value) || 0;
            const iva = parseFloat(document.getElementById('iva').value) || 0;
            const total = subtotal + iva;
            
            document.getElementById('total').value = total.toFixed(2);
        }
        
        // Actualizar botones de eliminar
        function updateRemoveButtons() {
            const items = document.querySelectorAll('.item-row');
            const removeButtons = document.querySelectorAll('.remove-item');
            
            removeButtons.forEach(btn => {
                btn.disabled = items.length <= 1;
            });
        }
        
        // Eliminar item
        itemsContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-item') || e.target.closest('.remove-item')) {
                const btn = e.target.classList.contains('remove-item') ? e.target : e.target.closest('.remove-item');
                if (!btn.disabled) {
                    btn.closest('.item-row').remove();
                    calcularValores();
                    updateRemoveButtons();
                }
            }
        });
        
        // Event listeners para cálculos iniciales
        document.querySelectorAll('.cantidad, .valor-unitario').forEach(input => {
            input.addEventListener('input', calcularValores);
        });
        
        document.getElementById('iva').addEventListener('input', calcularTotalGeneral);
        
        // Calcular valores iniciales
        calcularValores();
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
    .form-label {
        font-weight: 500;
        font-size: 0.875rem;
    }
    .remove-item:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>
@endpush
@endsection