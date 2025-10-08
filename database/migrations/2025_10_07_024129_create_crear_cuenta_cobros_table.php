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
        Schema::create('cuentas_cobro', function (Blueprint $table) {
            $table->id();
            
            // Información de la Alcaldía
            $table->string('nombre_alcaldia');
            $table->string('nit_alcaldia');
            $table->string('direccion_alcaldia');
            $table->string('telefono_alcaldia');
            $table->string('ciudad_alcaldia');
            $table->date('fecha_emision');
            
            // Información del Contratista
            $table->string('tipo_documento');
            $table->string('numero_documento');
            $table->string('nombre_beneficiario');
            $table->string('telefono_beneficiario')->nullable();
            $table->string('direccion_beneficiario')->nullable();
            
            // Concepto del Pago
            $table->text('concepto');
            $table->string('periodo');
            
            // Detalle de Valores (guardado como JSON)
            $table->json('detalle_items');
            
            // Totales
            $table->decimal('subtotal', 15, 2);
            $table->decimal('iva', 15, 2);
            $table->decimal('total', 15, 2);
            
            // Información Bancaria
            $table->string('banco');
            $table->string('tipo_cuenta');
            $table->string('numero_cuenta');
            $table->string('titular_cuenta');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuentas_cobro');
    }
    
};