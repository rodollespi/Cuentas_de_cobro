<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CuentasCobro')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @stack('styles')
    
        <!-- Estilos dinámicos según el tema -->
    <style>
        body {
            @if(session('tema') === 'oscuro')
                background-color: #1a1a2e;
                color: #f1f1f1;
            @else
                background-color: #f8f9fc;
                color: #333;
            @endif
            transition: background-color 0.4s, color 0.4s;
        }

        .card {
            @if(session('tema') === 'oscuro')
                background-color: #222;
                color: #f1f1f1;
                border-color: #444;
            @else
                background-color: #fff;
                color: #333;
            @endif
        }

        .navbar-custom {
            @if(session('tema') === 'oscuro')
                background: linear-gradient(135deg, #232526 0%, #414345 100%);
            @else
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            @endif
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }

        footer {
            @if(session('tema') === 'oscuro')
                background-color: #111;
                color: #ccc;
            @else
                background-color: #f8f9fc;
                color: #555;
            @endif
        }
    </style>

    <style>
        :root {
            --sidebar-width: 250px;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fc;
        }
        
        .navbar-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        
        .navbar-custom .navbar-brand {
            color: white;
            font-weight: 600;
            font-size: 1.3rem;
        }
        
        .navbar-custom .nav-link {
            color: rgba(255,255,255,0.9);
            transition: all 0.3s;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
        }
        
        .navbar-custom .nav-link:hover {
            color: white;
            background-color: rgba(255,255,255,0.1);
        }
        
        .navbar-custom .dropdown-menu {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15);
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: #667eea;
        }
        
        .main-content {
            min-height: calc(100vh - 56px);
            padding-top: 2rem;
        }
        
        .dropdown-toggle::after {
            vertical-align: middle;
        }
        
        @media (max-width: 768px) {
            .navbar-custom .navbar-brand {
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-receipt me-2"></i>
                CuentasCobro
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">

                    </li>
                    
                    @auth
                        @if(auth()->user()->role && auth()->user()->role->name === 'alcalde')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-users-cog me-1"></i>
                                Administración
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('roles.index') }}">
                                        <i class="fas fa-user-shield me-2"></i>
                                        Gestión de Roles
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-users me-2"></i>
                                        Usuarios
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-cog me-2"></i>
                                        Configuración
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        
                        @if(auth()->user()->role && in_array(auth()->user()->role->name, ['contratista', 'supervisor', 'ordenador_gasto']))
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-file-invoice me-1"></i>
                                Cuentas de Cobro
                            </a>
                        </li>
                        @endif
                    @endauth
                </ul>
                
                <!-- User Menu -->
                <ul class="navbar-nav ms-auto">
                    @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <div class="user-info">
                                <div class="user-avatar">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <div class="dropdown-header">
                                    <strong>{{ auth()->user()->name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ auth()->user()->email }}</small>
                                    @if(auth()->user()->role)
                                    <br>
                                    <span class="badge bg-primary mt-1">
                                        {{ ucfirst(str_replace('_', ' ', auth()->user()->role->name)) }}
                                    </span>
                                    @endif
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                           <li>
                              <a class="dropdown-item" href="{{ route('perfil.index') }}">
                            <i class="fas fa-user me-2"></i>
                            Mi Perfil
                              </a>
                            </li>
                              <li>
                               <a class="dropdown-item" href="{{ route('configuracion.index') }}">
                              <i class="fas fa-cog me-2"></i>
                             Configuración
                              </a>
</li>

                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i>
                                        Cerrar Sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i>
                            Iniciar Sesión
                        </a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container-fluid px-4">
            <!-- Alerts -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>¡Error!</strong> Por favor corrige los siguientes errores:
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-4 mt-5 bg-light">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between small">
                <div class="text-muted">
                    Copyright &copy; CuentasCobro {{ date('Y') }}
                </div>
                <div>
                    <a href="#" class="text-muted text-decoration-none">Privacidad</a>
                    &middot;
                    <a href="#" class="text-muted text-decoration-none">Términos</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
    
    <script>
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>
</body>
</html>