<?php
session_start();         // Inicia la sesión actual
session_unset();         // Elimina todas las variables de sesión
session_destroy();       // Destruye la sesión
header("Location: index.php"); // Redirige al formulario de login
exit;