<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Roles;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buscar el rol de alcalde
        $alcaldeRoles = Roles::where(column: 'name', operator: 'alcalde')->first();
        
        if (!$alcaldeRoles) {
            $this->command->error('El rol de alcalde no existe. Ejecuta primero el RoleSeeder.');
            return;
        }

        // Crear usuario administrador
        $admin = User::firstOrCreate(
            ['email' => 'daniel00250@hotmail.com'],
            [
                'name' => 'Daniel Ramirez',
                'email' => 'daniel00250@hotmail.com',
                'password' => Hash::make('cosa1234'),
                'role_id' => $alcaldeRoles->id,
                'email_verified_at' => now(),
            ]
        );

        if ($admin->wasRecentlyCreated) {
            $this->command->info('✅ Usuario administrador creado exitosamente:');
            $this->command->info('   👤 Nombre: Daniel Ramirez');
            $this->command->info('   📧 Email: daniel00250@hotmail.com');
            $this->command->info('   🔑 Contraseña: cosa1234');
            $this->command->info('   👑 Rol: Alcalde');
        } else {
            $this->command->info('ℹ️  El usuario administrador ya existe.');
            
            // Actualizar el rol si es necesario
            if ($admin->role_id !== $alcaldeRoles->id) {
                $admin->update(['role_id' => $alcaldeRoles->id]);
                $this->command->info('✅ Rol actualizado a Alcalde.');
            }
        }
    }
}
