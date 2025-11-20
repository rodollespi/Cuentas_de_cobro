<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('crear_cuenta_cobros', function (Blueprint $table) {
            $table->string('telefono_beneficiario', 20)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('crear_cuenta_cobros', function (Blueprint $table) {
            $table->string('telefono_beneficiario', 20)->nullable(false)->change();
        });
    }
};