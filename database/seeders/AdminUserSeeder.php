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
        // Obtener todos los roles existentes
        $roles = Roles::all();

        if ($roles->isEmpty()) {
            $this->command->error('No hay roles existentes. Ejecuta primero el RoleSeeder.');
            return;
        }
        $usersData = [
            'alcalde' => [
                'name' => 'Daniel Ramirez',
                'email' => 'daniel00250@hotmail.com',
                'password' => 'cosa1234',
            ],
            'supervisor' => [
                'name' => 'juan',
                'email' => 'juan@gmail.com', 
                'password' => 'password123',
            ],
            'contratista' => [
                'name' => 'sanda',
                'email' => 'sanda@gmail.com',
                'password' => 'password123',
            ],
            'tesoreria' => [
                'name' => 'david',
                'email' => 'david@gmail.com',
                'password' => 'password123',
            ],
            'ordenador' => [
                'name' => 'yami',
                'email' => 'yami@gmail.com',
                'password' => 'password123',
            ],
            // Agregar el rol 6 (felipe)
            'otro' => [ // O el nombre que tenga el rol 6
                'name' => 'felipe',
                'email' => 'felipe@gmail.com',
                'password' => 'password123',
            ],
        ];

        $createdCount = 0;
        $updatedCount = 0;

        foreach ($roles as $role) {
            $roleName = strtolower($role->name);
            
            // Buscar datos del usuario por role_id o por nombre de rol
            $userData = null;
            
            // Mapear role_id a los datos correspondientes
            $roleMapping = [
                1 => 'supervisor',     // juan
                2 => 'contratista',    // sanda  
                3 => 'alcalde',        // daniel
                4 => 'tesoreria',      // david
                5 => 'ordenador',      // yami
                6 => 'otro',           // felipe
            ];
            
            if (isset($roleMapping[$role->id]) && isset($usersData[$roleMapping[$role->id]])) {
                $userData = $usersData[$roleMapping[$role->id]];
            } elseif (isset($usersData[$roleName])) {
                $userData = $usersData[$roleName];
            }

            if ($userData) {
                $user = User::firstOrCreate(
                    ['email' => $userData['email']],
                    [
                        'name' => $userData['name'],
                        'email' => $userData['email'],
                        'password' => Hash::make($userData['password']),
                        'role_id' => $role->id,
                        'email_verified_at' => now(),
                    ]
                );

                if ($user->wasRecentlyCreated) {
                    $this->command->info("✅ Usuario {$role->name} creado:");
                    $this->command->info("   👤 Nombre: {$userData['name']}");
                    $this->command->info("   📧 Email: {$userData['email']}");
                    $this->command->info("   🔑 Contraseña: {$userData['password']}");
                    $this->command->info("   👑 Rol: {$role->name} (ID: {$role->id})");
                    $createdCount++;
                } else {
                    // Actualizar el rol si es necesario
                    if ($user->role_id !== $role->id) {
                        $user->update(['role_id' => $role->id]);
                        $this->command->info("✅ Usuario {$userData['name']} actualizado a rol: {$role->name}");
                        $updatedCount++;
                    } else {
                        $this->command->info("ℹ️  Usuario {$userData['name']} ya existe con rol {$role->name}.");
                    }
                }
            } else {
                $this->command->warn("⚠️  No hay datos de usuario definidos para el rol: {$role->name} (ID: {$role->id})");
            }
        }

        $this->command->info("\n📊 Resumen:");
        $this->command->info("   ✅ Usuarios creados: {$createdCount}");
        $this->command->info("   🔄 Usuarios actualizados: {$updatedCount}");
        $this->command->info("   👥 Total de roles procesados: " . $roles->count());
    }
}