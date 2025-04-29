<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gimnasio - Administración</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #38ada9;
            color: white;
            padding: 1rem;
            text-align: center;
        }
        nav {
            background-color: #2c3e50;
            color: white;
            padding: 1rem;
            text-align: center;
        }
        nav a {
            color: white;
            margin: 0 10px;
            text-decoration: none;
            font-weight: bold;
        }
        nav a:hover {
            text-decoration: underline;
        }
        main {
            padding: 20px;
            max-width: 900px;
            margin: 20px auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        footer {
            background-color: #38ada9;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .form-container {
            margin-top: 20px;
        }
        h2 {
            color: #333;
        }
        input[type="text"], input[type="number"], input[type="date"], select {
            width: 100%;
            padding: 0.7rem;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        input[type="submit"] {
            background-color: #38ada9;
            color: white;
            padding: 0.7rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #2c3e50;
        }
    </style>
</head>
<body>

<header>
    <h1>Administración del Gimnasio</h1>
</header>

<nav>
    <a href="clases/formulario_clases.php">Clases</a>
    <a href="cliente/formulario_cliente.php">Clientes</a>
    <a href="membresia/formulario_membre.php">Membresías</a>
    <a href="inscripciones/formulario_inscrip.php">Inscripciones</a>
    <a href="pago/formulario_pago.php">Pagos</a>
    <a href="empleados/formulario_emple.php">Empleados</a>
</nav>

<main>
    <h2>Bienvenido a la Administración del Gimnasio</h2>
    <p>Selecciona una sección del menú para gestionar los registros del gimnasio.</p>
</main>

<footer>
    <p>© 2025 Gimnasio. Todos los derechos reservados.</p>
</footer>

</body>
</html>
