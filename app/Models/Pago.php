<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pagos';

    protected $fillable = [
        'cuenta_cobro_id',
        'metodo_pago',
        'referencia',
        'fecha_pago',
        'monto',
        'banco_emisor',
        'descripcion',
        'comprobante',
        'observaciones',
        'estado',
        'procesado_por',
    ];

    protected $casts = [
        'fecha_pago' => 'datetime',
        'monto' => 'decimal:2',
    ];

    /**
     * Relación con CuentaCobro
     */
    public function cuentaCobro()
    {
        return $this->belongsTo(CrearCuentaCobro::class, 'cuenta_cobro_id');
    }

    /**
     * Relación con el usuario que procesó el pago
     */
    public function procesadoPor()
    {
        return $this->belongsTo(User::class, 'procesado_por');
    }

    /**
     * Obtener el nombre del método de pago formateado
     */
    public function getMetodoPagoFormateadoAttribute()
    {
        $metodos = [
            'cheque' => 'Cheque',
            'transferencia' => 'Transferencia Bancaria',
            'consignacion' => 'Consignación',
            'pago_electronico' => 'Pago Electrónico',
        ];

        return $metodos[$this->metodo_pago] ?? $this->metodo_pago;
    }

    /**
     * Obtener el badge de estado
     */
    public function getEstadoBadgeAttribute()
    {
        $badges = [
            'procesado' => 'bg-success',
            'confirmado' => 'bg-info',
            'pendiente' => 'bg-warning',
            'rechazado' => 'bg-danger',
        ];

        return $badges[$this->estado] ?? 'bg-secondary';
    }
}