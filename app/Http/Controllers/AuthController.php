<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Roles;
use App\Models\CrearCuentaCobro;

class AuthController extends Controller
{
    /**
     * Mostrar el formulario de login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Procesar el login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            return redirect()->intended('/dashboard')
                ->with('success', 'Has iniciado sesión exitosamente.');
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')
            ->with('success', 'Has cerrado sesión exitosamente.');
    }
    
    /**
     * Mostrar el dashboard según el rol del usuario
     */
    public function dashboard()
{
    $user = Auth::user();
    
    // Redirigir a diferentes secciones según el rol
    if ($user->hasRole('contratista')) {
        return redirect()->route('cuentas-cobro.index');
    }
    
    if ($user->hasRole('supervisor')) {
        return redirect()->route('supervisor.dashboard');
    }
    
    // Para otros roles, mostrar el dashboard general con datos específicos
    $dashboardData = [
        'user' => $user,
        'userRole' => $user->role ? $user->role->name : null,
        'userRoleDescription' => $user->role ? $user->role->description : 'Sin rol asignado'
    ];

    // Datos específicos para el alcalde
    if ($user->hasRole('alcalde')) {
        $dashboardData = array_merge($dashboardData, [
            'totalUsers' => User::count(),
            'totalRoles' => Roles::count(),
            'usersWithRoles' => User::whereNotNull('role_id')->count(),
            'usersWithoutRoles' => User::whereNull('role_id')->count(),

            'rolesStats' => Roles::withCount('users')->get(),
            'recentUsers' => User::with('role')->latest()->limit(5)->get(),
            'systemRoles' => ['contratista', 'supervisor', 'alcalde', 'ordenador_gasto', 'tesoreria', 'contratacion'],

                    //  ESTADÍSTICAS DE CUENTAS DE COBRO
            'totalCuentasCobro' => CrearCuentaCobro::count(),
            'cuentasPendientes' => CrearCuentaCobro::where('estado', 'pendiente')->count(),
            'cuentasAprobadas' => CrearCuentaCobro::where('estado', 'aprobado')->count(),
            'cuentasRechazadas' => CrearCuentaCobro::where('estado', 'rechazado')->count(),
            'cuentasRecientes' => CrearCuentaCobro::with('user')->latest()->limit(5)->get(),
        ]);
    }

    // Datos específicos para tesorería
    if ($user->hasRole('tesoreria')) {
    return redirect()->route('tesoreria.dashboard');
}


    // Datos específicos para ordenador del gasto
    if ($user->hasRole('ordenador_gasto')) {
        $dashboardData = array_merge($dashboardData, [
            'pendingAuthorizations' => 0,
            'authorizedToday' => 0,
            'budgetStatus' => 0
        ]);
    }

    // Datos específicos para contratación
    if ($user->hasRole('contratacion')) {
        $dashboardData = array_merge($dashboardData, [
            'activeContracts' => 0,
            'pendingContracts' => 0,
            'totalContractors' => 0
        ]);
    }

    return view('dashboard', $dashboardData);
    }
}