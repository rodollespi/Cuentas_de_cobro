<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('crear_cuenta_cobros', function (Blueprint $table) {
            $table->unsignedBigInteger('supervisor_id')->nullable()->after('user_id');
            $table->timestamp('fecha_revision')->nullable()->after('estado');
            $table->foreign('supervisor_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('crear_cuenta_cobros', function (Blueprint $table) {
            $table->dropForeign(['supervisor_id']);
            $table->dropColumn(['supervisor_id', 'fecha_revision']);
        });
    }
};
