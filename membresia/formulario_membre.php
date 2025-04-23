<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva tu turno para el gimnasio</title>
</head>
<body>
    <h1>Cual es tu tipo de membresia</h1>

    <form action="guardarMEm.php" method="post">
        <label for="nombre">Ingrese el nombre</label>
        <input type="text" name="nombre"> 

        <label for="apellido">ingrese su apellido</label>
        <input type="text" name="apellido">

        <label for="DNi">ingrese su DNi</label>
        <input type="number" name="DNi">

        <label for="contacto">Contacto</label>
        <input type="tel" name="telefono" required>

        <label for="precio">Precio</label>
        <input type="number" name="precio" step="0.01" required>

        <label for="tipo_membre">Tipo de Membresía</label>
        <select name="tipo_membre" required>
            <option value="Mensual">Mensual</option>
            <option value="Trimestral">Trimestral</option>
            <option value="Anual">Anual</option>
        </select>


        <input type="submit" value="Reservar">
    </form>
    <br>

    <a href="eliminarMem.php">Eliminar turno</a> 
    <br>
    <a href="modificarMem.php">Modificar turno</a>
    <br>
    <a href="visializar_mem.php">Ver membresias</a>

    <h1 id="h1"></h1>
    <script src="index.js"></script>
</body>
</html>
