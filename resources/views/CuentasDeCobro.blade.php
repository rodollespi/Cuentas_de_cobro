<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta de Cobro - Alcaldía</title>
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
            max-width: 1000px;
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
        
        .form-section {
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
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s;
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
        
        .button-group {
            display: flex;
            justify-content: center;
            margin-top: 30px;
            gap: 15px;
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
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>CUENTA DE COBRO</h1>
            <p>Formulario oficial para la generación de cuentas de cobro</p>
        </header>
        
        <form id="cuentaCobroForm" method="POST" action="{{route('crearCuentaCobro.almacenar')}}">
            @csrf
            <div class="form-section">
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
            
            <div class="form-section">
                <div class="section-title">Información del Contratista</div>
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
            
            <div class="form-section">
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
            
            <div class="form-section">
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
            
            <div class="form-section">
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
                <button type="submit" value = "Create" class="btn btn-generar">Generar Cuenta de Cobro</button>
                <button type="reset" class="btn btn-limpiar">Limpiar Formulario</button>
                <a href="/dashboard"><button type="button" class="btn btn-limpiar">Volver</button>   </a>
            </div>
        </form>
        
        <footer>
            <p>© 2023 Alcaldía Municipal. Todos los derechos reservados.</p>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Establecer fecha actual como fecha de emisión
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('fechaEmision').value = today;
            
            // Agregar nueva fila a la tabla de detalles
            document.getElementById('agregarFila').addEventListener('click', function() {
                const tabla = document.getElementById('tablaDetalle').getElementsByTagName('tbody')[0];
                const nuevaFila = tabla.insertRow();
                
                nuevaFila.innerHTML = `
                    <td><input type="text" name="descripcion[]" placeholder="Descripción del ítem" required></td>
                    <td><input type="number" name="cantidad[]" min="1" value="1" required></td>
                    <td><input type="number" name="valorUnitario[]" min="0" step="0.01" placeholder="0.00" required></td>
                    <td><input type="number" name="valorTotal[]" min="0" step="0.01" placeholder="0.00" readonly></td>
                `;
                
                // Agregar eventos a los nuevos inputs
                agregarEventosCalculo(nuevaFila);
            });
            
            // Calcular totales cuando cambian los valores
            function agregarEventosCalculo(fila) {
                const cantidadInput = fila.querySelector('input[name="cantidad[]"]');
                const valorUnitarioInput = fila.querySelector('input[name="valorUnitario[]"]');
                const valorTotalInput = fila.querySelector('input[name="valorTotal[]"]');
                
                function calcularTotalFila() {
                    const cantidad = parseFloat(cantidadInput.value) || 0;
                    const valorUnitario = parseFloat(valorUnitarioInput.value) || 0;
                    const total = cantidad * valorUnitario;
                    valorTotalInput.value = total.toFixed(2);
                    calcularTotales();
                }
                
                cantidadInput.addEventListener('input', calcularTotalFila);
                valorUnitarioInput.addEventListener('input', calcularTotalFila);
            }
            
            // Agregar eventos a la fila inicial
            const filaInicial = document.querySelector('#tablaDetalle tbody tr');
            agregarEventosCalculo(filaInicial);
            
            // Calcular totales generales
            function calcularTotales() {
                let subtotal = 0;
                const filas = document.querySelectorAll('#tablaDetalle tbody tr');
                
                filas.forEach(fila => {
                    const valorTotal = parseFloat(fila.querySelector('input[name="valorTotal[]"]').value) || 0;
                    subtotal += valorTotal;
                });
                
                const iva = subtotal * 0.19;
                const total = subtotal + iva;
                
                document.getElementById('subtotal').value = subtotal.toFixed(2);
                document.getElementById('iva').value = iva.toFixed(2);
                document.getElementById('total').value = total.toFixed(2);
            }
            
        
        });
    </script>
    
</body>
</html>