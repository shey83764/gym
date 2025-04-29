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
            <label for="dni">DNI:</label>
            <input type="text" name="contacto" placeholder="Ingresa el DNI para modificar" required>
            <input type="submit" value="Buscar">
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

                // Crear el formulario con los datos cargados
                echo "
                    <form method='post'>
                        <h2>Modificar Membresía</h2><hr> 

                        <label for='telefono'>Teléfono:</label>
                        <input name='telefono' value='$registro[telefono]' type='text' required> 

                        <label for='precio'>Precio:</label>
                        <input name='precio' value='$registro[precio]' type='number' step='0.01' required> 

                        <label for='tipo_membre'>Tipo de Membresía:</label>
                        <input name='tipo_membre' value='$registro[tipo_membre]' type='text' required> 

                        <input name='id' value='$registro[id_membresia]' type='hidden'> 

                        <button type='submit'>Modificar</button>
                    </form>
                ";
            }
        }

        // Procesar la modificación si se envían los datos
        if (isset($_REQUEST['id'])) {
            $id = $_REQUEST["id"];
            $telefono = $_REQUEST["telefono"];
            $precio = $_REQUEST["precio"];
            $tipo_membre = $_REQUEST["tipo_membre"];

            // Actualizar la membresía con los nuevos datos
            $SQL = "UPDATE membresia 
                    SET  
                        telefono='$telefono',
                        precio='$precio',
                        tipo_membre='$tipo_membre' 
                    WHERE id_membresia = '$id'";

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
