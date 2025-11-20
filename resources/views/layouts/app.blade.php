<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema de Cuentas de Cobro - Alcaldías')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @stack('styles')
    
    <!-- Estilos dinámicos según el tema -->
    <style>
        :root {
            --primary-color: #1e4a82;
            --secondary-color: #2c6bb3;
            --accent-color: #f8b739;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
        }
        
        body {
            @if(session('tema') === 'oscuro')
                background-color: #1a1a2e;
                color: #f1f1f1;
            @else
                background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
                color: #2c3e50;
            @endif
            transition: background-color 0.4s, color 0.4s;
            font-family: 'Segoe UI', 'Roboto', sans-serif;
        }

        .card {
            @if(session('tema') === 'oscuro')
                background-color: #222;
                color: #f1f1f1;
                border-color: #444;
            @else
                background: white;
                color: #2c3e50;
                border: none;
                box-shadow: 0 2px 15px rgba(0,0,0,0.08);
                border-radius: 12px;
            @endif
        }

        .navbar-custom {
            @if(session('tema') === 'oscuro')
                background: linear-gradient(135deg, #232526 0%, #414345 100%);
            @else
                background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
                box-shadow: 0 4px 20px rgba(30, 74, 130, 0.3);
            @endif
        }

        footer {
            @if(session('tema') === 'oscuro')
                background-color: #111;
                color: #ccc;
            @else
                background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
                color: white;
            @endif
        }

        .navbar-custom .navbar-brand {
            color: white;
            font-weight: 700;
            font-size: 1.4rem;
            letter-spacing: 0.5px;
        }
        
        .navbar-custom .nav-link {
            color: rgba(255,255,255,0.95);
            transition: all 0.3s ease;
            padding: 0.6rem 1rem;
            border-radius: 8px;
            font-weight: 500;
            margin: 0 2px;
        }
        
        .navbar-custom .nav-link:hover {
            color: white;
            background-color: rgba(255,255,255,0.15);
            transform: translateY(-1px);
        }
        
        .navbar-custom .nav-link.active {
            background-color: var(--accent-color);
            color: var(--dark-color);
            font-weight: 600;
        }
        
        .navbar-custom .dropdown-menu {
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border-radius: 12px;
            padding: 0.5rem;
        }
        
        .dropdown-item {
            border-radius: 8px;
            margin: 2px 0;
            transition: all 0.3s ease;
        }
        
        .dropdown-item:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateX(5px);
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent-color), #ff9d00);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            border: 2px solid rgba(255,255,255,0.3);
        }
        
        .main-content {
            min-height: calc(100vh - 76px);
            padding-top: 2rem;
        }
        
        .badge-gov {
            background: linear-gradient(135deg, var(--accent-color), #ff9d00);
            color: var(--dark-color);
            font-weight: 600;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(30, 74, 130, 0.4);
        }
        
        .alert {
            border: none;
            border-radius: 12px;
            border-left: 4px solid;
        }
        
        .alert-success {
            border-left-color: var(--success-color);
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
        }
        
        .alert-danger {
            border-left-color: var(--danger-color);
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
        }
        
        .footer-content {
            background: rgba(255,255,255,0.1);
            padding: 1.5rem;
            border-radius: 12px;
            margin-top: 1rem;
        }
        
        .nav-divider {
            border-left: 1px solid rgba(255,255,255,0.3);
            height: 30px;
            margin: 0 1rem;
        }
        
        @media (max-width: 768px) {
            .navbar-custom .navbar-brand {
                font-size: 1.2rem;
            }
            
            .nav-divider {
                display: none;
            }
        }
        
        /* Efectos de scroll suave */
        html {
            scroll-behavior: smooth;
        }
        
        /* Mejoras visuales para elementos de formulario */
        .form-control {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(30, 74, 130, 0.25);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top py-2">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-landmark me-2"></i>
                Sistema de Cuentas de Cobro
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    @auth
                        @if(auth()->user()->role && auth()->user()->role->name === 'alcalde')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-crown me-1"></i>
                                Administración Municipal
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
                                        <i class="fas fa-chart-bar me-2"></i>
                                        Reportes Municipales
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        
                        @if(auth()->user()->role)
                            @if(auth()->user()->role->name === 'ordenador_gasto')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('ordenador.dashboard') }}">
                                    <i class="fas fa-file-invoice-dollar me-1"></i>
                                    Cuentas de Cobro
                                    @if(isset($cuentasPendientes) && $cuentasPendientes > 0)
                                        <span class="badge badge-gov ms-1">{{ $cuentasPendientes }}</span>
                                    @endif
                                </a>
                            </li>
                            @elseif(auth()->user()->role->name === 'contratista')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('cuentas-cobro.index') }}">
                                    <i class="fas fa-file-contract me-1"></i>
                                    Mis Cuentas
                                </a>
                            </li>
                            @elseif(auth()->user()->role->name === 'supervisor')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('supervisor.dashboard') }}">
                                    <i class="fas fa-clipboard-check me-1"></i>
                                    Revisión de Cuentas
                                </a>
                            </li>
                            @elseif(auth()->user()->role->name === 'alcalde')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('alcalde.dashboard') }}">
                                    <i class="fas fa-user-tie me-1"></i>
                                    Panel Alcaldía
                                </a>
                            </li>
                            @elseif(auth()->user()->role->name === 'tesoreria')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('tesoreria.dashboard') }}">
                                    <i class="fas fa-coins me-1"></i>
                                    Gestión de Pagos
                                </a>
                            </li>
                            @endif
                        @endif
                    @endauth
                </ul>
                
                <!-- User Menu -->
                <ul class="navbar-nav ms-auto">
                    @auth
                    <div class="nav-divider d-none d-lg-block"></div>
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
                                <div class="dropdown-header px-3 py-2">
                                    <strong>{{ auth()->user()->name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ auth()->user()->email }}</small>
                                    @if(auth()->user()->role)
                                    <br>
                                    <span class="badge badge-gov mt-1">
                                        <i class="fas fa-user-tag me-1"></i>
                                        {{ ucfirst(str_replace('_', ' ', auth()->user()->role->name)) }}
                                    </span>
                                    @endif
                                </div>
                            </li>
                            <li><hr class="dropdown-divider mx-3"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('perfil.index') }}">
                                    <i class="fas fa-user-circle me-2"></i>
                                    Mi Perfil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('configuracion.index') }}">
                                    <i class="fas fa-cogs me-2"></i>
                                    Configuración
                                </a>
                            </li>
                            <li><hr class="dropdown-divider mx-3"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline w-100">
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
    <footer class="py-4 mt-5">
        <div class="container-fluid px-4">
            <div class="footer-content">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-landmark me-2 fa-lg"></i>
                            <strong>Sistema de Cuentas de Cobro Municipal</strong>
                        </div>
                        <small class="d-block mt-1 opacity-75">
                            Plataforma oficial para la gestión de cuentas de cobro de la administración municipal
                        </small>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="small">
                            <span class="opacity-75">Copyright &copy; {{ date('Y') }} - Alcaldía Municipal</span>
                            <div class="mt-1">
                                <a href="#" class="text-white text-decoration-none opacity-75 me-3">Políticas</a>
                                <a href="#" class="text-white text-decoration-none opacity-75 me-3">Términos</a>
                                <a href="#" class="text-white text-decoration-none opacity-75">Soporte</a>
                            </div>
                        </div>
                    </div>
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
            
            // Agregar clase active al enlace actual
            const currentPath = window.location.pathname;
            document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>