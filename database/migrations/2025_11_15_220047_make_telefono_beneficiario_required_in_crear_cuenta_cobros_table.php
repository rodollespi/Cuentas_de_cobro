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
        Schema::table('crear_cuenta_cobros', function (Blueprint $table) {
            $table->string('telefono_beneficiario')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('crear_cuenta_cobros', function (Blueprint $table) {
            $table->string('telefono_beneficiario')->nullable()->change();
        });
    }
};
