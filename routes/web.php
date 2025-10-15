<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CrearUsuario;
use App\Http\Controllers\CrearCuentaCobroController;

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


//Route::view('/CuentasDeCobro', 'CuentasDeCobro');

Route::get('/cuentasDeCobro',[CrearCuentaCobroController::class,'index'])->name('crearCuentaCobro.index');
Route::post('CuentasDeCobro/almacenar',[CrearCuentaCobroController::class,'almacenar'])->name('crearCuentaCobro.almacenar');

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
});
Route::view('/prueba3','roles.dashboard');


Route::get('/crearCuentaCobro', function () {
    return view('crearCuentaCobro');
})->middleware('auth');