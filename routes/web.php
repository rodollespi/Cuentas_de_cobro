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
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ConfiguracionController;

// ============================================
// RUTA RAÍZ
// ============================================
Route::get('/', function () {
    return redirect('/login');
});

// ============================================
// AUTENTICACIÓN
// ============================================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Registro de usuarios
Route::get('/register', [CrearUsuario::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [CrearUsuario::class, 'register']);

// ============================================
// RUTAS PROTEGIDAS (AUTH)
// ============================================
Route::middleware(['auth'])->group(function () {

    // Dashboard general
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // ============================================
    // ROLES
    // ============================================
    Route::resource('roles', RolController::class)->except(['show'])->names([
        'index' => 'roles.index',
        'create' => 'roles.create',
        'store' => 'roles.store',
        'edit' => 'roles.edit',
        'update' => 'roles.update',
        'destroy' => 'roles.destroy'
    ]);

    Route::get('/roles/{role}', [RolController::class, 'show'])->name('roles.show');

    Route::prefix('roles')->name('roles.')->group(function () {
        Route::post('/assign-role', [RolController::class, 'assignRole'])->name('assign');
        Route::post('/remove-role', [RolController::class, 'removeRole'])->name('remove');
        Route::get('/users-without-role', [RolController::class, 'getUsersWithoutRole'])->name('users.without.role');
    });

    // ============================================
    // ADMIN (Alcalde)
    // ============================================
    Route::prefix('admin')->middleware(['check.role:alcalde'])->name('admin.')->group(function () {
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', function() {
                return view('admin.users.index');
            })->name('index');
        });

        Route::get('/settings', function() {
            return view('admin.settings');
        })->name('settings');
    });

    // ============================================
    // FTP
    // ============================================
    Route::get('/ftp/subir', [FtpController::class, 'subirArchivo']);
    Route::get('/ftp/listar', [FtpController::class, 'listarArchivos']);
    Route::get('/ftp/leer', [FtpController::class, 'leerArchivo']);

    // ============================================
    // CONTRATISTA
    // ============================================
    Route::middleware(['check.role:contratista'])->group(function () {
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

    // ============================================
    // SUPERVISOR
    // ============================================
    Route::middleware(['check.role:supervisor'])->group(function () {
        Route::get('/supervisor/dashboard', [SupervisorController::class, 'dashboard'])->name('supervisor.dashboard');
        Route::get('/supervisor/cuenta/{id}/ver', [SupervisorController::class, 'ver'])->name('supervisor.ver');
        Route::get('/supervisor/revisar/{id}', [SupervisorController::class, 'revisar'])->name('supervisor.revisar');
        Route::post('/supervisor/aprobar/{id}', [SupervisorController::class, 'aprobar'])->name('supervisor.aprobar');
        Route::post('/supervisor/rechazar/{id}', [SupervisorController::class, 'rechazar'])->name('supervisor.rechazar');
    });

    // ============================================
    // ALCALDE
    // ============================================
    Route::middleware(['check.role:alcalde'])->prefix('alcalde')->name('alcalde.')->group(function () {
        Route::get('/dashboard', function() {
            return redirect()->route('alcalde.cuentas-cobro.index');
        })->name('dashboard');
        Route::get('/cuentas-cobro', [AlcaldeController::class, 'index'])->name('cuentas-cobro.index');
        Route::get('/cuentas-cobro/{id}', [AlcaldeController::class, 'show'])->name('cuentas-cobro.show');
        Route::post('/cuentas-cobro/{id}/aprobar', [AlcaldeController::class, 'aprobar'])->name('cuentas-cobro.aprobar');
        Route::post('/cuentas-cobro/{id}/rechazar', [AlcaldeController::class, 'rechazar'])->name('cuentas-cobro.rechazar');
        Route::post('/cuentas-cobro/{id}/finalizar', [AlcaldeController::class, 'finalizar'])->name('cuentas-cobro.finalizar');
    });

    // ============================================
    // ORDENADOR DEL GASTO
    // ============================================
    Route::get('/ordenador', [OrdenadorController::class, 'index'])->name('ordenador.dashboard');

    // ============================================
    // PERFIL Y CONFIGURACIÓN
    // ============================================
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil.index');
    Route::put('/perfil', [PerfilController::class, 'update'])->name('perfil.update');

    Route::get('/configuracion', [ConfiguracionController::class, 'index'])->name('configuracion.index');
    Route::post('/configuracion/guardar', [ConfiguracionController::class, 'save'])->name('configuracion.save');
});




