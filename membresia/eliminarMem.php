<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Membresía</title>
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
    <header>
        <h1>PowerFit Gym</h1>
        <p>Eliminar Membresía</p>
    </header>

    <main>
        <form action="" method="post">
            <label for="contacto">DNI:</label>
            <input type="text" name="contacto" placeholder="Ingresa el DNI para eliminar" required>
            <button type="submit">Buscar</button>
        </form>

        <?php
        include '../conexion.php';

        // Verificar si se recibió el DNI
        if (isset($_REQUEST["contacto"])) {
            $contacto = $_REQUEST["contacto"];

            // Buscar la membresía con el DNI ingresado
            $SQL = "SELECT * FROM membresia WHERE dni = '$contacto' LIMIT 1"; 
            $res = $con->query($SQL);

            if ($res->num_rows == 0) {
                echo "<h1>No existe membresía con ese DNI</h1>";
            } else {
                $registro = $res->fetch_assoc();

                // Mostrar los datos de la membresía
                echo "
                    <h2>Detalles de la Membresía</h2>
                    <hr>
                    <p><strong>DNI:</strong> $registro[dni]</p>
                    <p><strong>Nombre:</strong> $registro[nombre]</p>
                    <p><strong>Apellido:</strong> $registro[apellido]</p>
                    <p><strong>Teléfono:</strong> $registro[telefono]</p>
                    <p><strong>Tipo de Membresía:</strong> $registro[tipo_membre]</p>
                    <p><strong>Precio:</strong> $registro[precio]</p>
                    <p><strong>Fecha de Inscripción:</strong> $registro[fecha]</p>
                    <p><strong>Hora de Inscripción:</strong> $registro[hora]</p>

                    <p>¿Está seguro de que quiere eliminar esta membresía?</p>
                    <a href='?id=$registro[id_membresia]'>Sí</a> |
                    <a href='formulario_membre.php'>No</a>
                ";
            }
        }

        // Procesar la eliminación si se recibe el ID
        if (isset($_REQUEST["id"])) {
            $id = $_REQUEST["id"];

            // Eliminar la membresía con el ID proporcionado
            $SQL = "DELETE FROM membresia WHERE id_membresia = $id";
            $con->query($SQL);

            // Redirigir al formulario de membresía
            header('location: formulario_membre.php');
        }
        ?>
    </main>

    <footer>
        <p>&copy; 2025 PowerFit Gym</p>
    </footer>
</body>
</html>
