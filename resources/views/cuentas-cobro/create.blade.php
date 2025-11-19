@extends('layouts.app')

@section('title', 'Crear Cuenta de Cobro - CuentasCobro')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-plus-circle me-2"></i>
                        Crear Nueva Cuenta de Cobro
                    </h1>
                    <p class="text-muted mb-0">Complete todos los campos requeridos para generar la cuenta de cobro</p>
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
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body">
                    <form action="{{ route('cuentas-cobro.store') }}" method="POST" enctype="multipart/form-data" id="cuentaCobroForm">
                        @csrf

                        <!-- Sección de Adjuntar Documentos -->
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-paperclip text-primary me-2"></i>
                                Adjuntar Documentos de Soporte
                            </h5>
                            
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Adjunta los documentos</strong> que respalden esta cuenta de cobro (PDF, JPG, PNG). Puedes seleccionar varios archivos a la vez.
                            </div>

                            <div id="documentos-container">
                                <div class="documento-item mb-3 p-3 border rounded bg-light">
                                    <div class="row align-items-end">
                                        <div class="col-md-5 mb-2">
                                            <label class="form-label">Tipo de Documento</label>
                                            <select name="tipo_documento[]" class="form-control tipo-documento">
                                                <option value="">Seleccione un tipo</option>
                                                <optgroup label="Documentos Jurídicos">
                                                    <option value="Cédula del Representante Legal">Cédula del Representante Legal</option>
                                                    <option value="RUT">RUT</option>
                                                    <option value="Certificado de Existencia y Representación Legal">Certificado de Existencia y Representación Legal</option>
                                                    <option value="Registro Único de Proponentes (RUP)">Registro Único de Proponentes (RUP)</option>
                                                    <option value="Antecedentes Disciplinarios">Antecedentes Disciplinarios</option>
                                                    <option value="Responsabilidad Fiscal">Responsabilidad Fiscal</option>
                                                    <option value="Antecedentes Judiciales">Antecedentes Judiciales</option>
                                                    <option value="Hoja de Vida">Hoja de Vida</option>
                                                </optgroup>
                                                <optgroup label="Documentos Financieros">
                                                    <option value="Estados Financieros">Estados Financieros</option>
                                                    <option value="Declaración de Renta">Declaración de Renta</option>
                                                    <option value="Certificación Bancaria">Certificación Bancaria</option>
                                                    <option value="Formato Único de Ingresos">Formato Único de Ingresos</option>
                                                </optgroup>
                                                <optgroup label="Documentos de Experiencia">
                                                    <option value="Contratos Ejecutados">Contratos Ejecutados</option>
                                                    <option value="Certificaciones de Experiencia">Certificaciones de Experiencia</option>
                                                    <option value="Soportes de Experiencia">Soportes de Experiencia</option>
                                                </optgroup>
                                                <optgroup label="Documentos Técnicos">
                                                    <option value="Propuesta Técnica">Propuesta Técnica</option>
                                                    <option value="Propuesta Económica">Propuesta Económica</option>
                                                    <option value="Cronograma">Cronograma</option>
                                                    <option value="Ficha Técnica">Ficha Técnica</option>
                                                </optgroup>
                                                <optgroup label="Otros">
                                                    <option value="Seguro de Cumplimiento">Seguro de Cumplimiento</option>
                                                    <option value="Pago Seguridad Social">Pago Seguridad Social</option>
                                                    <option value="Pólizas">Pólizas</option>
                                                    <option value="Cámara de Comercio">Cámara de Comercio</option>
                                                    <option value="Otros">Otros</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">Archivo (PDF, JPG, PNG)</label>
                                            <input type="file" name="archivos[]" class="form-control archivo-input" accept=".pdf,.jpg,.jpeg,.png">
                                            <small class="text-muted archivo-nombre"></small>
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            <button type="button" class="btn btn-danger btn-sm remove-documento w-100" disabled>
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="button" class="btn btn-outline-primary btn-sm" id="add-documento">
                                <i class="fas fa-plus me-2"></i>
                                Agregar Otro Documento
                            </button>
                        </div>

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
                                           value="{{ old('nombreAlcaldia') }}"
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
                                           value="{{ old('nitAlcaldia') }}"
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
                                           value="{{ old('direccionAlcaldia') }}"
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
                                           value="{{ old('telefonoAlcaldia') }}"
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
                                           value="{{ old('ciudadAlcaldia') }}"
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
                                           value="{{ old('fechaEmision', date('Y-m-d')) }}"
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
                                           value="{{ old('nombreBeneficiario', auth()->user()->name) }}"
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
                                        <option value="Cédula" {{ old('tipoDocumento') == 'Cédula' ? 'selected' : '' }}>Cédula</option>
                                        <option value="NIT" {{ old('tipoDocumento') == 'NIT' ? 'selected' : '' }}>NIT</option>
                                        <option value="Pasaporte" {{ old('tipoDocumento') == 'Pasaporte' ? 'selected' : '' }}>Pasaporte</option>
                                        <option value="Cédula Extranjería" {{ old('tipoDocumento') == 'Cédula Extranjería' ? 'selected' : '' }}>Cédula Extranjería</option>
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
                                           value="{{ old('numeroDocumento') }}"
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
                                           value="{{ old('telefonoBeneficiario') }}"
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
                                           value="{{ old('direccionBeneficiario') }}"
                                           placeholder="Dirección completa">
                                    @error('direccionBeneficiario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Concepto y Período -->
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-file-alt text-primary me-2"></i>
                                Concepto y Período
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
                                           value="{{ old('periodo') }}"
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
                                              required>{{ old('concepto') }}</textarea>
                                    @error('concepto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Items de la Cuenta de Cobro -->
                        <div class="mb-4">  
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-list text-primary me-2"></i>
                                Detalle de Items
                            </h5>
                            <div id="items-container">
                                <div class="item-row mb-3 p-3 border rounded">
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
                                            <button type="button" class="btn btn-danger btn-sm remove-item" disabled>
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary btn-sm" id="add-item">
                                <i class="fas fa-plus me-2"></i>
                                Agregar Item
                            </button>
                        </div>

                        <!-- Valores Totales -->
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-calculator text-primary me-2"></i>
                                Valores Totales
                            </h5>
                            
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
                                               value="{{ old('subtotal', 0) }}"
                                               placeholder="0.00"
                                               step="0.01"
                                               min="0"
                                               readonly
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
                                               value="{{ old('iva', 0) }}"
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
                                               value="{{ old('total', 0) }}"
                                               placeholder="0.00"
                                               step="0.01"
                                               min="0"
                                               readonly
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
                                           value="{{ old('banco') }}"
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
                                        <option value="Ahorros" {{ old('tipoCuenta') == 'Ahorros' ? 'selected' : '' }}>Ahorros</option>
                                        <option value="Corriente" {{ old('tipoCuenta') == 'Corriente' ? 'selected' : '' }}>Corriente</option>
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
                                           value="{{ old('numeroCuenta') }}"
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
                                           value="{{ old('titularCuenta', auth()->user()->name) }}"
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
                            <button type="submit" class="btn btn-success" id="submitBtn">
                                <i class="fas fa-save me-2"></i>
                                Crear Cuenta de Cobro
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
    const documentosContainer = document.getElementById('documentos-container');
    const addDocumentoBtn = document.getElementById('add-documento');
    
    // ========== FUNCIONES PARA DOCUMENTOS ==========
    
    // Agregar nuevo documento
    addDocumentoBtn.addEventListener('click', function() {
        const newDocumento = document.createElement('div');
        newDocumento.className = 'documento-item mb-3 p-3 border rounded bg-light';
        newDocumento.innerHTML = `
            <div class="row align-items-end">
                <div class="col-md-5 mb-2">
                    <label class="form-label">Tipo de Documento</label>
                    <select name="tipo_documento[]" class="form-control tipo-documento">
                        <option value="">Seleccione un tipo</option>
                        <optgroup label="Documentos Jurídicos">
                            <option value="Cédula del Representante Legal">Cédula del Representante Legal</option>
                            <option value="RUT">RUT</option>
                            <option value="Certificado de Existencia y Representación Legal">Certificado de Existencia y Representación Legal</option>
                            <option value="Registro Único de Proponentes (RUP)">Registro Único de Proponentes (RUP)</option>
                            <option value="Antecedentes Disciplinarios">Antecedentes Disciplinarios</option>
                            <option value="Responsabilidad Fiscal">Responsabilidad Fiscal</option>
                            <option value="Antecedentes Judiciales">Antecedentes Judiciales</option>
                            <option value="Hoja de Vida">Hoja de Vida</option>
                        </optgroup>
                        <optgroup label="Documentos Financieros">
                            <option value="Estados Financieros">Estados Financieros</option>
                            <option value="Declaración de Renta">Declaración de Renta</option>
                            <option value="Certificación Bancaria">Certificación Bancaria</option>
                            <option value="Formato Único de Ingresos">Formato Único de Ingresos</option>
                        </optgroup>
                        <optgroup label="Documentos de Experiencia">
                            <option value="Contratos Ejecutados">Contratos Ejecutados</option>
                            <option value="Certificaciones de Experiencia">Certificaciones de Experiencia</option>
                            <option value="Soportes de Experiencia">Soportes de Experiencia</option>
                        </optgroup>
                        <optgroup label="Documentos Técnicos">
                            <option value="Propuesta Técnica">Propuesta Técnica</option>
                            <option value="Propuesta Económica">Propuesta Económica</option>
                            <option value="Cronograma">Cronograma</option>
                            <option value="Ficha Técnica">Ficha Técnica</option>
                        </optgroup>
                        <optgroup label="Otros">
                            <option value="Seguro de Cumplimiento">Seguro de Cumplimiento</option>
                            <option value="Pago Seguridad Social">Pago Seguridad Social</option>
                            <option value="Pólizas">Pólizas</option>
                            <option value="Cámara de Comercio">Cámara de Comercio</option>
                            <option value="Otros">Otros</option>
                        </optgroup>
                    </select>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label">Archivo (PDF, JPG, PNG)</label>
                    <input type="file" name="archivos[]" class="form-control archivo-input" accept=".pdf,.jpg,.jpeg,.png">
                    <small class="text-muted archivo-nombre"></small>
                </div>
                <div class="col-md-1 mb-2">
                    <button type="button" class="btn btn-danger btn-sm remove-documento w-100">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `;
        documentosContainer.appendChild(newDocumento);
        
        // Agregar event listener para mostrar nombre del archivo
        const archivoInput = newDocumento.querySelector('.archivo-input');
        archivoInput.addEventListener('change', mostrarNombreArchivo);
        
        updateRemoveDocumentosButtons();
    });
    
    // Mostrar nombre del archivo seleccionado
    function mostrarNombreArchivo(e) {
        const input = e.target;
        const nombreSpan = input.parentElement.querySelector('.archivo-nombre');
        if (input.files.length > 0) {
            nombreSpan.textContent = '📎 ' + input.files[0].name;
        } else {
            nombreSpan.textContent = '';
        }
    }
    
    // Event listeners iniciales para archivos
    document.querySelectorAll('.archivo-input').forEach(input => {
        input.addEventListener('change', mostrarNombreArchivo);
    });
    
    // Eliminar documento
    documentosContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-documento') || e.target.closest('.remove-documento')) {
            const btn = e.target.classList.contains('remove-documento') ? e.target : e.target.closest('.remove-documento');
            if (!btn.disabled) {
                btn.closest('.documento-item').remove();
                updateRemoveDocumentosButtons();
            }
        }
    });
    
    // Actualizar botones de eliminar documentos
    function updateRemoveDocumentosButtons() {
        const documentos = document.querySelectorAll('.documento-item');
        const removeButtons = document.querySelectorAll('.remove-documento');
        
        removeButtons.forEach(btn => {
            btn.disabled = documentos.length <= 1;
        });
    }
    
    // ========== FUNCIONES PARA ITEMS ==========
    
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
        
        updateRemoveButtons();
    });
    
    // Calcular valores de items
    function calcularValores() {
        let subtotalGeneral = 0;
        
        document.querySelectorAll('.item-row').forEach(row => {
            const cantidad = parseFloat(row.querySelector('.cantidad').value) || 0;
            const valorUnitario = parseFloat(row.querySelector('.valor-unitario').value) || 0;
            const valorTotal = cantidad * valorUnitario;
            
            row.querySelector('.valor-total').value = valorTotal.toFixed(2);
            subtotalGeneral += valorTotal;
        });
        
        document.getElementById('subtotal').value = subtotalGeneral.toFixed(2);
        calcularTotalGeneral();
    }
    
    // Calcular total general (subtotal + IVA)
    function calcularTotalGeneral() {
        const subtotal = parseFloat(document.getElementById('subtotal').value) || 0;
        const iva = parseFloat(document.getElementById('iva').value) || 0;
        const total = subtotal + iva;
        
        document.getElementById('total').value = total.toFixed(2);
    }
    
    // Actualizar botones de eliminar items
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
    
    // Inicializar
    calcularValores();
    updateRemoveButtons();
    updateRemoveDocumentosButtons();
});
</script>
@endpush

@push('styles')
<style>
    .item-row {
        background-color: #f8f9fa;
    }
    .documento-item {
        background-color: #f8f9fc;
        transition: all 0.3s ease;
    }
    .documento-item:hover {
        background-color: #e9ecf5;
    }
    .form-label {
        font-weight: 500;
        font-size: 0.875rem;
    }
    .archivo-nombre {
        display: block;
        margin-top: 0.25rem;
        font-size: 0.8rem;
        color: #28a745;
    }
</style>
@endpush
@endsection