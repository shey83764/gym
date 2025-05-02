<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Inscripción</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #4a90e2;
            color: white;
            padding: 20px;
            text-align: center;
        }

        main {
            max-width: 700px;
            margin: 2rem auto;
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-top: 0;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        label {
            font-weight: bold;
            color: #444;
        }

        input[type="text"], input[type="number"], input[type="date"] {
            padding: 0.8rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
        }

        input[type="submit"] {
            background-color: #38ada9;
            color: white;
            font-weight: bold;
            padding: 0.8rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #3dc1d3;
        }

    </style>
</head>
<body>

<header>
    <h2>Modificar turno por DNI</h2>
</header>

<main>
    <form action="" method="post">
        <label for="dni">DNI:</label>
        <input type="number" name="dni" required>
        <input type="submit" value="Buscar">
    </form>

    <?php
    include '../conexion.php';

    if (isset($_POST["dni"])) {
        $dni = $_POST["dni"];

        $SQL = "SELECT * FROM inscripciones WHERE dni = '$dni' LIMIT 1";
        $res = $con->query($SQL);

        if ($res->num_rows == 0) {
            echo "<h3>No existe un turno con ese DNI.</h3>";
        } else {
            $registro = $res->fetch_assoc();

            echo "
            <h3>Modificar inscripción</h3>
            <form method='post' action=''>
                <label for='nombre'>Nombre:</label>
                <input name='nombre' type='text' value='{$registro['nombre']}' required><br>

                <label for='apellido'>Apellido:</label>
                <input name='apellido' type='text' value='{$registro['apellido']}' required><br>

                <label for='dni'>DNI:</label>
                <input name='dni_nuevo' type='number' value='{$registro['dni']}' required><br>

                <label for='fecha'>Fecha:</label>
                <input name='fecha' type='date' value='{$registro['fecha']}' required><br>

                <input name='id' type='hidden' value='{$registro['id_inscrip']}'>
                <input type='submit' name='modificar' value='Modificar'>
            </form>";
        }
    }

    // Procesar la modificación
    if (isset($_POST['modificar']) && isset($_POST['id'])) {
        $id = $_POST["id"];
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $dni_nuevo = $_POST["dni_nuevo"];
        $fecha = $_POST["fecha"];

        $SQL = "UPDATE inscripciones 
                SET nombre = '$nombre', 
                    apellido = '$apellido', 
                    dni = '$dni_nuevo', 
                    fecha = '$fecha' 
                WHERE id_inscrip = $id";

        if ($con->query($SQL)) {
            header('Location: formulario_inscrip.php');
            exit;
        } else {
            echo "<p>Error al modificar el registro.</p>";
        }
    }
    ?>
</main>

</body>
</html>
