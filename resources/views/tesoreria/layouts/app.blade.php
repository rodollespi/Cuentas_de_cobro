<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Tesorería - @yield('title')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md">
            <div class="p-6 font-bold text-xl text-gray-800">Tesorería</div>
            <nav class="mt-6">
                <a href="{{ route('tesoreria.dashboard') }}" class="block px-6 py-3 text-gray-700 hover:bg-gray-200 rounded">Dashboard</a>
                <a href="{{ route('tesoreria.cuentas-cobro.index') }}" class="block px-6 py-3 text-gray-700 hover:bg-gray-200 rounded">Cuentas de Cobro</a>
                <a href="{{ route('tesoreria.historial') }}" class="block px-6 py-3 text-gray-700 hover:bg-gray-200 rounded">Historial de Pagos</a>
                <a href="{{ route('tesoreria.reportes') }}" class="block px-6 py-3 text-gray-700 hover:bg-gray-200 rounded">Reportes</a>
            </nav>
        </aside>

        <!-- Contenido principal -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
