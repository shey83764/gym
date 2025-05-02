<?php
include '../conexion.php';

$mensaje = "";
$membresias = [];

// Guardar nueva membresía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo_membre = $_POST['tipo_membre'] ?? '';
    $id_inscrip = $_POST['id_inscrip'] ?? null;
    $precio = $_POST['precio'] ?? '';

    $stmt = $con->prepare("INSERT INTO membresia (tipo_membre, precio, id_inscrip) VALUES (?, ?, ?)");
    if (!$stmt) {
        die("Error en la consulta: " . $con->error);
    }

    $stmt->bind_param("sdi", $tipo_membre, $precio, $id_inscrip);

    if ($stmt->execute()) {
        $mensaje = "✅ Membresía registrada exitosamente.";
    } else {
        $mensaje = "❌ Error al registrar: " . $stmt->error;
    }
}

// Obtener membresías con JOIN para incluir nombre de inscripción
$res = mysqli_query($con, "
    SELECT m.id_membresia, m.tipo_membre, m.precio, m.id_inscrip, i.nombre 
    FROM membresia m
    INNER JOIN inscripciones i ON m.id_inscrip = i.id_inscrip
    ORDER BY m.id_membresia DESC
");
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

        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        label {
            font-weight: bold;
        }

        input[type="text"], input[type="number"], select {
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

        .btn-eliminar {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 0.4rem 0.8rem;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-modificar {
            background-color: #f6b93b;
            color: white;
            border: none;
            padding: 0.4rem 0.8rem;
            border-radius: 4px;
            cursor: pointer;
        }

        td:last-child {
            text-align: right;
        }
    </style>
</head>
<body>

<header>
    <h1>Gestión de Membresías</h1>
</header>

<main>
    <form method="POST">
        <label for="tipo_membre">Nombre de la membresía:</label>
        <input type="text" name="tipo_membre" required>

        <label for="precio">Precio:</label>
        <input type="number" step="0.01" name="precio" required>

        <label for="id_inscrip">Inscripción asociada:</label>
        <select name="id_inscrip" required>
            <option value="">Seleccione una inscripción</option>
            <?php
            $res_inscrip = mysqli_query($con, "SELECT id_inscrip, nombre FROM inscripciones");
            while ($row = mysqli_fetch_assoc($res_inscrip)) {
                echo "<option value='{$row['id_inscrip']}'>{$row['id_inscrip']} - {$row['nombre']}</option>";
            }
            ?>
        </select>

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
                <th>Precio</th>
                <th>Inscripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($membresias)): ?>
                <tr><td colspan="4">No hay membresías registradas.</td></tr>
            <?php else: ?>
                <?php foreach ($membresias as $m): ?>
                    <tr>
                        <td><?= htmlspecialchars($m['tipo_membre']) ?></td>
                        <td>$<?= number_format($m['precio'], 2) ?></td>
                        <td><?= htmlspecialchars($m['id_inscrip'] . ' - ' . $m['nombre']) ?></td>
                        <td>
                            <form action="modificarMem.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id_membresia" value="<?= $m['id_membresia'] ?>">
                                <input type="submit" value="Modificar" class="btn-modificar">
                            </form>
                            <form action="eliminarMem.php" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar esta membresía?');">
                                <input type="hidden" name="id_membresia" value="<?= $m['id_membresia'] ?>">
                                <input type="submit" value="Eliminar" class="btn-eliminar">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</main>
</body>
</html>
