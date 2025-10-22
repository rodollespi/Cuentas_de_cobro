<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FtpController extends Controller
{
    public function subirArchivo()
    {
        // Subir archivo
        Storage::disk('ftp')->put('archivo.txt', 'contenido de prueba');

        return "Archivo subido exitosamente al FTP.";
    }

    public function listarArchivos()
    {
        // Listar archivos
        $archivos = Storage::disk('ftp')->files('/');
        return response()->json($archivos);
    }

    public function leerArchivo()
    {
        // Leer archivo
        $contenido = Storage::disk('ftp')->get('archivo.txt');
        return response($contenido);
    }
}
