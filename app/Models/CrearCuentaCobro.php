<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrearCuentaCobro extends Model
{
    use HasFactory;

    protected $table = 'crear_cuenta_cobros';

    protected $fillable = [
        'user_id',
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
        'estado',
        'observaciones'
    ];

    protected $casts = [
        'detalle_items' => 'array',
        'fecha_emision' => 'date',
        'subtotal' => 'decimal:2',
        'iva' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}