<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            
            // Relación con cuenta de cobro
            $table->foreignId('cuenta_cobro_id')
                ->constrained('crear_cuenta_cobros')
                ->onDelete('cascade');
            
            // Información del pago
            $table->enum('metodo_pago', [
                'cheque', 
                'transferencia', 
                'consignacion', 
                'pago_electronico'
            ])->comment('Método utilizado para el pago');
            
            $table->string('referencia')->unique()
                ->comment('Número de cheque, referencia de transferencia, etc.');
            
            $table->date('fecha_pago')
                ->comment('Fecha en que se realizó el pago');
            
            $table->decimal('monto', 15, 2)
                ->comment('Monto pagado');
            
            // Información adicional según método
            $table->string('banco_emisor')->nullable()
                ->comment('Banco desde donde se realizó el pago');
            
            $table->text('descripcion')->nullable()
                ->comment('Descripción o concepto del pago');
            
            $table->string('comprobante')->nullable()
                ->comment('Ruta del archivo comprobante de pago');
            
            $table->text('observaciones')->nullable()
                ->comment('Observaciones adicionales del pago');
            
            // Estado y seguimiento
            $table->enum('estado', [
                'procesado',
                'confirmado', 
                'pendiente',
                'rechazado'
            ])->default('procesado')
                ->comment('Estado del pago');
            
            // Usuario que procesó el pago
            $table->foreignId('procesado_por')
                ->constrained('users')
                ->comment('Usuario de tesorería que procesó el pago');
            
            $table->timestamps();
            
            // Índices para mejorar consultas
            $table->index('fecha_pago');
            $table->index('metodo_pago');
            $table->index('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};