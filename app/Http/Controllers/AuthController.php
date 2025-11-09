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

    /**
     * ✅ 1) Si el usuario NO tiene rol, asignarle CONTRATISTA automáticamente
     */
    if (!$user->role) {
        $defaultRole = Roles::where('name', 'contratista')->first();

        if ($defaultRole) {
            $user->role_id = $defaultRole->id;
            $user->save();
        }

        // Actualizar la variable local
        $user->refresh();
    }

    // Ahora SIEMPRE existe un rol
    $userRole = $user->role->name;


    /**
     * ✅ 2) Redirecciones específicas según el rol
     */
    if ($userRole === 'contratista') {
        return redirect()->route('cuentas-cobro.index');
    }

    if ($userRole === 'supervisor') {
        return redirect()->route('supervisor.dashboard');
    }

    if ($userRole === 'tesoreria') {
        return redirect()->route('tesoreria.dashboard');
    }


    /**
     * ✅ 3) Dashboard general
     */
    $dashboardData = [
        'user' => $user,
        'userRole' => $userRole,
        'userRoleDescription' => $user->role->description ?? '',
    ];


    /**
     * ✅ 4) Datos para el alcalde
     */
    if ($userRole === 'alcalde') {

        $dashboardData = array_merge($dashboardData, [
            'totalUsers' => User::count(),
            'totalRoles' => Roles::count(),
            'usersWithRoles' => User::whereNotNull('role_id')->count(),
            'usersWithoutRoles' => User::whereNull('role_id')->count(),

            'rolesStats' => Roles::withCount('users')->get(),
            'recentUsers' => User::with('role')->latest()->limit(5)->get(),
            'systemRoles' => ['contratista', 'supervisor', 'alcalde', 'ordenador_gasto', 'tesoreria', 'contratacion'],

            'totalCuentasCobro' => CrearCuentaCobro::count(),
            'cuentasPendientes' => CrearCuentaCobro::where('estado', 'pendiente')->count(),
            'cuentasAprobadas' => CrearCuentaCobro::where('estado', 'aprobado')->count(),
            'cuentasRechazadas' => CrearCuentaCobro::where('estado', 'rechazado')->count(),
            'cuentasRecientes' => CrearCuentaCobro::with('user')->latest()->limit(5)->get(),
        ]);
    }

    /**
     * ✅ 5) Datos para rol "ordenador_gasto"
     */
    if ($userRole === 'ordenador_gasto') {
        $dashboardData = array_merge($dashboardData, [
            'pendingAuthorizations' => 0,
            'authorizedToday' => 0,
            'budgetStatus' => 0
        ]);
    }

    /**
     * ✅ 6) Datos para rol "contratacion"
     */
    if ($userRole === 'contratacion') {
        $dashboardData = array_merge($dashboardData, [
            'activeContracts' => 0,
            'pendingContracts' => 0,
            'totalContractors' => 0
        ]);
    }

    return view('dashboard', $dashboardData);
}
}