<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Clase</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            padding: 40px;
        }

        form {
            background-color: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            max-width: 500px;
        }

        input[type="tel"],
        input[type="text"],
        input[type="time"],
        input[type="number"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        h1 {
            color: #e74c3c;
        }
    </style>
</head>
<body>

    <form action="" method="post">
        <label for="clase">Clase</label>
        <input type="tel" name="clase" id="clase" required>
        <input type="submit" value="Modificar">
    </form>

    <?php
    include '../conexion.php';

    // Verificar si se ingresó una clase
    if (isset($_REQUEST["clase"])) {
        $clase = $_REQUEST["clase"];

        $SQL = "SELECT * FROM clases WHERE clase = '$clase' LIMIT 1";
        $res = $con->query($SQL);

        if ($res->num_rows == 0) {
            echo "<h1>No existe una clase con ese número de teléfono</h1>";
        } else {
            $registro = $res->fetch_assoc();

            echo "
                <form method='post'>
                    <h2>Modificar Clase</h2>

                    <label>Fecha:</label>
                    <input name='fecha' value='$registro[fecha]' type='text'> 

                    <label>Hora:</label>
                    <input name='hora' value='$registro[hora]' type='time'> 

                    <label>Cupo máximo:</label>
                    <input name='cupo_max' value='$registro[cupo_max]' type='number'> 

                    <label>Teléfono:</label>
                    <input name='telefono' value='$registro[clase]' type='tel'> 

                    <input name='id_clases' value='$registro[id_clases]' type='hidden'> 

                    <input type='submit' value='Modificar'>
                </form>
            ";
        }
    }

    // Procesar la modificación
    if (isset($_REQUEST['id_clases'])) {
        $id_clases = $_REQUEST["id_clases"];
        $clase = $_REQUEST["clase"];
        $fecha = $_REQUEST["fecha"];
        $hora = $_REQUEST["hora"];
        $cupo_max = $_REQUEST["cupo_max"];

        $SQL = "UPDATE clases 
                SET clase='$clase',
                    fecha='$fecha',
                    hora='$hora',
                    cupo_max='$cupo_max' 
                WHERE id_clases = $id_clases";

        $con->query($SQL);

        header('Location: formulario_clases.php');
        exit;
    }
    ?>

</body>
</html>
