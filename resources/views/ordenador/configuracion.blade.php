@extends('layouts.app')

@section('title', 'Configuración')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                    <h5 class="mb-0"><i class="fas fa-cog me-2"></i>Configuración</h5>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('configuracion.save') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="tema" class="form-label">Tema de la interfaz</label>
                            <select name="tema" id="tema" class="form-select">
                                <option value="claro" {{ old('tema', $config['tema'] ?? '') == 'claro' ? 'selected' : '' }}>Claro</option>
                                <option value="oscuro" {{ old('tema', $config['tema'] ?? '') == 'oscuro' ? 'selected' : '' }}>Oscuro</option>
                            </select>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="notificaciones" name="notificaciones" value="1"
                                {{ old('notificaciones', $config['notificaciones'] ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="notificaciones">Activar notificaciones</label>
                        </div>

                        <div class="mb-3">
                            <label for="lenguaje" class="form-label">Idioma</label>
                            <select name="lenguaje" id="lenguaje" class="form-select">
                                <option value="es" {{ old('lenguaje', $config['lenguaje'] ?? '') == 'es' ? 'selected' : '' }}>Español</option>
                                <option value="en" {{ old('lenguaje', $config['lenguaje'] ?? '') == 'en' ? 'selected' : '' }}>Inglés</option>
                            </select>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Guardar cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

