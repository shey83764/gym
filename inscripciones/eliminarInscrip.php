<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Inscripción</title>
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

        input[type="tel"] {
            padding: 0.8rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
        }

        input[type="submit"] {
            background-color: #e74c3c;
            color: white;
            font-weight: bold;
            padding: 0.8rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #c0392b;
        }

        .message {
            margin-top: 1rem;
            font-size: 1.2rem;
            color: #333;
        }

        .confirmation-links a {
            color: #4a90e2;
            font-weight: bold;
            margin-right: 10px;
            text-decoration: none;
        }

        .confirmation-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<header>
    <h2>Eliminar inscripción por DNI</h2>
</header>

<main>
    <form action="" method="post">
        <label for="contacto">DNI:</label>
        <input type="tel" name="contacto" required placeholder="Ingresa el DNI">
        <input type="submit" value="Eliminar">
    </form>

    <?php
    include '../conexion.php';

    if (isset($_REQUEST["contacto"])) {
        $contacto = $_REQUEST["contacto"];

        $SQL = "SELECT * FROM inscripciones WHERE dni = '$contacto' LIMIT 1";
        $res = $con->query($SQL);

        if ($res->num_rows == 0) {
            echo "<div class='message'>No existe un turno con ese DNI.</div>";
        } else {
            $registro = $res->fetch_assoc();

            echo "
                <div class='message'>
                    Inscripción encontrada:<br>
                    Nombre: {$registro['nombre']}<br>
                    Apellido: {$registro['apellido']}<br>
                    DNI: {$registro['dni']}<br>
                    Fecha: {$registro['fecha']}<br>
                    ¿Estás seguro que deseas eliminar esta inscripción?<br>
                    <div class='confirmation-links'>
                        <a href='?id={$registro['id_inscrip']}'>Sí</a>
                        <a href='formulario_inscrip.php'>No</a>
                    </div>
                </div>";
        }
    }

    if (isset($_REQUEST["id"])) {
        $id = $_REQUEST["id"];

        $SQL = "DELETE FROM inscripciones WHERE id_inscrip = $id";
        if ($con->query($SQL)) {
            echo "<div class='message'>Inscripción eliminada exitosamente.</div>";
        } else {
            echo "<div class='message'>Error al eliminar la inscripción.</div>";
        }
    }
    ?>
</main>

</body>
</html>
