<?php
session_start();

// Conexión a la base de datos
include 'conexion.php';
if (!$con) {
    die("❌ Conexión fallida: " . mysqli_connect_error());
}

$error_msg = "";
$success_msg = "";

// Procesamiento del formulario de registro
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['nuevo_usuario'], $_POST['nuevo_contrasena'])) {
    $nuevo_usuario = mysqli_real_escape_string($con, $_POST['nuevo_usuario']);
    $nuevo_contrasena = $_POST['nuevo_contrasena'];

    // Verificar si ya existe
    $sql = "SELECT * FROM usuario WHERE usuario = '$nuevo_usuario'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        $error_msg = "❌ El usuario ya existe.";
    } else {
        $hash = password_hash($nuevo_contrasena, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuario (usuario, contrasena) VALUES ('$nuevo_usuario', '$hash')";
        if (mysqli_query($con, $sql)) {
            $success_msg = "✅ Usuario registrado correctamente. <a href='inicio_session.php'>Iniciar sesión</a>";
        } else {
            $error_msg = "❌ Error al registrar: " . mysqli_error($con);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; }
        .container { max-width: 400px; margin: auto; padding: 20px; background: white; margin-top: 50px; border-radius: 8px; box-shadow: 0 0 10px #ccc; }
        input[type=text], input[type=password], input[type=submit] {
            width: 100%; padding: 10px; margin: 5px 0 15px; border: 1px solid #ccc; border-radius: 4px;
        }
        input[type=submit] {
            background-color: #38ada9; color: white; border: none;
        }
        input[type=submit]:hover {
            background-color: #2c3e50;
        }
        h2 { text-align: center; }
        .mensaje { text-align: center; margin: 10px 0; color: red; }
        .success { color: green; }
    </style>
</head>
<body>
<div class="container">
    <h2>Registrar Nuevo Usuario</h2>
    <?php if ($error_msg): ?><p class="mensaje"><?= $error_msg ?></p><?php endif; ?>
    <?php if ($success_msg): ?><p class="mensaje success"><?= $success_msg ?></p><?php endif; ?>

    <form method="POST">
        <input type="text" name="nuevo_usuario" placeholder="Nombre de usuario" required>
        <input type="password" name="nuevo_contrasena" placeholder="Contraseña" required>
        <input type="submit" value="Registrar">
    </form>
    <p style="text-align: center;">¿Ya tienes una cuenta? <a href="inicio_session.php">Inicia sesión</a></p>
</div>
</body>
</html>
