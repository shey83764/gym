<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar turno</title>
</head>
<body>
    <form action="" method="post">
        Contacto:
        <input type="tel" name="contacto">
        <input type="submit" value="Modificar">
    </form>

    <?php
    include '../conexion.php';

    // Verificar si se recibió el contacto
    if (isset($_REQUEST["contacto"])) {
        $contacto = $_REQUEST["contacto"];

        // Buscar el turno con el teléfono ingresado
        $SQL = "SELECT * FROM membresia WHERE telefono = '$contacto' LIMIT 1"; 
        $res = $con->query($SQL);

        if ($res->num_rows == 0) {
            echo "<h1>No existe turno con ese número de teléfono</h1>";
        } else {
            $registro = $res->fetch_assoc();

            // Crear el formulario con los datos cargados
            echo "
                <form method='post'>
                    <h2>Modificar Turno</h2><hr> <br> 

                    telefono: 
                    <input name='telefono' value='$registro[telefono]' type=number'> 
                    <br> 

                    Precio: 
                    <input name='precio' value='$registro[precio]' type='number' step='0.01'> 
                    <br> 

                    Tipo de Membresía: 
                    <input name='tipo_membre' value='$registro[tipo_membre]' type='text'> 
                    <br> 

                    <input name='id' value='$registro[id_membresia]' type='hidden'> 
                    <br> 
                    
                    <input type='submit' value='Modificar'>
                </form>
            ";
        }
    }

    // Procesar la modificación si se envían los datos
    if (isset($_REQUEST['id_membresia'])) {
        $id = $_REQUEST["id_membresia"];
        $telefono = $_REQUEST["telefono"];
        $precio = $_REQUEST["precio"];
        $tipo_membre = $_REQUEST["tipo_membre"];

        // Actualizar el turno con los nuevos datos
        $SQL = "UPDATE membresia 
                SET  
                    telefono='$telefono',
                    precio='$precio',
                    tipo_membre='$tipo_membre' 
                WHERE id_membresia = '$id'";

        $con->query($SQL);

        // Redirigir al formulario
        header('location: formulario_membre.php');
    }
    ?>

</body>
</html>
