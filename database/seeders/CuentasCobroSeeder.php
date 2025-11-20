<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CrearCuentaCobro;
use Illuminate\Support\Facades\DB;

class CuentasCobroSeeder extends Seeder
{
    public function run()
    {
        // Deshabilitar restricciones de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Limpiar la tabla primero
        DB::table('crear_cuenta_cobros')->truncate();
        
        // Habilitar restricciones nuevamente
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Crear cuentas de cobro de ejemplo
        CrearCuentaCobro::create([
            'user_id' => 1,
            'nombre_alcaldia' => 'Alcaldía Municipal',
            'nit_alcaldia' => '800.123.456-7',
            'direccion_alcaldia' => 'Calle Principal #123',
            'telefono_alcaldia' => '6011234567',
            'ciudad_alcaldia' => 'Bogotá',
            'fecha_emision' => now(),
            
            // Datos del beneficiario
            'tipo_documento' => 'Cédula',
            'numero_documento' => '123456789',
            'nombre_beneficiario' => 'juan',
            'telefono_beneficiario' => '3001234567',
            'direccion_beneficiario' => 'Carrera 45 #26-85',
            
            // Datos de la cuenta
            'concepto' => 'Servicios de consultoría',
            'periodo' => 'Enero 2024',
            'detalle_items' => [
                [
                    'descripcion' => 'Horas de consultoría',
                    'cantidad' => 10,
                    'valor_unitario' => 150000,
                    'valor_total' => 1500000
                ]
            ],
            'subtotal' => 1500000,
            'iva' => 285000,
            'total' => 1785000,
            
            // Datos bancarios
            'banco' => 'Bancolombia',
            'tipo_cuenta' => 'Ahorros',
            'numero_cuenta' => '123456789',
            'titular_cuenta' => 'juan',
            
            'estado' => 'finalizada',
        ]);

        // Segunda cuenta de ejemplo
        CrearCuentaCobro::create([
            'user_id' => 2,
            'nombre_alcaldia' => 'Alcaldía Distrital',
            'nit_alcaldia' => '900.987.654-3',
            'direccion_alcaldia' => 'Avenida Central #456',
            'telefono_alcaldia' => '6019876543',
            'ciudad_alcaldia' => 'Medellín',
            'fecha_emision' => now()->subDays(15),
            
            'tipo_documento' => 'Cédula',
            'numero_documento' => '987654321',
            'nombre_beneficiario' => 'sanda',
            'telefono_beneficiario' => '3109876543',
            'direccion_beneficiario' => 'Calle 80 #12-34',
            
            'concepto' => 'Desarrollo de software',
            'periodo' => 'Febrero 2024',
            'detalle_items' => [
                [
                    'descripcion' => 'Desarrollo módulo principal',
                    'cantidad' => 1,
                    'valor_unitario' => 2500000,
                    'valor_total' => 2500000
                ],
                [
                    'descripcion' => 'Pruebas de calidad',
                    'cantidad' => 5,
                    'valor_unitario' => 200000,
                    'valor_total' => 1000000
                ]
            ],
            'subtotal' => 3500000,
            'iva' => 665000,
            'total' => 4165000,
            
            'banco' => 'Davivienda',
            'tipo_cuenta' => 'Corriente',
            'numero_cuenta' => '987654321',
            'titular_cuenta' => 'sanda',
            
            'estado' => 'aprobado',
        ]);

        // Tercera cuenta - pendiente
        CrearCuentaCobro::create([
            'user_id' => 3,
            'nombre_alcaldia' => 'Alcaldía Local',
            'nit_alcaldia' => '700.555.444-1',
            'direccion_alcaldia' => 'Diagonal 25 #45-67',
            'telefono_alcaldia' => '6015554444',
            'ciudad_alcaldia' => 'Cali',
            'fecha_emision' => now()->subDays(5),
            
            'tipo_documento' => 'Cédula',
            'numero_documento' => '555444333',
            'nombre_beneficiario' => 'carlos',
            'telefono_beneficiario' => '3205554444',
            'direccion_beneficiario' => 'Avenida 6N #23-45',
            
            'concepto' => 'Asesoría legal',
            'periodo' => 'Marzo 2024',
            'detalle_items' => [
                [
                    'descripcion' => 'Revisión de contratos',
                    'cantidad' => 8,
                    'valor_unitario' => 120000,
                    'valor_total' => 960000
                ]
            ],
            'subtotal' => 960000,
            'iva' => 182400,
            'total' => 1142400,
            
            'banco' => 'BBVA',
            'tipo_cuenta' => 'Ahorros',
            'numero_cuenta' => '555444333',
            'titular_cuenta' => 'carlos',
            
            'estado' => 'pendiente',
        ]);

        $this->command->info('✅ Cuentas de cobro de ejemplo creadas exitosamente.');
        $this->command->info('   - 1 cuenta FINALIZADA');
        $this->command->info('   - 1 cuenta APROBADA ');
        $this->command->info('   - 1 cuenta PENDIENTE');
    }
}