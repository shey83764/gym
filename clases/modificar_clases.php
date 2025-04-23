<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar turno</title>
</head>
<body>
    <form action="" method="post">
        contacto
        <input type="tel" name="contacto">

        <input type="submit" value="Modificar">
    </form>
    <?php
    include '../conexion.php';

    // Verificar si el contacto fue enviado
    if (isset($_REQUEST["contacto"])) {

        // Obtener el número de contacto del formulario
        $contacto = $_REQUEST["contacto"];

        // Consulta para obtener el registro que coincida con el teléfono
        $SQL = "SELECT * FROM clases WHERE telefono = '$contacto' LIMIT 1";

        // Ejecutar la consulta
        $res = $con->query($SQL);

        // Si no se encuentra el turno, mostrar mensaje
        if ($res->num_rows == 0) {
            echo "<h1>No existe un turno con ese número de teléfono</h1>";
        } else {
            // Si se encuentra el turno, mostrar el formulario con los datos
            $registro = $res->fetch_assoc();

            echo "
                <form method='post'>
                    gimnasio <hr> <br> 

                    fecha: 
                    <input name='nombre' value='$registro[fecha]' type='text'> 
                    <br> 

                    hora: 
                    <input name='hora' value='$registro[hora]' type='time'> 
                    <br> 

                    cupo máximo: 
                    <input name='cupo_max' value='$registro[cupo_max]' type='number'> 
                    <br> 

                    telefono: 
                    <input name='cupo_max' value='$registro[cupo_max]' type='number'> 
                    <br> 


                    <input name='id' value='$registro[id_clase]' type='hidden'> 
                    <br> 

                    <input type='submit' value='Modificar'>
                </form>
                ";
        }
    }

    // Si se envía el formulario para modificar, actualizar los datos
    if (isset($_REQUEST['id_clase'])) {

        $id_clase = $_REQUEST["id_clase"];
        $telefono=$_REQUEST["telefono"];
        $fecha = $_REQUEST["fecha"];
        $hora = $_REQUEST["hora"];
        $cupo_max = $_REQUEST["cupo_max"];

        // Consulta para actualizar los datos del turno
        $SQL = "UPDATE clases 
                SET nombre='$nombre', 
                    telefono='$telefono',
                    fecha='$fecha',
                    cupo_max='$cupo_max',
                    hora='$hora', 
                    cupo_max='$cupo_max' 
                WHERE id_clase = $id_clase";

        // Ejecutar la consulta de actualización
        $con->query($SQL);

        // Redirigir al formulario
        header('Location: formulario_clases.php');
    }
    ?>
</body>
</html>
