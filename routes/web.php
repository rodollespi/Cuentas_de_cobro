<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CrearUsuario;
use App\Http\Controllers\RolController;
use App\Http\Controllers\FtpController;
use App\Http\Controllers\CrearCuentaCobroController;
use App\Http\Controllers\CuentaCobroController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\AlcaldeController;
use App\Http\Controllers\OrdenadorController;


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
    Route::middleware(['auth', 'check.role:supervisor'])->group(function () {
    Route::get('/supervisor/dashboard', [SupervisorController::class, 'dashboard'])
        ->name('supervisor.dashboard');

    Route::get('/supervisor/cuenta/{id}/ver', [SupervisorController::class, 'ver'])->name('supervisor.ver');    
    Route::get('/supervisor/revisar/{id}', [SupervisorController::class, 'revisar'])->name('supervisor.revisar');
    Route::post('/supervisor/aprobar/{id}', [SupervisorController::class, 'aprobar'])->name('supervisor.aprobar');
    Route::post('/supervisor/rechazar/{id}', [SupervisorController::class, 'rechazar'])->name('supervisor.rechazar');
});

    // ============================================
    // RUTAS PARA ALCALDE - CUENTAS DE COBRO
    // ============================================

    Route::middleware(['auth', 'check.role:alcalde'])->prefix('alcalde')->name('alcalde.')->group(function () {
        // Dashboard del alcalde (opcional)
        Route::get('/dashboard', function() {
            return redirect()->route('alcalde.cuentas-cobro.index');
        })->name('dashboard');
        
        // Gestión de cuentas de cobro
        Route::get('/cuentas-cobro', [AlcaldeController::class, 'index'])->name('cuentas-cobro.index');
        Route::get('/cuentas-cobro/{id}', [AlcaldeController::class, 'show'])->name('cuentas-cobro.show');
        Route::post('/cuentas-cobro/{id}/aprobar', [AlcaldeController::class, 'aprobar'])->name('cuentas-cobro.aprobar');
        Route::post('/cuentas-cobro/{id}/rechazar', [AlcaldeController::class, 'rechazar'])->name('cuentas-cobro.rechazar');
        Route::post('/cuentas-cobro/{id}/finalizar', [AlcaldeController::class, 'finalizar'])->name('cuentas-cobro.finalizar');
    });

    
    // Solo para roles administrativos (alcalde, ordenador del gasto)
    Route::middleware(['check.role:alcalde,ordenador_gasto'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/reports', function() {
            return view('admin.reports');
        })->name('reports');
    });
    
    Route::middleware(['auth'])->group(function () {
    Route::get('/ordenador', [OrdenadorController::class, 'index'])
        ->name('ordenador.dashboard');
    });
});

