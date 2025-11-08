<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::table('documentos', function (Blueprint $table) {
        // si existe la columna ruta, elimínala
        if (Schema::hasColumn('documentos', 'ruta')) {
            $table->dropColumn('ruta');
        }

        // si NO existe "archivo", créalo
        if (!Schema::hasColumn('documentos', 'archivo')) {
            $table->string('archivo')->after('nombre');
        }
    });
}

public function down()
{
    Schema::table('documentos', function (Blueprint $table) {
        if (Schema::hasColumn('documentos', 'archivo')) {
            $table->dropColumn('archivo');
        }

        if (!Schema::hasColumn('documentos', 'ruta')) {
            $table->string('ruta')->after('nombre');
        }
    });
}

};