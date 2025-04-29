<?php
include '../conexion.php';

$mensaje = "";
$membresias = [];

// Guardar nueva membresía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $precio = $_POST['precio'] ?? '';

    $stmt = $con->prepare("INSERT INTO membresia (nombre, descripcion, precio) VALUES (?, ?, ?)");
    if (!$stmt) {
        die("Error en la consulta: " . $con->error);
    }

    $stmt->bind_param("ssd", $nombre, $descripcion, $precio);

    if ($stmt->execute()) {
        $mensaje = "✅ Membresía registrada exitosamente.";
    } else {
        $mensaje = "❌ Error al registrar: " . $stmt->error;
    }
}

// Obtener membresías
$res = mysqli_query($con, "SELECT * FROM membresia ORDER BY id_membresia DESC");
if ($res) {
    while ($fila = mysqli_fetch_assoc($res)) {
        $membresias[] = $fila;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Membresías</title>
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

        h1, h2 {
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

        input[type="text"], input[type="number"], textarea {
            padding: 0.6rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            resize: vertical;
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

        .mensaje {
            text-align: center;
            margin: 1rem 0;
            font-weight: bold;
            color: green;
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
    <h1>Gestión de Membresías</h1>
</header>

<main>
    <form method="POST">
        <label for="nombre">Nombre de la membresía:</label>
        <input type="text" name="nombre" required>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" rows="3" required></textarea>

        <label for="precio">Precio:</label>
        <input type="number" step="0.01" name="precio" required>

        <input type="submit" value="Registrar">
    </form>

    <?php if ($mensaje): ?>
        <div class="mensaje"><?= $mensaje ?></div>
    <?php endif; ?>

    <h2>Membresías registradas</h2>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($membresias)): ?>
                <tr><td colspan="3">No hay membresías registradas.</td></tr>
            <?php else: ?>
                <?php foreach ($membresias as $m): ?>
                    <tr>
                        <td><?= htmlspecialchars($m['nombre']) ?></td>
                        <td><?= htmlspecialchars($m['descripcion']) ?></td>
                        <td>$<?= number_format($m['precio'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</main>

</body>
</html>
