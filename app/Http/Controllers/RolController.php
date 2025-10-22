<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RolController extends Controller
{
    /**
     * Middleware de autenticación
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mostrar lista de todos los roles
     */
    public function index()
    {
        if (!Auth::user()->isAdmin()) {
            return redirect('/dashboard')->with('error', 'No tienes permisos para acceder a esta sección.');
        }

        $roles = Roles::withCount('users')->get();
        return view('roles.index', compact('roles'));
    }

    /**
     * Mostrar formulario para crear nuevo rol
     */
    public function create()
    {
        if (!Auth::user()->hasRole('alcalde')) {
            return redirect('/dashboard')->with('error', 'No tienes permisos para crear roles.');
        }

        $availablePermissions = $this->getAvailablePermissions();
        return view('roles.create', compact('availablePermissions'));
    }

    /**
     * Almacenar nuevo rol
     */
    public function store(Request $request)
    {
        if (!Auth::user()->hasRole('alcalde')) {
            return redirect('/dashboard')->with('error', 'No tienes permisos para crear roles.');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name|regex:/^[a-z_]+$/',
            'description' => 'required|string|max:500',
            'permissions' => 'array'
        ]);

        Roles::create([
            'name' => $request->name,
            'description' => $request->description,
            'permissions' => $request->permissions ?? []
        ]);

        return redirect()->route('roles.index')->with('success', 'Rol creado exitosamente.');
    }

    /**
     * Mostrar detalles de un rol específico
     */
    public function show(Roles $role)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect('/dashboard')->with('error', 'No tienes permisos para ver esta información.');
        }

        $users = $role->users()->paginate(10);
        $availablePermissions = $this->getAvailablePermissions();
        
        return view('roles.show', compact('role', 'users', 'availablePermissions'));
    }

    /**
     * Mostrar formulario de edición de un rol
     */
    public function edit($id)
    {
        if (!Auth::user()->hasRole('alcalde')) {
            return redirect('/dashboard')->with('error', 'No tienes permisos para editar roles.');
        }

        $role = Roles::findOrFail($id);
        $availablePermissions = $this->getAvailablePermissions();

        return view('roles.edit', compact('role', 'availablePermissions'));
    }

    /**
     * Actualizar rol en la base de datos
     */
    public function update(Request $request, $id)
    {
        if (!Auth::user()->hasRole('alcalde')) {
            return redirect('/dashboard')->with('error', 'No tienes permisos para actualizar roles.');
        }

        $role = Roles::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'description' => 'required|string|max:500',
            'permissions' => 'array'
        ]);

        $role->update([
            'name' => $request->name,
            'description' => $request->description,
            'permissions' => $request->permissions ?? []
        ]);

        return redirect()->route('roles.index')->with('success', 'Rol actualizado correctamente.');
    }

    /**
     * Eliminar un rol
     */
    public function destroy($id)
    {
        if (!Auth::user()->hasRole('alcalde')) {
            return redirect('/dashboard')->with('error', 'No tienes permisos para eliminar roles.');
        }

        $role = Roles::findOrFail($id);
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Rol eliminado correctamente.');
    }

    /**
     * Obtener permisos disponibles
     */
    private function getAvailablePermissions()
    {
        return [
            // Cuentas de Cobro
            'create_cuenta_cobro',
            'view_cuenta_cobro',
            'view_own_cuenta_cobro',
            'view_all_cuenta_cobro',
            'edit_own_cuenta_cobro',
            'review_cuenta_cobro',
            'approve_cuenta_cobro',
            'reject_cuenta_cobro',
            'final_approval',

            // Documentos
            'upload_documents',
            'view_documents',

            // Contratos
            'view_contract_info',
            'manage_contracts',
            'contract_validation',

            // Pagos
            'authorize_payment',
            'process_payment',
            'generate_checks',
            'bank_transfers',
            'payment_confirmation',
            'generate_payment_orders',

            // Presupuesto
            'view_budget',
            'manage_budget',

            // Reportes
            'view_reports',
            'financial_reports',
            'view_financial_reports',
            'contract_reports',

            // Administración
            'manage_users',
            'manage_contractors',
            'contractor_registration',
            'system_admin',

            // Otros
            'add_comments',
            'request_corrections',
            'override_decisions'
        ];
    }
}
