<?php

namespace App\Http\Controllers;

use App\Models\CrearCuentaCobro;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CrearCuentaCobroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('CuentasDeCobro');
    }

 
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CrearCuentaCobro $crearCuentaCobro)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CrearCuentaCobro $crearCuentaCobro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CrearCuentaCobro $crearCuentaCobro)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CrearCuentaCobro $crearCuentaCobro)
    {
        //
    }
}
