<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Empleado</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 40px;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            max-width: 400px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input[type="text"], input[type="submit"] {
            display: block;
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
        }
        input[type="submit"] {
            background: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #0056b3;
        }
        h1 {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>

<form method="post">
    Buscar por DNI:
    <input type="text" name="dni" required>
    <input type="submit" value="Buscar">
</form>

<?php
include '../conexion.php';

if (isset($_REQUEST["dni"])) {
    $dni = $_REQUEST["dni"];
    $SQL = "SELECT * FROM empleados WHERE dni = '$dni' LIMIT 1"; 
    $res = $con->query($SQL);

    if ($res->num_rows == 0){
        echo "<h1>No existe este DNI</h1>";
    } else {
        $registro = $res->fetch_assoc();

        echo "
            <form method='post'>
                <h2>Modificar Empleado</h2>
                DNI:
                <input name='dni' value='{$registro['dni']}' type='text'> 
                Nombre:
                <input name='nombre' value='{$registro['nombre']}' type='text'> 
                Apellido:
                <input name='apellido' value='{$registro['apellido']}' type='text'> 
                Puesto:
                <input name='puesto' value='{$registro['puesto']}' type='text'> 
                <input name='id_empleado' value='{$registro['id_empleado']}' type='hidden'> 
                <input type='submit' value='Modificar'>
            </form>
        ";
    }
}

if (isset($_POST['id_empleado'])) {
    $id = $_POST["id_empleado"];
    $puesto = $_POST["puesto"]; 
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $dni = $_POST["dni"];

    $SQL = "UPDATE empleados 
            SET nombre='$nombre', apellido='$apellido', puesto='$puesto', dni='$dni' 
            WHERE id_empleado = $id";

    $con->query($SQL);

    header('Location: formulario_emple.php');
}
?>

</body>
</html>
