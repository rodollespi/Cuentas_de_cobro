<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CrearCuentaCobro;
use App\Models\User;

class CuentasCobroSeeder extends Seeder
{
    public function run()
    {
        $user = User::whereHas('role', function($query) {
            $query->where('name', 'contratista');
        })->first();

        if ($user) {
            CrearCuentaCobro::create([
                'user_id' => $user->id,
                'nombre_alcaldia' => 'Alcaldía Municipal',
                'nit_alcaldia' => '800.123.456-7',
                'direccion_alcaldia' => 'Calle Principal #123',
                'telefono_alcaldia' => '6011234567',
                'ciudad_alcaldia' => 'Bogotá',
                'fecha_emision' => now(),
                'tipo_documento' => 'Cédula',
                'numero_documento' => '123456789',
                'nombre_beneficiario' => $user->name,
                'concepto' => 'Servicios de consultoría',
                'periodo' => 'Enero 2024',
                'detalle_items' => json_encode([
                    ['descripcion' => 'Horas de consultoría', 'cantidad' => 10, 'valor_unitario' => 150000, 'valor_total' => 1500000]
                ]),
                'subtotal' => 1500000,
                'iva' => 285000,
                'total' => 1785000,
                'banco' => 'Bancolombia',
                'tipo_cuenta' => 'Ahorros',
                'numero_cuenta' => '123456789',
                'titular_cuenta' => $user->name,
                'estado' => 'finalizado',
            ]);
        }
        $this->command->info('Cuenta de cobro creada exitosamente.');
    }
}