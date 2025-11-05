<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrearCuentaCobro extends Model
{
    use HasFactory;

    protected $table = 'crear_cuenta_cobros';

    // 🔹 Campos que se pueden llenar en masa
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

        // Campos de control de flujo
        'estado',         // pendiente, aprobado, rechazado, finalizado
        'observaciones',  // observaciones del supervisor o alcalde
        'supervisor_id',  // quién revisó la cuenta
        'fecha_revision', // cuándo la revisó
    ];

    // 
    protected $casts = [
        'detalle_items' => 'array',
        'fecha_emision' => 'date',
        'fecha_revision' => 'datetime',
        'subtotal' => 'decimal:2',
        'iva' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    // 🔹 Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔹 Relación con supervisor (usuario con rol de supervisor)
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    // 🔹 Scopes para filtrar fácilmente en controladores
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeAprobadas($query)
    {
        return $query->where('estado', 'aprobado');
    }

    public function scopeRechazadas($query)
    {
        return $query->where('estado', 'rechazado');
    }

    public function scopeFinalizadas($query)
    {
        return $query->where('estado', 'finalizado');
    }
}
