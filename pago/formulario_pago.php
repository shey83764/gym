<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>
<body>
    <h1>Reserva tu turno</h1>
    <form action="guardar_pago.php" method="post">
    <label for="nombre">nombre</label>
    <input type="text" name="nombre">

    <label for="apellido">apellido</label>
    <input type="text" name="apellido">    
    
    <label for="dni">dni</label>
    <input type="number" name="dni"> 

    <label for="monto_pago">Monto del pago $
    <input type="number" name="monto_pago"></label>

        <label for="metodo_pago">Metodo de pago</label>
        <input type="text" name="metodo_pago">

        <input type="submit" value="Enviar">
    </form>
    <br>
    <a href="eliminar_pago.php">Eliminar pago </a> 
    <br>
    <a href="modificar_pago.php">Modificar pago</a>
    <br>
    <a href="visualizar_pago.php">Ver pago</a>
</body>
</html>