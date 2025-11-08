<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ContratistaDocumentoController extends Controller
{
    public function index()
    {
        $documentos = Documento::where('user_id', Auth::id())->latest()->get();
        return view('dashboard.contratista.documentos', compact('documentos'));
    }

public function vista($id)
{
    $documento = Documento::findOrFail($id);
    
    $fullPath = storage_path('app/public/documentos/' . $documento->archivo);
    
    if (!file_exists($fullPath)) {
        abort(404, 'Archivo no encontrado');
    }
    
    // Si es una petición AJAX, devolver la vista del modal
    if (request()->ajax()) {
        return view('documentos.vista', [
            'documento' => $documento,
            'url' => asset('storage/documentos/' . $documento->archivo)
        ])->render();
    }
    
    // Si no es AJAX, mostrar el documento directamente
    return response()->file($fullPath);
}

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'archivo' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('archivo')->store('documentos', 'public');
        Documento::create([
            'user_id' => Auth::id(),
            'nombre' => $request->nombre,
            'archivo' => basename($path),
            'estado' => 'pendiente',
        ]);

        return redirect()->back()->with('success', 'Documento subido correctamente. Espera la revisión del área de contratación.');
    }

public function ver($id)
    {
$documento = Documento::findOrFail($id);

    $path = storage_path('app/public/documentos/' . $documento->archivo);

    if (!file_exists($path)) {
        abort(404, 'Archivo no encontrado en: ' . $path);
    }

    //duplicate vista removed (merged above)

    return view('documentos.vista', compact('documento', 'url', 'extension'));
   }

}