<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CuentaCobro;

class crearCuentaCobro extends Controller
{
    public function index()
    {
        return view('crearCuentaCobro');
    }

    public function crearCuenta(Request $request)
    {
        // Lógica para crear una cuenta de cobro
    }
}
