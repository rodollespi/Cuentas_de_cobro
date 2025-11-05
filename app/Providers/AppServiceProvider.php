<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\CrearCuentaCobro;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {

            if (Auth::check() && Auth::user()->role) {
                $rol = Auth::user()->role->name;

                // ==========================
                // ORDENADOR DEL GASTO
                // ==========================
                if ($rol === 'ordenador_gasto') {
                    $cuentasPendientes = CrearCuentaCobro::whereIn('estado', ['pendiente', 'Revisada'])->count();
                    $view->with('cuentasPendientes', $cuentasPendientes);
                }

                // ==========================
                // ALCALDE
                // ==========================
                elseif ($rol === 'alcalde') {
                    $cuentasPendientes = CrearCuentaCobro::where('estado', 'Aprobada por supervisor')->count();
                    $view->with('cuentasPendientes', $cuentasPendientes);
                }

                // ==========================
                // OTROS ROLES
                // ==========================
                else {
                    $view->with('cuentasPendientes', 0);
                }
            } else {
                $view->with('cuentasPendientes', 0);
            }
        });
    }
}


