<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // PASO 1: Verificar y actualizar registros NULL
        echo "Verificando registros con telefono_beneficiario NULL...\n";
        
        $nullCount = DB::table('crear_cuenta_cobros')
            ->whereNull('telefono_beneficiario')
            ->count();
            
        echo "Encontrados {$nullCount} registros con telefono_beneficiario NULL\n";

        if ($nullCount > 0) {
            echo "Actualizando registros NULL a valor por defecto...\n";
            
            DB::table('crear_cuenta_cobros')
                ->whereNull('telefono_beneficiario')
                ->update(['telefono_beneficiario' => 'No especificado']);
                
            echo "Registros actualizados exitosamente\n";
        }

        // PASO 2: Verificar que no hay más NULLs
        $remainingNulls = DB::table('crear_cuenta_cobros')
            ->whereNull('telefono_beneficiario')
            ->count();
            
        if ($remainingNulls === 0) {
            echo "No hay registros NULL restantes. Cambiando columna a NOT NULL...\n";
            
            // Cambiar la columna a NOT NULL
            Schema::table('crear_cuenta_cobros', function (Blueprint $table) {
                $table->string('telefono_beneficiario', 255)->nullable(false)->change();
            });
            
            echo "Columna telefono_beneficiario cambiada a NOT NULL exitosamente\n";
        } else {
            echo "Error: Todavía hay {$remainingNulls} registros NULL. Abortando...\n";
            throw new Exception("No se pueden limpiar todos los registros NULL");
        }
    }

    public function down()
    {
        // Revertir: hacer la columna nullable nuevamente
        Schema::table('crear_cuenta_cobros', function (Blueprint $table) {
            $table->string('telefono_beneficiario', 255)->nullable()->change();
        });

        // Opcional: Revertir los valores actualizados
        DB::table('crear_cuenta_cobros')
            ->where('telefono_beneficiario', 'No especificado')
            ->update(['telefono_beneficiario' => null]);
    }
};