<?php
include '../conexion.php';

// Guardar inscripción
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $dni = $_POST['dni'] ?? '';
    $fecha = $_POST['fecha'] ?? '';

    // Escapar datos para evitar SQL Injection básico
    $nombre = mysqli_real_escape_string($con, $nombre);
    $apellido = mysqli_real_escape_string($con, $apellido);
    $dni = mysqli_real_escape_string($con, $dni);
    $fecha = mysqli_real_escape_string($con, $fecha);

    $sql = "INSERT INTO inscripciones (nombre, apellido, dni, fecha) 
            VALUES ('$nombre', '$apellido', '$dni', '$fecha')";

    if (mysqli_query($con, $sql)) {
        echo "<script>alert('Turno reservado exitosamente');</script>";
    } else {
        echo "Error al guardar: " . mysqli_error($con);
    }
}

// Obtener inscripciones registradas
$registros = mysqli_query($con, "SELECT * FROM inscripciones ORDER BY id_inscrip DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva tu turno</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #6a89cc;
            color: white;
            padding: 1rem;
            text-align: center;
        }

        main {
            max-width: 700px;
            margin: 2rem auto;
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        h1 {
            margin-top: 0;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        label {
            font-weight: bold;
        }

        input[type="text"], input[type="number"], input[type="date"] {
            padding: 0.6rem;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        input[type="submit"] {
            background-color: #38ada9;
            color: white;
            font-weight: bold;
            padding: 0.7rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #3dc1d3;
        }

        .links {
            margin-top: 1rem;
        }

        .links a {
            margin-right: 1rem;
            color: #40739e;
            text-decoration: none;
        }

        table {
            width: 100%;
            margin-top: 2rem;
            border-collapse: collapse;
        }

        th, td {
            padding: 0.8rem;
            border-bottom: 1px solid #ccc;
        }

        th {
            background-color: #dff9fb;
        }

        td {
            background-color: #ffffff;
        }
    </style>
</head>
<body>
    <header>
        <h1>Reserva tu turno para el gimnasio</h1>
    </header>

    <main>
        <form action="" method="post">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" required>

            <label for="apellido">Apellido</label>
            <input type="text" name="apellido" required>

            <label for="dni">DNI</label>
            <input type="number" name="dni" required>

            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" id="fecha" required>

            <input type="submit" value="Reservar">
        </form>

        <div class="links">
            <a href="eliminarInscrip.php">Eliminar turno</a>
            <a href="modificarInscrip.php">Modificar turno</a>
        </div>

        <h2>Turnos registrados</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>DNI</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($registros && mysqli_num_rows($registros) > 0) {
                    while ($fila = mysqli_fetch_assoc($registros)) {
                        echo "<tr>
                            <td>{$fila['nombre']}</td>
                            <td>{$fila['apellido']}</td>
                            <td>{$fila['dni']}</td>
                            <td>{$fila['fecha']}</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No hay turnos registrados.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>
</body>
</html>
