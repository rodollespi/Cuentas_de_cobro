<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Crear Cuenta de Cobro</h1>
    <a href="/dashboard">back</a>
    <form action="/cuentas" method="POST">
        @csrf
        <label for="cliente">Cliente:</label>
        <input type="text" id="cliente" name="cliente" required>
        <br>
        <label for="servicio">Servicio:</label>
        <input type="text" id="servicio" name="servicio" required>
        <br>
        <label for="monto">Monto:</label>
        <input type="number" id="monto" name="monto" required>
        <br>
        <button type="submit">Crear Cuenta de Cobro</button>
    </form>



</body>

</html>