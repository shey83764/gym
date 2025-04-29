<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Pago</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #6a89cc;
            color: white;
            padding: 1rem;
            text-align: center;
        }

        main {
            max-width: 700px;
            margin: 2rem auto;
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        h1, h2 {
            margin-top: 0;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        label {
            font-weight: bold;
        }

        input[type="text"], input[type="number"], input[type="date"] {
            padding: 0.6rem;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        input[type="submit"] {
            background-color: #e74c3c;
            color: white;
            font-weight: bold;
            padding: 0.7rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #c0392b;
        }

        .mensaje {
            text-align: center;
            margin: 1rem 0;
            font-weight: bold;
            color: green;
        }

    </style>
</head>
<body>

<header>
    <h1>Eliminar Pago</h1>
</header>

<main>
    <form action="" method="post">
        <label for="dni">DNI del cliente:</label>
        <input type="number" name="dni" required>

        <label for="monto_pago">Monto del pago:</label>
        <input type="number" step="0.01" name="monto_pago" required>

        <input type="submit" value="Eliminar">
    </form>

    <?php
    include '../conexion.php';

    if (isset($_REQUEST["dni"]) && isset($_REQUEST["monto_pago"])) {

        $dni = $_REQUEST["dni"];
        $monto_pago = $_REQUEST["monto_pago"];

        // Consultar si el DNI y monto existen
        $SQL = "SELECT * FROM pago WHERE dni = '$dni' AND monto_pago = $monto_pago LIMIT 1"; 
        $res = $con->query($SQL);

        if ($res->num_rows == 0) {
            echo "<h2>No se encontró el pago con el DNI y monto especificado.</h2>";
        } else {
            $registro = $res->fetch_assoc();
            echo "
                <form method='POST'>
                    <h3>Eliminar pago:</h3>

                    <p><strong>Fecha de pago:</strong> $registro[fecha]</p>
                    <p><strong>Monto de pago:</strong> $registro[monto_pago]</p>

                    <p>¿Está seguro de que desea eliminar este pago?</p>
                    <input type='hidden' name='id_pago' value='$registro[id_pago]'>
                    <input type='submit' value='Eliminar'>
                </form>
            ";
        }
    }

    if (isset($_POST['id_pago'])) {
        $id_pago = $_POST["id_pago"];

        // Eliminar el pago
        $SQL = "DELETE FROM pago WHERE id_pago = $id_pago";

        if ($con->query($SQL)) {
            echo "<div class='mensaje'>Pago eliminado exitosamente.</div>";
        } else {
            echo "<div class='mensaje' style='color: red;'>Error al eliminar el pago: " . $con->error . "</div>";
        }
    }
    ?>
</main>

</body>
</html>
