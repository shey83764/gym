<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Membresía</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #fef6e4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #a3c4f3;
            color: #fff;
            text-align: center;
            padding: 1.5rem;
        }

        main {
            max-width: 900px;
            margin: 2rem auto;
            background-color: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        h2 {
            margin-top: 0;
            color: #4a4a4a;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        label {
            font-weight: bold;
        }

        input, select, button {
            padding: 0.7rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
        }

        button {
            background-color: #b8e1dd;
            color: #333;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #99d2c6;
        }

        footer {
            text-align: center;
            padding: 1rem;
            background-color: #a3c4f3;
            color: white;
            margin-top: 2rem;
        }

        hr {
            border: 1px solid #ccc;
            margin: 1rem 0;
        }
    </style>
</head>
<body>
<header>
    <h1>PowerFit Gym</h1>
    <p>Modificar Membresía</p>
</header>

<main>
    <form action="" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" placeholder="Ingresa el nombre para modificar" required>
        <input type="submit" value="Buscar">
    </form>

    <?php
include '../conexion.php';

if (isset($_POST["nombre"])) {
    $nombre = $con->real_escape_string($_POST["nombre"]);

    // Consulta SQL para obtener los datos de la membresía
    $SQL = "SELECT 
                c.nombre, 
                c.apellido, 
                c.telefono, 
                m.id_membresia, 
                m.precio, 
                m.tipo_membre
            FROM clientes c
            JOIN inscripciones i ON c.id_cliente = id_cliente
            JOIN membresia m ON i.id_inscrip = m.id_inscrip
            WHERE c.nombre LIKE '%$nombre%' 
            LIMIT 1";

    $res = $con->query($SQL);

    if (!$res) {
        // Si la consulta falla, mostrar el error de la consulta
        echo "Error en la consulta SQL: " . $con->error;
    } else {
        if ($res->num_rows == 0) {
            echo "<h2>No existe membresía asociada a ese nombre.</h2>";
        } else {
            $registro = $res->fetch_assoc();

            // Verificar si las claves existen antes de acceder a ellas
            $nombreCliente = isset($registro['nombre']) ? $registro['nombre'] : 'No disponible';
            $apellido = isset($registro['apellido']) ? $registro['apellido'] : 'No disponible';
            $telefono = isset($registro['telefono']) ? $registro['telefono'] : 'No disponible';
            $precio = isset($registro['precio']) ? $registro['precio'] : 'No disponible';
            $tipo_membre = isset($registro['tipo_membre']) ? $registro['tipo_membre'] : 'No disponible';
            $id_membresia = isset($registro['id_membresia']) ? $registro['id_membresia'] : 'No disponible';

            // Mostrar el formulario con los datos
            echo "
                <form  action= 'formulario_membre.php' method='post'>
                    <h2>Modificar Membresía</h2><hr> 
                    <p><strong>Nombre:</strong> $nombreCliente $apellido</p>
                    <p><strong>Teléfono:</strong> $telefono</p>

                    <label for='precio'>Precio:</label>
                    <input name='precio' value='$precio' type='number' step='0.01' required> 

                    <label for='tipo_membre'>Tipo de Membresía:</label>
                    <input name='tipo_membre' value='$tipo_membre' type='text' required> 

                    <input name='id' value='$id_membresia' type='hidden'> 

                    <button type='submit'>Modificar</button>
                </form>
            ";
        }
    }
}
?>


</main>

<footer>
    <p>&copy; 2025 PowerFit Gym</p>
</footer>
</body>
</html>
