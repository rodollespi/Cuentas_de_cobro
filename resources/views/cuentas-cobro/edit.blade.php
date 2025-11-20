@extends('layouts.app')

@section('title', 'Editar Cuenta de Cobro - CuentasCobro')

@push('styles')
<style>
    .form-section {
        background: white;
        border-radius: 10px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        border-left: 4px solid #1e4a82;
    }
    
    .section-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #1e4a82;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e9ecef;
    }
    
    .required-field::after {
        content: " *";
        color: #dc3545;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-edit me-2"></i>
                        Editar Cuenta de Cobro #{{ $cuentaCobro->id }}
                    </h1>
                    <p class="text-muted mb-0">Modifica la información de tu cuenta de cobro</p>
                </div>
                <div>
                    <a href="{{ route('cuentas-cobro.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Volver al Listado
                    </a>
                </div>
            </div>

            <!-- Alertas -->
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Por favor corrige los siguientes errores:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Formulario de Edición -->
            <form action="{{ route('cuentas-cobro.update', $cuentaCobro->id) }}" method="POST" id="editCuentaForm">
                @csrf
                @method('PUT')

                <!-- Información de la Alcaldía -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-building me-2"></i>Información de la Alcaldía
                    </h3>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nombreAlcaldia" class="form-label required-field">Nombre de la Alcaldía</label>
                                <input type="text" 
                                       class="form-control @error('nombreAlcaldia') is-invalid @enderror" 
                                       id="nombreAlcaldia" 
                                       name="nombreAlcaldia" 
                                       value="{{ old('nombreAlcaldia', $cuentaCobro->nombre_alcaldia) }}"
                                       required>
                                @error('nombreAlcaldia')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nitAlcaldia" class="form-label required-field">NIT</label>
                                <input type="text" 
                                       class="form-control @error('nitAlcaldia') is-invalid @enderror" 
                                       id="nitAlcaldia" 
                                       name="nitAlcaldia" 
                                       value="{{ old('nitAlcaldia', $cuentaCobro->nit_alcaldia) }}"
                                       required>
                                @error('nitAlcaldia')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="direccionAlcaldia" class="form-label required-field">Dirección</label>
                                <input type="text" 
                                       class="form-control @error('direccionAlcaldia') is-invalid @enderror" 
                                       id="direccionAlcaldia" 
                                       name="direccionAlcaldia" 
                                       value="{{ old('direccionAlcaldia', $cuentaCobro->direccion_alcaldia) }}"
                                       required>
                                @error('direccionAlcaldia')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telefonoAlcaldia" class="form-label required-field">Teléfono</label>
                                <input type="text" 
                                       class="form-control @error('telefonoAlcaldia') is-invalid @enderror" 
                                       id="telefonoAlcaldia" 
                                       name="telefonoAlcaldia" 
                                       value="{{ old('telefonoAlcaldia', $cuentaCobro->telefono_alcaldia) }}"
                                       required>
                                @error('telefonoAlcaldia')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ciudadAlcaldia" class="form-label required-field">Ciudad</label>
                                <input type="text" 
                                       class="form-control @error('ciudadAlcaldia') is-invalid @enderror" 
                                       id="ciudadAlcaldia" 
                                       name="ciudadAlcaldia" 
                                       value="{{ old('ciudadAlcaldia', $cuentaCobro->ciudad_alcaldia) }}"
                                       required>
                                @error('ciudadAlcaldia')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="fechaEmision" class="form-label required-field">Fecha de Emisión</label>
                                <input type="date" 
                                       class="form-control @error('fechaEmision') is-invalid @enderror" 
                                       id="fechaEmision" 
                                       name="fechaEmision" 
                                       value="{{ old('fechaEmision', $cuentaCobro->fecha_emision) }}"
                                       required>
                                @error('fechaEmision')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información del Beneficiario -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-user me-2"></i>Información del Beneficiario
                    </h3>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tipoDocumento" class="form-label required-field">Tipo de Documento</label>
                                <select class="form-control @error('tipoDocumento') is-invalid @enderror" 
                                        id="tipoDocumento" 
                                        name="tipoDocumento" 
                                        required>
                                    <option value="">Seleccionar...</option>
                                    <option value="CC" {{ old('tipoDocumento', $cuentaCobro->tipo_documento) == 'CC' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
                                    <option value="CE" {{ old('tipoDocumento', $cuentaCobro->tipo_documento) == 'CE' ? 'selected' : '' }}>Cédula de Extranjería</option>
                                    <option value="NIT" {{ old('tipoDocumento', $cuentaCobro->tipo_documento) == 'NIT' ? 'selected' : '' }}>NIT</option>
                                </select>
                                @error('tipoDocumento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="numeroDocumento" class="form-label required-field">Número de Documento</label>
                                <input type="text" 
                                       class="form-control @error('numeroDocumento') is-invalid @enderror" 
                                       id="numeroDocumento" 
                                       name="numeroDocumento" 
                                       value="{{ old('numeroDocumento', $cuentaCobro->numero_documento) }}"
                                       required>
                                @error('numeroDocumento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nombreBeneficiario" class="form-label required-field">Nombre Completo</label>
                                <input type="text" 
                                       class="form-control @error('nombreBeneficiario') is-invalid @enderror" 
                                       id="nombreBeneficiario" 
                                       name="nombreBeneficiario" 
                                       value="{{ old('nombreBeneficiario', $cuentaCobro->nombre_beneficiario) }}"
                                       required>
                                @error('nombreBeneficiario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telefonoBeneficiario" class="form-label">Teléfono</label>
                                <input type="text" 
                                       class="form-control @error('telefonoBeneficiario') is-invalid @enderror" 
                                       id="telefonoBeneficiario" 
                                       name="telefonoBeneficiario" 
                                       value="{{ old('telefonoBeneficiario', $cuentaCobro->telefono_beneficiario) }}">
                                @error('telefonoBeneficiario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="direccionBeneficiario" class="form-label">Dirección</label>
                                <input type="text" 
                                       class="form-control @error('direccionBeneficiario') is-invalid @enderror" 
                                       id="direccionBeneficiario" 
                                       name="direccionBeneficiario" 
                                       value="{{ old('direccionBeneficiario', $cuentaCobro->direccion_beneficiario) }}">
                                @error('direccionBeneficiario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Concepto y Período -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-file-alt me-2"></i>Concepto del Servicio
                    </h3>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="concepto" class="form-label required-field">Concepto</label>
                                <textarea class="form-control @error('concepto') is-invalid @enderror" 
                                          id="concepto" 
                                          name="concepto" 
                                          rows="4" 
                                          required>{{ old('concepto', $cuentaCobro->concepto) }}</textarea>
                                @error('concepto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="periodo" class="form-label required-field">Período</label>
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
                        </div>
                    </div>
                </div>

                <!-- Items de la Cuenta -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-list me-2"></i>Detalle de Items
                    </h3>

                    <div id="items-container">
        @php
            // CORREGIR ESTA PARTE:
            $items = $cuentaCobro->detalle_items ?? [];
            if (empty($items) || !is_array($items)) {
                $items = [['descripcion' => '', 'cantidad' => 1, 'valor_unitario' => 0, 'valor_total' => 0]];
            }
            
            // Si es string JSON, convertirlo a array
            if (is_string($items)) {
                $items = json_decode($items, true) ?? [];
            }
        @endphp

                        @foreach($items as $index => $item)
                        <div class="item-row border p-3 mb-3 rounded">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="mb-3">
                                        <label class="form-label required-field">Descripción</label>
                                        <input type="text" 
                                               class="form-control descripcion" 
                                               name="descripcion[]" 
                                               value="{{ $item['descripcion'] }}"
                                               placeholder="Descripción del servicio"
                                               required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label required-field">Cantidad</label>
                                        <input type="number" 
                                               class="form-control cantidad" 
                                               name="cantidad[]" 
                                               value="{{ $item['cantidad'] }}"
                                               min="1" 
                                               step="1"
                                               required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label required-field">Valor Unitario</label>
                                        <input type="number" 
                                               class="form-control valorUnitario" 
                                               name="valorUnitario[]" 
                                               value="{{ $item['valor_unitario'] }}"
                                               min="0" 
                                               step="0.01"
                                               required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Valor Total</label>
                                        <input type="number" 
                                               class="form-control valorTotal" 
                                               name="valorTotal[]" 
                                               value="{{ $item['valor_total'] }}"
                                               readonly
                                               class="bg-light">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="mb-3 d-flex align-items-end h-100">
                                        @if($index > 0)
                                        <button type="button" class="btn btn-danger btn-sm remove-item">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <button type="button" class="btn btn-success btn-sm" id="add-item">
                        <i class="fas fa-plus me-1"></i>Agregar Item
                    </button>

                    <!-- Totales -->
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="subtotal" class="form-label required-field">Subtotal</label>
                                <input type="number" 
                                       class="form-control @error('subtotal') is-invalid @enderror" 
                                       id="subtotal" 
                                       name="subtotal" 
                                       value="{{ old('subtotal', $cuentaCobro->subtotal) }}"
                                       step="0.01"
                                       required>
                                @error('subtotal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="iva" class="form-label required-field">IVA</label>
                                <input type="number" 
                                       class="form-control @error('iva') is-invalid @enderror" 
                                       id="iva" 
                                       name="iva" 
                                       value="{{ old('iva', $cuentaCobro->iva) }}"
                                       step="0.01"
                                       required>
                                @error('iva')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="total" class="form-label required-field">Total</label>
                                <input type="number" 
                                       class="form-control @error('total') is-invalid @enderror" 
                                       id="total" 
                                       name="total" 
                                       value="{{ old('total', $cuentaCobro->total) }}"
                                       step="0.01"
                                       required>
                                @error('total')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información Bancaria -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-university me-2"></i>Información Bancaria
                    </h3>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="banco" class="form-label required-field">Banco</label>
                                <input type="text" 
                                       class="form-control @error('banco') is-invalid @enderror" 
                                       id="banco" 
                                       name="banco" 
                                       value="{{ old('banco', $cuentaCobro->banco) }}"
                                       required>
                                @error('banco')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tipoCuenta" class="form-label required-field">Tipo de Cuenta</label>
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
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="numeroCuenta" class="form-label required-field">Número de Cuenta</label>
                                <input type="text" 
                                       class="form-control @error('numeroCuenta') is-invalid @enderror" 
                                       id="numeroCuenta" 
                                       name="numeroCuenta" 
                                       value="{{ old('numeroCuenta', $cuentaCobro->numero_cuenta) }}"
                                       required>
                                @error('numeroCuenta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="titularCuenta" class="form-label required-field">Titular de la Cuenta</label>
                                <input type="text" 
                                       class="form-control @error('titularCuenta') is-invalid @enderror" 
                                       id="titularCuenta" 
                                       name="titularCuenta" 
                                       value="{{ old('titularCuenta', $cuentaCobro->titular_cuenta) }}"
                                       required>
                                @error('titularCuenta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="form-section">
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('cuentas-cobro.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>
                                    Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>
                                    Actualizar Cuenta de Cobro
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let itemCount = {{ count($items) }};
    const container = document.getElementById('items-container');

    // Agregar nuevo item
    document.getElementById('add-item').addEventListener('click', function() {
        const newItem = `
            <div class="item-row border p-3 mb-3 rounded">
                <div class="row">
                    <div class="col-md-5">
                        <div class="mb-3">
                            <label class="form-label required-field">Descripción</label>
                            <input type="text" 
                                   class="form-control descripcion" 
                                   name="descripcion[]" 
                                   placeholder="Descripción del servicio"
                                   required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label class="form-label required-field">Cantidad</label>
                            <input type="number" 
                                   class="form-control cantidad" 
                                   name="cantidad[]" 
                                   value="1"
                                   min="1" 
                                   step="1"
                                   required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label class="form-label required-field">Valor Unitario</label>
                            <input type="number" 
                                   class="form-control valorUnitario" 
                                   name="valorUnitario[]" 
                                   value="0"
                                   min="0" 
                                   step="0.01"
                                   required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label class="form-label">Valor Total</label>
                            <input type="number" 
                                   class="form-control valorTotal" 
                                   name="valorTotal[]" 
                                   value="0"
                                   readonly
                                   class="bg-light">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="mb-3 d-flex align-items-end h-100">
                            <button type="button" class="btn btn-danger btn-sm remove-item">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', newItem);
        attachEventListeners();
    });

    // Eliminar item
    function attachEventListeners() {
        document.querySelectorAll('.remove-item').forEach(btn => {
            btn.addEventListener('click', function() {
                if (document.querySelectorAll('.item-row').length > 1) {
                    this.closest('.item-row').remove();
                    calculateTotals();
                } else {
                    alert('Debe haber al menos un item en la cuenta.');
                }
            });
        });

        // Calcular totales cuando cambian cantidad o valor
        document.querySelectorAll('.cantidad, .valorUnitario').forEach(input => {
            input.addEventListener('input', calculateTotals);
        });
    }

    // Calcular totales
    function calculateTotals() {
        let subtotal = 0;
        
        document.querySelectorAll('.item-row').forEach(row => {
            const cantidad = parseFloat(row.querySelector('.cantidad').value) || 0;
            const valorUnitario = parseFloat(row.querySelector('.valorUnitario').value) || 0;
            const valorTotal = cantidad * valorUnitario;
            
            // Actualizar valor total del item
            row.querySelector('.valorTotal').value = valorTotal.toFixed(2);
            
            subtotal += valorTotal;
        });

        // Actualizar subtotal en el formulario
        document.getElementById('subtotal').value = subtotal.toFixed(2);
        
        // Calcular IVA (19%)
        const iva = subtotal * 0.19;
        document.getElementById('iva').value = iva.toFixed(2);
        
        // Calcular total
        const total = subtotal + iva;
        document.getElementById('total').value = total.toFixed(2);
    }

    // Inicializar event listeners
    attachEventListeners();
    
    // Calcular totales iniciales
    calculateTotals();
});
</script>
@endpush