<?php
include '../conexion.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (
        isset($_POST['nombre']) &&
        isset($_POST['apellido']) &&
        isset($_POST['dni']) &&
        isset($_POST['puesto'])&&
        isset($_POST['telefono'])
    ) {
        $nombre = mysqli_real_escape_string($con, $_POST['nombre']);
        $apellido = mysqli_real_escape_string($con, $_POST['apellido']);
        $dni = mysqli_real_escape_string($con, $_POST['dni']);
        $puestos = mysqli_real_escape_string($con, $_POST['puesto']);
        $telefono = mysqli_real_escape_string($con, $_POST['telefono']);

        $sql = "INSERT INTO empleados (nombre, apellido, dni, telefono,puesto)
                VALUES ('$nombre', '$apellido', '$dni', '$telefono','$puesto')";

        if (mysqli_query($con, $sql)) {
            $mensaje = "✅ Empleado guardado correctamente.";
        } else {
            $mensaje = "❌ Error al guardar: " . mysqli_error($con);
        }
    } else {
        $mensaje = "⚠️ Por favor completá todos los campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Empleado</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #fef6e4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #a3c4f3;
            color: #fff;
            text-align: center;
            padding: 1.5rem;
        }

        main {
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        h2 {
            color: #d4a5a5;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        input, button {
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
        }

        button {
            background-color: #b8e1dd;
            color: #333;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #99d2c6;
        }

        .mensaje {
            margin-top: 1rem;
            padding: 0.7rem;
            border-radius: 8px;
            font-weight: bold;
        }

        .mensaje.success {
            background-color: #d4edda;
            color: #155724;
        }

        .mensaje.error {
            background-color: #f8d7da;
            color: #721c24;
        }

        @media (max-width: 600px) {
            main {
                margin: 1rem;
                padding: 1rem;
            }

            input, button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>PowerFit</h1>
        <p>Registro de Empleados</p>
    </header>

    <main>
        <h2>Nuevo Empleado</h2>
        <form method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required>

            <label for="apellido">Apellido:</label>
            <input type="text" name="apellido" id="apellido" required>

            <label for="dni">DNI:</label>
            <input type="text" name="dni" id="dni" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" id="telefono" required>
            <label for="puesto">Puesto:</label>
            <input type="text" name="puesto" id="puesto" required>

            <button type="submit">Guardar Empleado</button>
        </form>

        <?php if (!empty($mensaje)): ?>
            <div class="mensaje <?= str_contains($mensaje, '✅') ? 'success' : 'error' ?>">
                <?= $mensaje ?>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>
