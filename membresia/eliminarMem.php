<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

        a {
            color: #4a90e2;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<body>
    <header>
        <h1>PowerFit Gym</h1>
        <p>Eliminar Membresía</p>
    </header>

    <main>
        <form action="" method="post">
            <label for="nombre">Nombre del Miembro:</label>
            <input type="text" name="nombre" placeholder="Ingresa el nombre para eliminar" required>
            <button type="submit">Buscar</button>
        </form>
        <?php
include '../conexion.php';

// Verificar si se recibió el nombre
if (isset($_REQUEST["nombre"])) {
    $nombre = $_REQUEST["nombre"];

    // Buscar la membresía con el nombre ingresado
    $SQL = "SELECT * FROM clientes WHERE nombre, dni LIKE '%$nombre%' LIMIT 1"; 

    // Ejecutar la consulta
    $res = $con->query($SQL);

    // Verificar si la consulta fue exitosa
    if ($res === false) {
        // Mostrar el error de la consulta si algo falla
        //echo "<h1>Error en la consulta SQL: " . $con->error . "</h1>";
    } else {
        // Si la consulta fue exitosa
        if ($res->num_rows == 0) {
            echo "<h1>No existe membresía con ese nombre</h1>";
        } else {
            $registro = $res->fetch_assoc();

            // Verificar que las claves existen antes de intentar usarlas
            $dni = isset($registro['dni']) ? $registro['dni'] : 'No disponible';
            $nombreMembre = isset($registro['nombre']) ? $registro['nombre'] : 'No disponible';
            $apellido = isset($registro['apellido']) ? $registro['apellido'] : 'No disponible';
            $telefono = isset($registro['telefono']) ? $registro['telefono'] : 'No disponible';
            $tipoMembre = isset($registro['tipo_membre']) ? $registro['tipo_membre'] : '';
            $precio = isset($registro['precio']) ? $registro['precio'] : '';
            $fecha = isset($registro['fecha']) ? $registro['fecha'] : 'No disponible';
            $hora = isset($registro['hora']) ? $registro['hora'] : 'No disponible';

            // Mostrar los datos de la membresía
            echo "
            <h2>Detalles de la Membresía</h2>
            <hr>
            <p><strong>Nombre:</strong> {$registro['nombre']} {$registro['apellido']}</p>
            <p><strong>DNI:</strong> {$registro['dni']}</p>
            <p><strong>Teléfono:</strong> {$registro['telefono']}</p>
            <p><strong>Tipo de Membresía:</strong> {$registro['tipo_membre']}</p>
            <p><strong>Precio:</strong> $ {$registro['precio']}</p>
            <p>¿Está seguro de que desea <strong>eliminar</strong> esta membresía?</p>
            <div class='acciones'>
                <a href='?id={$registro['id_membresia']}'>✅ Sí, eliminar</a>
                <a href='formulario_membre.php'>❌ No, cancelar</a>
            </div>
        ";

            // Verificar si 'id_membresia' existe antes de mostrar el enlace
            if (isset($registro['id_membresia'])) {
                echo "
                    <p>¿Está seguro de que quiere eliminar esta membresía?</p>
                    <a href='?id={$registro['id_membresia']}'>Sí</a> |
                    <a href='formulario_membre.php'>No</a>
                ";
            }
        }
    }
}

// Procesar la eliminación si se recibe el ID
if (isset($_REQUEST["id_membresia"])) {
    $id = $_REQUEST["id_membresia"];

    // Eliminar la membresía con el ID proporcionado
    $SQL = "DELETE FROM membresia WHERE id_membresia = $id";
    if ($con->query($SQL) === TRUE) {
        // Redirigir al formulario de membresía después de la eliminación
        echo "<p>La membresía ha sido eliminada exitosamente.</p>";
        header('refresh:3; url=formulario_membre.php');
    } else {
        echo "<p>Error al eliminar la membresía: " . $con->error . "</p>";
    }
}
?>
</body>
</html>
