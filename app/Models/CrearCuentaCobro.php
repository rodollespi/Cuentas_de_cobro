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
        'documentos_asociados', 
    ];

    protected $casts = [
        'detalle_items' => 'array',
        'documentos_asociados' => 'array',
        'fecha_emision' => 'date',
        'subtotal' => 'decimal:2',
        'iva' => 'decimal:2',
        'total' => 'decimal:2'
    ];
    /**
     * Obtener detalle_items siempre como array
     */
    public function getDetalleItemsAttribute($value)
    {
        if (is_null($value)) {
            return [];
        }

        if (is_array($value)) {
            return $value;
        }

        $decoded = json_decode($value, true);
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

    /**
     * Obtener documentos_asociados siempre como array
     */
    public function getDocumentosAsociadosAttribute($value)
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
     * Guardar documentos_asociados como JSON
     */
    public function setDocumentosAsociadosAttribute($value)
    {
        if (is_null($value)) {
            $this->attributes['documentos_asociados'] = null;
            return;
        }

        if (is_array($value)) {
            $this->attributes['documentos_asociados'] = json_encode($value);
            return;
        }

        $this->attributes['documentos_asociados'] = $value;
    }

    /**
     * Obtener los documentos reales del modelo Documento
     */
    public function documentosReales()
    {
        $documentosIds = collect($this->documentos_asociados)->pluck('id')->toArray();
        return \App\Models\Documento::whereIn('id', $documentosIds)->get();
    }

    /**
     * Verificar si tiene documentos asociados
     */
    public function tieneDocumentos()
    {
        return !empty($this->documentos_asociados);
    }

    /**
     * Obtener nombres de documentos como string
     */
    public function getNombresDocumentosAttribute()
    {
        if (!$this->tieneDocumentos()) {
            return 'Sin documentos';
        }

        return collect($this->documentos_asociados)
            ->pluck('nombre')
            ->implode(', ');
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

    /**
     * Scope para cuentas con documentos asociados
     */
    public function scopeConDocumentos($query)
    {
        return $query->whereNotNull('documentos_asociados')
                    ->where('documentos_asociados', '!=', '[]');
    }

    /**
     * Scope para cuentas sin documentos
     */
    public function scopeSinDocumentos($query)
    {
        return $query->whereNull('documentos_asociados')
                    ->orWhere('documentos_asociados', '[]');
    }
}