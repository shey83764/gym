<?php
session_start();

// Conexión a la base de datos
include 'conexion.php';
if (!$con) {
    die("❌ Conexión fallida: " . mysqli_connect_error());
}

$error_msg = "";

// Procesamiento del formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['accion']) && $_POST['accion'] === 'login') {
    if (isset($_POST['usuario'], $_POST['contrasena'])) {
        $usuario = mysqli_real_escape_string($con, $_POST['usuario']);
        $contrasena = $_POST['contrasena'];

        $sql = "SELECT * FROM usuario WHERE usuario = '$usuario'";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            $datos = mysqli_fetch_assoc($result);
            if (password_verify($contrasena, $datos['contrasena'])) {
                $_SESSION['id_usuario'] = $datos['id_usuario'];
                $_SESSION['usuario'] = $datos['usuario'];
                header("Location: index.php"); // Redirige al panel principal
                exit;
            } else {
                $error_msg = "❌ Contraseña incorrecta.";
            }
        } else {
            $error_msg = "❌ El usuario no existe.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
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
    </style>
</head>
<body>
<div class="container">
    <h2>Iniciar Sesión</h2>
    <?php if ($error_msg): ?><p class="mensaje"><?= $error_msg ?></p><?php endif; ?>
    <form method="POST">
        <input type="hidden" name="accion" value="login">
        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="password" name="contrasena" placeholder="Contraseña" required>
        <input type="submit" value="Iniciar Sesión">
    </form>
    <a href="registro_usuario.php">Registrate aqui si no tienes una cuenta</a>
</div>
</body>
</html>
