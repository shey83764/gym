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

// Verificar si se enviaron los datos desde un formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_cliente = intval($_POST['id_cliente']);
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $fecha_nacimiento = $_POST['fecha_nacimiento'];

    // Verificar que los campos no estén vacíos
    if (!empty($nombre) && !empty($apellido) && !empty($email) && !empty($telefono) && !empty($fecha_nacimiento)) {
        // Consulta SQL para actualizar datos
        $sql = "UPDATE Clientes SET nombre = ?, apellido = ?, email = ?, telefono = ?, fecha_nacimiento = ? 
                WHERE id_cliente = ?";

        // Preparar la consulta
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssssi", $nombre, $apellido, $email, $telefono, $fecha_nacimiento, $id_cliente);

            if ($stmt->execute()) {
                echo "Cliente actualizado correctamente.";
            } else {
                echo "Error al actualizar el cliente: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error en la preparación de la consulta.";
        }
    } else {
        echo "Todos los campos son obligatorios.";
    }
} else {
    echo "Acceso no válido.";
}

// Cerrar conexión
$conn->close();
?>
