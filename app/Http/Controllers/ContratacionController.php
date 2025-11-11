<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documento;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ContratacionController extends Controller
{
    // Vista principal dentro del dashboard
    public function index()
    {
        $documentos = Documento::with('user')->latest()->get();
        return view('contratacion.index', compact('documentos'));
    }

    // Aprobar o rechazar documento
    public function actualizarEstado(Request $request, $id)
    {
        $documento = Documento::findOrFail($id);

        $request->validate([
            'estado' => 'required|in:aprobado,rechazado',
            'comentario' => 'nullable|string|max:500',
        ]);

        $documento->estado = $request->estado;
        $documento->comentario = $request->comentario;
        $documento->save();

        return redirect()->back()->with('success', 'Estado actualizado correctamente.');
    }

    // Descargar o ver documento
    public function ver($id)
    {
        $documento = Documento::findOrFail($id);
        
        if (!Storage::disk('public')->exists('documentos/' . $documento->archivo)) {
            return response()->json(['error' => 'Archivo no encontrado'], 404);
        }

        $url = Storage::url('documentos/' . $documento->archivo);
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'documento' => $documento,
                'url' => $url
            ]);
        }

        // Si no es una petición AJAX, devolver el archivo directamente
        $path = storage_path('app/public/documentos/'.$documento->archivo);
        return response()->file($path);
    }
}