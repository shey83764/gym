<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Reserva tu turno para el gimnasio</h1>

    <form action="guardarInscrip.php" method="post">
        <label for="nombre"> Nombre</label>
        <input type="text" name="nombre">

        <label for="apellido"> Apellido</label>
        <input type="text" name="apellido">
        <label for="DNi"> DNi</label>
        <input type="number" name="DNi">

        <label for="fecha"> Fecha</label>
        <input type="date" name="fecha" id='fecha'>
        

        <input type="submit" value="Reservar">

    </form>
    <br>

    <a href="eliminarInscrip.php">Eliminar turno</a> 
    <br>
    <a href="modificarInscrip.php">Modificar turno</a>

    <h1 id="h1"></h1>
    <script src="index.js"></script>
</body>
</html>