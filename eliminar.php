<?php
// Configuración de conexión a la base de datos
$servername = "localhost"; // Cambiar si es necesario
$username = "root"; // Usuario de la base de datos
$password = ""; // Contraseña (vacía si no tienes)
$database = "Gimnasio"; // Nombre de la base de datos

// Conexión a MySQL
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se envió un ID de cliente para eliminar
if (isset($_GET['id_cliente'])) {
    $id_cliente = intval($_GET['id_cliente']); // Asegurar que sea un número entero

    // Consulta SQL para eliminar el cliente
    $sql = "DELETE FROM Clientes WHERE id_cliente = ?";
    
    // Preparar la consulta
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id_cliente); // Asociar el parámetro
        if ($stmt->execute()) {
            echo "Cliente eliminado correctamente.";
        } else {
            echo "Error al eliminar el cliente: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta.";
    }
} else {
    echo "No se proporcionó un ID de cliente.";
}

// Cerrar conexión
$conn->close();
?>
