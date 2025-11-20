<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Tesorería</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #fff;
        }
        .navbar-custom {
            background-color: rgba(0, 0, 0, 0.6);
        }
        .stats-card { 
            transition: transform 0.2s, box-shadow 0.2s; 
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 0.5rem;
            padding: 1.5rem;
            text-align: center;
        }
        .stats-card:hover { 
            transform: translateY(-5px); 
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.3); 
        }
        .btn-outline-light {
        --bs-btn-color: #0a58ca;
        --bs-btn-border-color: #000;
        }
        .icon-circle { 
            width: 48px; height: 48px; border-radius: 50%; 
            display: flex; align-items: center; justify-content: center; 
            font-size: 1.5rem; margin-bottom: 0.5rem;
        }
        .bg-primary-light { background-color: rgba(78,115,223,0.3); }
        .bg-success-light { background-color: rgba(28,200,138,0.3); }
        .bg-warning-light { background-color: rgba(246,194,62,0.3); }
        .bg-danger-light { background-color: rgba(231,74,59,0.3); }
    </style>
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top" style="background-color: #243a7eff;">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('tesoreria.dashboard') }}">  
            <i class="fas fa-coins me-2"></i>
            Tesorería
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <!-- Enlaces de Tesorería -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('tesoreria.cuentas-cobro.index') }}">
                        <i class="fas fa-file-invoice-dollar me-1"></i>
                        Cuentas de Cobro
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('tesoreria.historial') }}">
                        <i class="fas fa-history me-1"></i>
                        Historial de Pagos
                    </a>
                </li>

                <li class="nav-item">
                   <a class="nav-link" href="{{ route('tesoreria.contratistas.aprobados') }}">
                      <i class="fas fa-user-check me-1"></i>
                      Contratistas Aprobados
                  </a>
               </li>

            </ul>

            <ul class="navbar-nav ms-auto">
                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-1"></i>
                        {{ auth()->user()->name }}
                        @if(auth()->user()->role)
                        - <span class="badge bg-light text-dark">{{ ucfirst(auth()->user()->role->name) }}</span>
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user me-2"></i> Perfil
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <!-- Logout con POST -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i> Cerrar sesión
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>



    <!-- Contenido Dashboard -->
    <div class="container py-4">
        <h1 class="mb-4 text-center">Dashboard Tesorería</h1>

        <div class="row g-4 mb-4">
            <!-- Pendientes -->
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="icon-circle bg-warning-light text-warning">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <p>Cuentas Pendientes</p>
                    <h3>{{ $stats['pendientes'] ?? 0 }}</h3>
                </div>
            </div>
            <!-- Pagos hoy -->
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="icon-circle bg-success-light text-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <p>Pagos Hoy</p>
                    <h3>{{ $stats['pagados_hoy'] ?? 0 }}</h3>
                </div>
            </div>
            <!-- Total por pagar -->
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="icon-circle bg-primary-light text-primary">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <p>Total por Pagar</p>
                    <h3>${{ number_format($stats['total_por_pagar'] ?? 0, 2) }}</h3>
                </div>
            </div>
            <!-- Pagos mes -->
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="icon-circle bg-danger-light text-danger">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <p>Pagos este Mes</p>
                    <h3>{{ $stats['pagos_mes'] ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <!-- Cuentas recientes -->
        <div class="card bg-white bg-opacity-10 text-white">
            <div class="card-header">
                <h5><i class="fas fa-list me-1"></i> Cuentas de Cobro Recientes</h5>
            </div>
            <div class="card-body p-0">
                @if(isset($cuentasRecientes) && $cuentasRecientes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover text-white mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Contratista</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Fecha Emisión</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cuentasRecientes as $cuenta)
                            <tr>
                                <td>{{ $cuenta->id }}</td>
                                <td>{{ $cuenta->user?->name ?? 'N/A' }}</td>
                                <td>${{ number_format($cuenta->total, 2) }}</td>
                                <td>{{ ucfirst($cuenta->estado) }}</td>
                                <td>{{ $cuenta->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('tesoreria.cuentas-cobro.show', $cuenta->id) }}" class="btn btn-sm btn-outline-light">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-center py-3">No hay cuentas recientes.</p>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
