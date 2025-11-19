<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDocumentosAsociadosToCrearCuentaCobrosTable extends Migration
{
    public function up()
    {
        Schema::table('crear_cuenta_cobros', function (Blueprint $table) {
            $table->json('documentos_asociados')->nullable()->after('estado');
        });
    }

    public function down()
    {
        Schema::table('crear_cuenta_cobros', function (Blueprint $table) {
            $table->dropColumn('documentos_asociados');
        });
    }
}