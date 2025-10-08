<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class CrearCuentaCobro extends Model
    {
        use HasFactory;

        // Nombre de la tabla
        protected $table = 'cuentas_cobro';

        // Campos que se pueden llenar masivamente
        protected $fillable = [
            'nombre_alcaldia',
            'nit_alcaldia',
            'direccion_alcaldia',
            'telefono_alcaldia',
            'ciudad_alcaldia',
            'fecha_emision',
            'tipo_documento',
            'numero_documento',
            'nombre_beneficiario',
            'telefono_beneficiario',
            'direccion_beneficiario',
            'concepto',
            'periodo',
            'detalle_items',
            'subtotal',
            'iva',
            'total',
            'banco',
            'tipo_cuenta',
            'numero_cuenta',
            'titular_cuenta',
        ];

        // Campos que deben ser convertidos a tipos específicos
        protected $casts = [
            'fecha_emision' => 'date',
            'detalle_items' => 'array', // Convierte JSON a array automáticamente
            'subtotal' => 'decimal:2',
            'iva' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }