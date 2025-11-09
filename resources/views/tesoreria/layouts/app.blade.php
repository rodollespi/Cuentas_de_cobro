<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Tesorería - @yield('title')</title>
    <!-- Bootstrap & FontAwesome (usados por las vistas de tesorería) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
    <style>
        /* Estilos compartidos para el área de Tesorería (copiados del dashboard) */
        body.tesoreria-body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #fff;
        }
        .navbar-custom { background-color: rgba(0,0,0,0.6); }
        .stats-card { transition: transform 0.2s, box-shadow 0.2s; background-color: rgba(255,255,255,0.1); border-radius: 0.5rem; padding: 1.5rem; text-align: center; }
        .stats-card:hover { transform: translateY(-5px); box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.3); }
    </style>
</head>
<body class="tesoreria-body">
    <div class="d-flex min-vh-100">
        <!-- Sidebar -->
        <aside class="bg-white bg-opacity-10 text-white p-3" style="width:250px;">
            <div class="p-3 fw-bold h5">Tesorería</div>
            <nav class="mt-3">
                <a href="{{ route('tesoreria.dashboard') }}" class="d-block px-3 py-2 text-white text-decoration-none rounded">Dashboard</a>
                <a href="{{ route('tesoreria.cuentas-cobro.index') }}" class="d-block px-3 py-2 text-white text-decoration-none rounded">Cuentas de Cobro</a>
                <a href="{{ route('tesoreria.historial') }}" class="d-block px-3 py-2 text-white text-decoration-none rounded">Historial de Pagos</a>
                <a href="{{ route('tesoreria.reportes') }}" class="d-block px-3 py-2 text-white text-decoration-none rounded">Reportes</a>
                <a href="{{ route('tesoreria.contratistas.aprobados') }}" class="d-block px-3 py-2 text-white text-decoration-none rounded">Contratistas Aprobados</a>
            </nav>
        </aside>

        <div class="flex-grow-1">
            <!-- Navbar superior (igual al dashboard) -->
            <nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top" style="background-color: #243a7eff;">
                <div class="container-fluid">
                    <a class="navbar-brand text-white" href="{{ route('tesoreria.dashboard') }}">
                        <i class="fas fa-coins me-2"></i>
                        Tesorería
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item"><a class="nav-link text-white" href="{{ route('tesoreria.cuentas-cobro.index') }}"><i class="fas fa-file-invoice-dollar me-1"></i> Cuentas de Cobro</a></li>
                            <li class="nav-item"><a class="nav-link text-white" href="{{ route('tesoreria.historial') }}"><i class="fas fa-history me-1"></i> Historial de Pagos</a></li>
                            <li class="nav-item"><a class="nav-link text-white" href="{{ route('tesoreria.reportes') }}"><i class="fas fa-chart-line me-1"></i> Reportes</a></li>
                            <li class="nav-item"><a class="nav-link text-white" href="{{ route('tesoreria.contratistas.aprobados') }}"><i class="fas fa-user-check me-1"></i> Contratistas Aprobados</a></li>
                        </ul>
                        <ul class="navbar-nav ms-auto">
                            @auth
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user-circle me-1"></i>
                                    {{ auth()->user()->name }}
                                    @if(auth()->user()->role)
                                    - <span class="badge bg-light text-dark">{{ ucfirst(auth()->user()->role->name) }}</span>
                                    @endif
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Perfil</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">@csrf
                                            <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i> Cerrar sesión</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            @endauth
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Contenido principal -->
            <main class="p-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
