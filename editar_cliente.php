<?php
// Configuración de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "Gimnasio";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener ID del cliente desde la URL
if (isset($_GET['id_cliente'])) {
    $id_cliente = intval($_GET['id_cliente']);

    // Consulta para obtener los datos del cliente
    $sql = "SELECT * FROM Clientes WHERE id_cliente = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id_cliente);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $cliente = $result->fetch_assoc();
        } else {
            echo "Cliente no encontrado.";
            exit;
        }
        $stmt->close();
    }
} else {
    echo "ID de cliente no proporcionado.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
</head>
<body>
    <h2>Editar Cliente</h2>
    <form action="modificar_cliente.php" method="post">
        <input type="hidden" name="id_cliente" value="<?php echo $cliente['id_cliente']; ?>">

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $cliente['nombre']; ?>" required><br><br>

        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" value="<?php echo $cliente['apellido']; ?>" required><br><br>

        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" value="<?php echo $cliente['email']; ?>" required><br><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" value="<?php echo $cliente['telefono']; ?>" required><br><br>

        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $cliente['fecha_nacimiento']; ?>" required><br><br>

        <button type="submit">Actualizar Cliente</button>
    </form>
</body>
</html>
