<?php
include '../conexion.php';

$mensaje = "";
$pagos = [];

// Obtener datos de clientes para el formulario y JavaScript
$clientes_res = mysqli_query($con, "SELECT id_cliente, nombre, apellido, telefono, dni FROM clientes");
$clientes_data = [];
while ($c = mysqli_fetch_assoc($clientes_res)) {
    $clientes_data[$c['id_cliente']] = $c;
}

// Obtener datos de membresías para el formulario y JavaScript
$membresias_res = mysqli_query($con, "SELECT id_membresia, tipo_membre, precio FROM membresia");
$membresias_data = [];
while ($m = mysqli_fetch_assoc($membresias_res)) {
    $membresias_data[$m['id_membresia']] = $m;
}

// Procesar formulario
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

// Obtener pagos
$consulta = "
    SELECT p.*, c.nombre AS nombre_cliente, m.tipo_membre, m.precio 
    FROM pago p
    JOIN clientes c ON p.id_cliente = c.id_cliente
    JOIN membresia m ON p.id_membresia = m.id_membresia
    ORDER BY p.id_pago DESC
";
$res = mysqli_query($con, $consulta);
if ($res) {
    while ($fila = mysqli_fetch_assoc($res)) {
        $pagos[] = $fila;
    }
}

// Eliminar
if (isset($_GET['eliminar'])) {
    $id_pago = $_GET['eliminar'];
    $delete_sql = "DELETE FROM pago WHERE id_pago = ?";
    $stmt = $con->prepare($delete_sql);
    $stmt->bind_param("i", $id_pago);

    if ($stmt->execute()) {
        header("Location: formulario_pago.php");
        exit;
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
        body { font-family: 'Segoe UI', sans-serif; background-color: #f3f4f6; margin: 0; padding: 0; }
        header { background-color: #6a89cc; color: white; padding: 1rem; text-align: center; }
        main { max-width: 900px; margin: 2rem auto; background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        h1, h2 { margin-top: 0; color: #333; }
        form { display: flex; flex-direction: column; gap: 1rem; }
        label { font-weight: bold; }
        input, select { padding: 0.6rem; border: 1px solid #ccc; border-radius: 6px; }
        input[type="submit"] { background-color: #38ada9; color: white; font-weight: bold; cursor: pointer; }
        input[type="submit"]:hover { background-color: #3dc1d3; }
        .mensaje { text-align: center; margin: 1rem 0; font-weight: bold; color: green; }
        table { width: 100%; margin-top: 2rem; border-collapse: collapse; }
        th, td { padding: 0.8rem; border-bottom: 1px solid #ccc; }
        th { background-color: #dff9fb; }
        .acciones { display: flex; gap: 1rem; }
        .acciones a { color: #3498db; text-decoration: none; padding: 0.4rem; background-color: #f0f0f0; border-radius: 6px; }
        .acciones a:hover { background-color: #dfe6e9; }
    </style>
</head>
<body>

<header>
    <h1>Registro de Pagos</h1>
</header>

<main>
    <form method="POST">
        <label for="id_cliente">Cliente:</label>
        <select name="id_cliente" onchange="actualizarDatosCliente()" required>
            <option value="">Seleccione un cliente</option>
            <?php foreach ($clientes_data as $id => $c): ?>
                <option value="<?= $id ?>"><?= $c['nombre'] . ' ' . $c['apellido'] ?></option>
            <?php endforeach; ?>
        </select>

        <label>Nombre:</label>
        <input type="text" name="nombre" id="nombre" readonly>

        <label>Apellido:</label>
        <input type="text" id="apellido" readonly>

        <label>Teléfono:</label>
        <input type="text" id="telefono" readonly>

        <label>DNI:</label>
        <input type="text" name="dni" id="dni" readonly>

        <label for="id_membresia">Membresía:</label>
        <select name="id_membresia" onchange="actualizarMonto()" required>
            <option value="">Seleccione una membresía</option>
            <?php foreach ($membresias_data as $id => $m): ?>
                <option value="<?= $id ?>"><?= $m['tipo_membre'] ?> - $<?= number_format($m['precio'], 2) ?></option>
            <?php endforeach; ?>
        </select>

        <label>Monto:</label>
        <input type="text" name="monto_pago" id="monto_pago" readonly>

        <label for="metodo_pago">Método de pago:</label>
        <select name="metodo_pago" required>
            <option value="">Seleccione un método</option>
            <option value="Efectivo">Efectivo</option>
            <option value="Tarjeta">Tarjeta</option>
            <option value="Transferencia">Transferencia</option>
            <option value="MercadoPago">MercadoPago</option>
        </select>

        <input type="submit" value="Guardar">
    </form>

    <?php if ($mensaje): ?>
        <div class="mensaje"><?= $mensaje ?></div>
    <?php endif; ?>

    <h2>Pagos registrados</h2>
    <table>
        <thead>
        <tr>
            <th>Cliente</th>
            <th>Membresía</th>
            <th>Precio</th>
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
                <td><?= htmlspecialchars($pago['nombre_cliente']) ?></td>
                <td><?= htmlspecialchars($pago['tipo_membre']) ?></td>
                <td>$<?= number_format($pago['precio'], 2) ?></td>
                <td><?= htmlspecialchars($pago['nombre']) ?></td>
                <td><?= htmlspecialchars($pago['dni']) ?></td>
                <td>$<?= number_format($pago['monto_pago'], 2) ?></td>
                <td><?= htmlspecialchars($pago['metodo_pago']) ?></td>
                <td class="acciones">
                    <a href="modificar_pago.php?id_pago=<?= $pago['id_pago'] ?>">Modificar</a>
                    <a href="?eliminar=<?= $pago['id_pago'] ?>" onclick="return confirm('¿Está seguro de que desea eliminar este pago?');">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</main>

<script>
    const clientesData = <?= json_encode($clientes_data) ?>;
    const membresiasData = <?= json_encode($membresias_data) ?>;

    function actualizarDatosCliente() {
        const id = document.querySelector('select[name="id_cliente"]').value;
        const cliente = clientesData[id];
        if (cliente) {
            document.getElementById('nombre').value = cliente.nombre + ' ' + cliente.apellido;
            document.getElementById('apellido').value = cliente.apellido;
            document.getElementById('telefono').value = cliente.telefono;
            document.getElementById('dni').value = cliente.dni;
        } else {
            document.getElementById('nombre').value = '';
            document.getElementById('apellido').value = '';
            document.getElementById('telefono').value = '';
            document.getElementById('dni').value = '';
        }
    }

    function actualizarMonto() {
        const id = document.querySelector('select[name="id_membresia"]').value;
        const membresia = membresiasData[id];
        document.getElementById('monto_pago').value = membresia?.precio || '';
    }
</script>

</body>
</html>
