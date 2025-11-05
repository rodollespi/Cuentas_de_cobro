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
        'observaciones',
        'supervisor_id',
        'fecha_revision',
    ];

    protected $casts = [
        'detalle_items' => 'array',
        'fecha_emision' => 'date',
        'fecha_revision' => 'datetime',
        'subtotal' => 'decimal:2',
        'iva' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    // ✅ AGREGAR ESTOS MÉTODOS
    /**
     * Obtener detalle_items siempre como array
     */
    public function getDetalleItemsAttribute($value)
    {
        // Si es null, retornar array vacío
        if (is_null($value)) {
            return [];
        }

        // Si ya es array, retornarlo
        if (is_array($value)) {
            return $value;
        }

        // Si es string JSON, decodificarlo
        $decoded = json_decode($value, true);
        
        // Retornar array decodificado o array vacío si falla
        return is_array($decoded) ? $decoded : [];
    }

    /**
     * Guardar detalle_items como JSON
     */
    public function setDetalleItemsAttribute($value)
    {
        if (is_null($value)) {
            $this->attributes['detalle_items'] = null;
            return;
        }

        if (is_array($value)) {
            $this->attributes['detalle_items'] = json_encode($value);
            return;
        }

        $this->attributes['detalle_items'] = $value;
    }

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'cuenta_cobro_id');
    }

    // Scopes
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