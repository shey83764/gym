<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Clase</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f2f2f2;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin-bottom: 20px;
        }

        input[type="tel"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #e74c3c;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #c0392b;
        }

        .resultado {
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .resultado a {
            display: inline-block;
            margin-right: 10px;
            margin-top: 10px;
            text-decoration: none;
            color: #3498db;
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
        <input type="submit" value="Eliminar">
    </form>

    <?php
    include '../conexion.php';

    if (isset($_REQUEST["clase"])) {
        $clase = $_REQUEST["clase"];

        $SQL = "SELECT * FROM clases WHERE clase = '$clase' LIMIT 1";
        $res = $con->query($SQL);

        if ($res->num_rows == 0) {
            echo "<div class='resultado'><h1>No existe clase con ese número</h1></div>";
        } else {
            $registro = $res->fetch_assoc();
            echo "<div class='resultado'>
                    <h2>Clase encontrada</h2>
                    <p><strong>Fecha:</strong> $registro[fecha]</p>
                    <p><strong>Hora:</strong> $registro[hora]</p>
                    <p><strong>Nombre:</strong> $registro[clase]</p>
                    <p>¿Está seguro que quiere eliminar esta clase?</p>
                    <a href='?id=$registro[id_clases]'>Sí</a>
                    <a href='formulario_clases.php'>No</a>
                </div>";
        }
    }

    if (isset($_REQUEST["id"])) {
        include '../conexion.php';
        $id = $_REQUEST["id"];

        $SQL = "DELETE FROM clases WHERE id_clases = $id";
        $con->query($SQL);

        header('Location: formulario_clases.php');
        exit;
    }
    ?>
</body>
</html>
