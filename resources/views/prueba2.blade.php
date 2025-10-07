<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Cuentas de Cobro - Alcaldía</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        
        header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 20px;
        }
        
        h1 {
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .logo {
            width: 120px;
            height: 120px;
            background-color: #2c3e50;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
        }
        
        .nav-tabs {
            display: flex;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }
        
        .nav-tab {
            padding: 10px 20px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-bottom: none;
            border-radius: 5px 5px 0 0;
            margin-right: 5px;
            cursor: pointer;
            font-weight: 600;
        }
        
        .nav-tab.active {
            background-color: #2c3e50;
            color: white;
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        .panel-section {
            margin-bottom: 25px;
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
        }
        
        .section-title {
            background-color: #2c3e50;
            color: white;
            padding: 10px 15px;
            margin: -20px -20px 20px -20px;
            border-radius: 5px 5px 0 0;
            font-size: 18px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #2c3e50;
        }
        
        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        
        textarea {
            height: 100px;
            resize: vertical;
        }
        
        .form-row {
            display: flex;
            gap: 15px;
        }
        
        .form-row .form-group {
            flex: 1;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        
        th {
            background-color: #f2f2f2;
            font-weight: 600;
        }
        
        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        
        .btn {
            background-color: #2c3e50;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: background-color 0.3s;
            margin-right: 5px;
        }
        
        .btn:hover {
            background-color: #1a252f;
        }
        
        .btn-generar {
            background-color: #27ae60;
            margin-right: 10px;
        }
        
        .btn-generar:hover {
            background-color: #219653;
        }
        
        .btn-limpiar {
            background-color: #e74c3c;
        }
        
        .btn-limpiar:hover {
            background-color: #c0392b;
        }
        
        .btn-editar {
            background-color: #3498db;
        }
        
        .btn-editar:hover {
            background-color: #2980b9;
        }
        
        .btn-eliminar {
            background-color: #e74c3c;
        }
        
        .btn-eliminar:hover {
            background-color: #c0392b;
        }
        
        .button-group {
            display: flex;
            justify-content: center;
            margin-top: 30px;
            gap: 15px;
        }
        
        .filter-bar {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        
        .filter-group {
            flex: 1;
        }
        
        .cuenta-card {
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #f9f9f9;
        }
        
        .cuenta-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .cuenta-title {
            font-weight: bold;
            color: #2c3e50;
        }
        
        .cuenta-status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .status-pendiente {
            background-color: #f39c12;
            color: white;
        }
        
        .status-aprobada {
            background-color: #27ae60;
            color: white;
        }
        
        .status-rechazada {
            background-color: #e74c3c;
            color: white;
        }
        
        .cuenta-details {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 10px;
            margin-bottom: 10px;
        }
        
        .detail-item {
            margin-bottom: 5px;
        }
        
        .detail-label {
            font-weight: 600;
            color: #2c3e50;
        }
        
        .cuenta-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        
        footer {
            text-align: center;
            margin-top: 30px;
            color: #7f8c8d;
            font-size: 14px;
        }
        
        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                gap: 0;
            }
            
            .container {
                padding: 15px;
            }
            
            .filter-bar {
                flex-direction: column;
            }
            
            .cuenta-details {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="logo-container">
                <div class="logo">ALCALDÍA</div>
            </div>
            <h1>PANEL DE CUENTAS DE COBRO</h1>
            <p>Sistema de gestión de cuentas de cobro para la alcaldía</p>
        </header>
        
        <div class="nav-tabs">
            <div class="nav-tab active" data-tab="panel">Panel de Cuentas</div>
            <div class="nav-tab" data-tab="formulario">Nueva Cuenta</div>
        </div>
        
        <!-- Panel de visualización de cuentas -->
        <div id="panel" class="tab-content active">
            <div class="panel-section">
                <div class="section-title">Filtros de Búsqueda</div>
                <div class="filter-bar">
                    <div class="filter-group">
                        <label for="filtroBeneficiario">Beneficiario</label>
                        <input type="text" id="filtroBeneficiario" placeholder="Buscar por nombre...">
                    </div>
                    <div class="filter-group">
                        <label for="filtroEstado">Estado</label>
                        <select id="filtroEstado">
                            <option value="">Todos</option>
                            <option value="pendiente">Pendiente</option>
                            <option value="aprobada">Aprobada</option>
                            <option value="rechazada">Rechazada</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="filtroFecha">Fecha</label>
                        <input type="date" id="filtroFecha">
                    </div>
                    <div class="filter-group" style="display: flex; align-items: flex-end;">
                        <button class="btn btn-generar" id="aplicarFiltros">Aplicar Filtros</button>
                    </div>
                </div>
            </div>
            
            <div class="panel-section">
                <div class="section-title">Cuentas de Cobro Registradas</div>
                <div id="listaCuentas">
                    <!-- Las cuentas se cargarán aquí dinámicamente -->
                </div>
            </div>
        </div>
        
        <!-- Formulario de creación de cuentas (existente) -->
        <div id="formulario" class="tab-content">
            <!-- Aquí va el formulario existente -->
            <form id="cuentaCobroForm">
                <div class="panel-section">
                    <div class="section-title">Información de la Alcaldía</div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nombreAlcaldia">Nombre de la Alcaldía</label>
                            <input type="text" id="nombreAlcaldia" name="nombreAlcaldia" required>
                        </div>
                        <div class="form-group">
                            <label for="nitAlcaldia">NIT</label>
                            <input type="text" id="nitAlcaldia" name="nitAlcaldia" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="direccionAlcaldia">Dirección</label>
                            <input type="text" id="direccionAlcaldia" name="direccionAlcaldia" required>
                        </div>
                        <div class="form-group">
                            <label for="telefonoAlcaldia">Teléfono</label>
                            <input type="tel" id="telefonoAlcaldia" name="telefonoAlcaldia" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="ciudadAlcaldia">Ciudad/Municipio</label>
                            <input type="text" id="ciudadAlcaldia" name="ciudadAlcaldia" required>
                        </div>
                        <div class="form-group">
                            <label for="fechaEmision">Fecha de Emisión</label>
                            <input type="date" id="fechaEmision" name="fechaEmision" required>
                        </div>
                    </div>
                </div>
                
                <div class="panel-section">
                    <div class="section-title">Información del Beneficiario</div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="tipoDocumento">Tipo de Documento</label>
                            <select id="tipoDocumento" name="tipoDocumento" required>
                                <option value="">Seleccione...</option>
                                <option value="cc">Cédula de Ciudadanía</option>
                                <option value="ce">Cédula de Extranjería</option>
                                <option value="nit">NIT</option>
                                <option value="pasaporte">Pasaporte</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="numeroDocumento">Número de Documento</label>
                            <input type="text" id="numeroDocumento" name="numeroDocumento" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nombreBeneficiario">Nombre Completo</label>
                            <input type="text" id="nombreBeneficiario" name="nombreBeneficiario" required>
                        </div>
                        <div class="form-group">
                            <label for="telefonoBeneficiario">Teléfono</label>
                            <input type="tel" id="telefonoBeneficiario" name="telefonoBeneficiario">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="direccionBeneficiario">Dirección</label>
                        <input type="text" id="direccionBeneficiario" name="direccionBeneficiario">
                    </div>
                </div>
                
                <div class="panel-section">
                    <div class="section-title">Concepto del Pago</div>
                    <div class="form-group">
                        <label for="concepto">Descripción del Servicio/Concepto</label>
                        <textarea id="concepto" name="concepto" placeholder="Describa detalladamente el servicio prestado o concepto por el cual se genera la cuenta de cobro..." required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="periodo">Periodo Facturado</label>
                        <input type="text" id="periodo" name="periodo" placeholder="Ej: Enero 2023" required>
                    </div>
                </div>
                
                <div class="panel-section">
                    <div class="section-title">Detalle de Valores</div>
                    <table id="tablaDetalle">
                        <thead>
                            <tr>
                                <th>Descripción</th>
                                <th>Cantidad</th>
                                <th>Valor Unitario</th>
                                <th>Valor Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" name="descripcion[]" placeholder="Descripción del ítem" required></td>
                                <td><input type="number" name="cantidad[]" min="1" value="1" required></td>
                                <td><input type="number" name="valorUnitario[]" min="0" step="0.01" placeholder="0.00" required></td>
                                <td><input type="number" name="valorTotal[]" min="0" step="0.01" placeholder="0.00" readonly></td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" id="agregarFila" class="btn" style="margin-top: 10px;">Agregar Ítem</button>
                    
                    <div class="form-row" style="margin-top: 20px;">
                        <div class="form-group">
                            <label for="subtotal">Subtotal</label>
                            <input type="number" id="subtotal" name="subtotal" step="0.01" readonly>
                        </div>
                        <div class="form-group">
                            <label for="iva">IVA (19%)</label>
                            <input type="number" id="iva" name="iva" step="0.01" readonly>
                        </div>
                        <div class="form-group">
                            <label for="total">Total a Pagar</label>
                            <input type="number" id="total" name="total" step="0.01" readonly>
                        </div>
                    </div>
                </div>
                
                <div class="panel-section">
                    <div class="section-title">Información Bancaria</div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="banco">Banco</label>
                            <input type="text" id="banco" name="banco" required>
                        </div>
                        <div class="form-group">
                            <label for="tipoCuenta">Tipo de Cuenta</label>
                            <select id="tipoCuenta" name="tipoCuenta" required>
                                <option value="">Seleccione...</option>
                                <option value="ahorros">Ahorros</option>
                                <option value="corriente">Corriente</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="numeroCuenta">Número de Cuenta</label>
                            <input type="text" id="numeroCuenta" name="numeroCuenta" required>
                        </div>
                        <div class="form-group">
                            <label for="titularCuenta">Titular de la Cuenta</label>
                            <input type="text" id="titularCuenta" name="titularCuenta" required>
                        </div>
                    </div>
                </div>
                
                <div class="button-group">
                    <button type="button" id="generarCuenta" class="btn btn-generar">Generar Cuenta de Cobro</button>
                    <button type="reset" class="btn btn-limpiar">Limpiar Formulario</button>
                </div>
            </form>
        </div>
        
        <footer>
            <p>© 2023 Alcaldía Municipal. Todos los derechos reservados.</p>
        </footer>
    </div>
    <a href="/dashboard">back</a>
    </body>
</html>