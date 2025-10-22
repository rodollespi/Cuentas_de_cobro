<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('crear_cuenta_cobros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Datos de la alcaldía
            $table->string('nombre_alcaldia');
            $table->string('nit_alcaldia');
            $table->string('direccion_alcaldia');
            $table->string('telefono_alcaldia');
            $table->string('ciudad_alcaldia');
            $table->date('fecha_emision');
            
            // Datos del beneficiario
            $table->string('tipo_documento');
            $table->string('numero_documento');
            $table->string('nombre_beneficiario');
            $table->string('telefono_beneficiario')->nullable();
            $table->string('direccion_beneficiario')->nullable();
            
            // Datos de la cuenta de cobro
            $table->text('concepto');
            $table->string('periodo');
            $table->json('detalle_items')->nullable();
            $table->decimal('subtotal', 15, 2);
            $table->decimal('iva', 15, 2);
            $table->decimal('total', 15, 2);
            
            // Datos bancarios
            $table->string('banco');
            $table->string('tipo_cuenta');
            $table->string('numero_cuenta');
            $table->string('titular_cuenta');
            
            // Estados y auditoría
            $table->string('estado')->default('pendiente');
            $table->text('observaciones')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('crear_cuenta_cobros');
    }
};