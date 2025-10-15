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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
.login-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
}

.login-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 15px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
}

.navbar-brand {
    font-weight: bold;
    color: #1a202c !important;
}

.sidebar {
    background: #1c57ceff;
    min-height: calc(100vh - 56px);
}

.sidebar .nav-link {
    color: #e2e8f0;
    padding: 12px 20px;
    border-radius: 5px;
    margin: 2px 0;
}

.sidebar .nav-link:hover {
    background: #2d3748;
    color: #fff;
}

.sidebar .nav-link.active {
    background: #4a5568;
    color: #fff;
}

.main-content {
    background: #f7fafc;
    min-height: calc(100vh - 56px);
}
    </style>
    
    @stack('styles')
</head>
<body>
    @yield('content')
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>