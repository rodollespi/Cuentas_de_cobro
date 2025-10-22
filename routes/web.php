<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CrearUsuario;
use App\Http\Controllers\RolController;
use App\Http\Controllers\FtpController;
use App\Http\Controllers\CrearCuentaCobroController;
use App\Http\Controllers\CuentaCobroController;


// Ruta raíz redirige al login
Route::get('/', function () {
    return redirect('/login');
});

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas Crear usuarios
Route::get('/register', [CrearUsuario::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [CrearUsuario::class, 'register']);

// Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    
    // Rutas de Roles (Resource Routes)
    Route::middleware(['auth'])->group(function () {
        Route::resource('roles', RolController::class)->except(['show'])->names([
            'index' => 'roles.index',
            'create' => 'roles.create',
            'store' => 'roles.store',
            'edit' => 'roles.edit',
            'update' => 'roles.update',
            'destroy' => 'roles.destroy'
        ]);
    });
    
    // Ruta personalizada para show (usando {role} en lugar de {id})
    Route::get('/roles/{role}', [RolController::class, 'show'])->name('roles.show');
    
    // Rutas adicionales para gestión de roles y usuarios
    Route::prefix('roles')->name('roles.')->group(function () {
        // Asignar/remover roles a usuarios (AJAX)
        Route::post('/assign-role', [RolController::class, 'assignRole'])->name('assign');
        Route::post('/remove-role', [RolController::class, 'removeRole'])->name('remove');
        
        // Obtener usuarios sin rol (AJAX)
        Route::get('/users-without-role', [RolController::class, 'getUsersWithoutRole'])->name('users.without.role');
    });
    
    // Rutas adicionales que podrías necesitar más adelante
    Route::prefix('admin')->middleware(['auth', 'check.role:alcalde'])->name('admin.')->group(function () {
        
        // Gestión de usuarios (futuras funcionalidades)
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', function() {
                return view('admin.users.index');
            })->name('index');
            
            Route::post('/{user}/assign-role', function() {
                // Asignar rol a usuario específico
            })->name('assign.role');
        });
        
        // Configuración del sistema (futuras funcionalidades)
        Route::get('/settings', function() {
            return view('admin.settings');
        })->name('settings');
    });
});
Route::get('/ftp/subir', [FtpController::class, 'subirArchivo']);
Route::get('/ftp/listar', [FtpController::class, 'listarArchivos']);
Route::get('/ftp/leer', [FtpController::class, 'leerArchivo']);

// Rutas que requieren roles específicos (ejemplos para futuro uso)
Route::middleware(['auth'])->group(function () {
    
    // ============================================
    // RUTAS PARA CONTRATISTA - CUENTAS DE COBRO
    // ============================================
    Route::middleware(['check.role:contratista'])->group(function () {
    // Resource route con nombres explícitos
    Route::resource('cuentas-cobro', CrearCuentaCobroController::class)->names([
        'index' => 'cuentas-cobro.index',
        'create' => 'cuentas-cobro.create', 
        'store' => 'cuentas-cobro.store',
        'show' => 'cuentas-cobro.show',
        'edit' => 'cuentas-cobro.edit',
        'update' => 'cuentas-cobro.update',
        'destroy' => 'cuentas-cobro.destroy'
    ]);
    
    Route::get('cuentas-cobro/{cuentasCobro}/descargar/{tipo}', [CrearCuentaCobroController::class, 'descargarDocumento'])
        ->name('cuentas-cobro.descargar');
});
    // Solo para supervisores
    Route::middleware(['check.role:supervisor'])->prefix('supervisor')->name('supervisor.')->group(function () {
        Route::get('/dashboard', function() {
            return view('supervisor.dashboard');
        })->name('dashboard');
    });
    
    // Solo para roles administrativos (alcalde, ordenador del gasto)
    Route::middleware(['check.role:alcalde,ordenador_gasto'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/reports', function() {
            return view('admin.reports');
        })->name('reports');
    });
});