<?php
include '../conexion.php';

$mensaje = "";
$pagos = [];

// Procesar el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_cliente = $_POST['id_cliente'] ?? 0;
    $id_membresia = $_POST['id_membresia'] ?? 0;
    $nombre = $_POST['nombre'] ?? '';
    $dni = $_POST['dni'] ?? '';
    $monto = $_POST['monto_pago'] ?? '';
    $metodo = $_POST['metodo_pago'] ?? '';

    $stmt = $con->prepare("INSERT INTO pago (id_cliente, id_membresia, nombre, dni, monto_pago, metodo_pago) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Error al preparar la consulta: " . $con->error);
    }

    $stmt->bind_param("iissds", $id_cliente, $id_membresia, $nombre, $dni, $monto, $metodo);

    if ($stmt->execute()) {
        $mensaje = "✅ Pago guardado correctamente.";
    } else {
        $mensaje = "❌ Error al guardar el pago: " . $stmt->error;
    }
}

// Obtener pagos existentes
$consulta = "SELECT * FROM pago ORDER BY id_pago DESC";
$res = mysqli_query($con, $consulta);
if ($res) {
    while ($fila = mysqli_fetch_assoc($res)) {
        $pagos[] = $fila;
    }
}

// Eliminar pago
if (isset($_GET['eliminar'])) {
    $id_pago = $_GET['eliminar'];
    $delete_sql = "DELETE FROM pago WHERE id_pago = ?";
    $stmt = $con->prepare($delete_sql);
    $stmt->bind_param("i", $id_pago);
    
    if ($stmt->execute()) {
        header("Location: formulario_pago.php"); // Redirigir después de eliminar
    } else {
        $mensaje = "❌ Error al eliminar el pago: " . $stmt->error;
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Pagos</title>
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

        input[type="text"], input[type="number"], input[type="date"], select {
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

        .acciones {
            display: flex;
            gap: 1rem;
        }

        .acciones a {
            color: #3498db;
            text-decoration: none;
            padding: 0.4rem;
            background-color: #f0f0f0;
            border-radius: 6px;
        }

        .acciones a:hover {
            background-color: #dfe6e9;
        }

    </style>
</head>
<body>

<header>
    <h1>Registro de Pagos</h1>
</header>

<main>
    <form method="POST">
        <label for="id_cliente">Cliente:</label>
        <select name="id_cliente" required>
            <option value="">Seleccione un cliente</option>
            <?php
            $clientes_res = mysqli_query($con, "SELECT id_cliente, nombre FROM clientes");
            while ($cliente = mysqli_fetch_assoc($clientes_res)) {
                echo "<option value='{$cliente['id_cliente']}'>{$cliente['nombre']}</option>";
            }
            ?>
        </select>

        <label for="id_membresia">Membresía:</label>
        <select name="id_membresia" required>
            <option value="">Seleccione una membresía</option>
            <?php
            $membresias_res = mysqli_query($con, "SELECT id_membresia, nombre FROM membresia");
            while ($membresia = mysqli_fetch_assoc($membresias_res)) {
                echo "<option value='{$membresia['id_membresia']}'>{$membresia['nombre']}</option>";
            }
            ?>
        </select>

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required>

        <label for="dni">DNI:</label>
        <input type="text" name="dni" required>

        <label for="monto_pago">Monto del pago:</label>
        <input type="number" step="0.01" name="monto_pago" required>

        <label for="metodo_pago">Método de pago:</label>
        <input type="text" name="metodo_pago" required>

        <input type="submit" value="Guardar">
    </form>

    <?php if ($mensaje): ?>
        <div class="mensaje"><?= $mensaje ?></div>
    <?php endif; ?>

    <h2>Pagos registrados</h2>
    <table>
        <thead>
        <tr>
            <th>Nombre</th>
            <th>DNI</th>
            <th>Monto</th>
            <th>Método</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($pagos as $pago): ?>
            <tr>
                <td><?= htmlspecialchars($pago['nombre']) ?></td>
                <td><?= htmlspecialchars($pago['dni']) ?></td>
                <td>$<?= number_format($pago['monto_pago'], 2) ?></td>
                <td><?= htmlspecialchars($pago['metodo_pago']) ?></td>
                <td class="acciones">
                    <a href="modificar_pago.php?id_pago=<?= $pago['id_pago'] ?>">Modificar</a>
                    <a href="?eliminar_pago.php=<?= $pago['id_pago'] ?>" onclick="return confirm('¿Está seguro de que desea eliminar este pago?');">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</main>

</body>
</html>
