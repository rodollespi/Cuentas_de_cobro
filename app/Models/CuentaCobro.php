<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CuentaCobro extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cuentas_cobro';

    protected $fillable = [
        'numero_cuenta',
        'contratista_id',
        'numero_contrato',
        'objeto_contrato',
        'periodo_inicio',
        'periodo_fin',
        'valor_total',
        'descripcion_actividades',
        'estado',
        'observaciones',
        'documento_cuenta',
        'documento_soporte',
        'revisado_por',
        'fecha_revision',
        'aprobado_por',
        'fecha_aprobacion',
        'fecha_pago',
    ];

    protected $casts = [
        'periodo_inicio' => 'date',
        'periodo_fin' => 'date',
        'valor_total' => 'decimal:2',
        'fecha_revision' => 'datetime',
        'fecha_aprobacion' => 'datetime',
        'fecha_pago' => 'datetime',
    ];

    /**
     * Relación con el contratista (usuario)
     */
    public function contratista()
    {
        return $this->belongsTo(User::class, 'contratista_id');
    }

    /**
     * Relación con el revisor (usuario)
     */
    public function revisor()
    {
        return $this->belongsTo(User::class, 'revisado_por');
    }

    /**
     * Relación con el aprobador (usuario)
     */
    public function aprobador()
    {
        return $this->belongsTo(User::class, 'aprobado_por');
    }

    /**
     * Generar número de cuenta automáticamente
     */
    public static function generarNumeroCuenta()
    {
        $year = date('Y');
        $ultimaCuenta = self::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        $numero = $ultimaCuenta ? intval(substr($ultimaCuenta->numero_cuenta, -4)) + 1 : 1;
        
        return 'CC-' . $year . '-' . str_pad($numero, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Obtener clase de badge según el estado
     */
    public function getEstadoBadgeClass()
    {
        return match($this->estado) {
            'borrador' => 'bg-secondary',
            'enviada' => 'bg-info',
            'en_revision' => 'bg-warning',
            'aprobada' => 'bg-success',
            'rechazada' => 'bg-danger',
            'pagada' => 'bg-primary',
            default => 'bg-secondary',
        };
    }

    /**
     * Obtener texto del estado
     */
    public function getEstadoTexto()
    {
        return match($this->estado) {
            'borrador' => 'Borrador',
            'enviada' => 'Enviada',
            'en_revision' => 'En Revisión',
            'aprobada' => 'Aprobada',
            'rechazada' => 'Rechazada',
            'pagada' => 'Pagada',
            default => 'Desconocido',
        };
    }

    /**
     * Scope para filtrar por contratista
     */
    public function scopeDeContratista($query, $contratistaId)
    {
        return $query->where('contratista_id', $contratistaId);
    }

    /**
     * Scope para filtrar por estado
     */
    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }
}