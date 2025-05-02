<?php
include '../conexion.php';

$mensaje = "";

// Verifica si 'id_empleado' es AUTO_INCREMENT y lo corrige si no lo es
$checkAI = mysqli_query($con, "SHOW CREATE TABLE empleados");
if ($checkAI) {
    $row = mysqli_fetch_assoc($checkAI);
    $createSQL = $row['Create Table'];

    if (strpos($createSQL, '`id_empleado` int') !== false && strpos($createSQL, 'AUTO_INCREMENT') === false) {
        // ⚠️ Modifica la tabla solo si el campo no es AUTO_INCREMENT
        mysqli_query($con, "ALTER TABLE empleados MODIFY id_empleado INT NOT NULL AUTO_INCREMENT");
    }
}

// Insertar nuevo empleado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (
        isset($_POST['nombre']) &&
        isset($_POST['apellido']) &&
        isset($_POST['dni']) &&
        isset($_POST['puesto']) &&
        isset($_POST['telefono'])
    ) {
        $nombre = mysqli_real_escape_string($con, $_POST['nombre']);
        $apellido = mysqli_real_escape_string($con, $_POST['apellido']);
        $dni = mysqli_real_escape_string($con, $_POST['dni']);
        $puesto = mysqli_real_escape_string($con, $_POST['puesto']);
        $telefono = mysqli_real_escape_string($con, $_POST['telefono']);

        $sql = "INSERT INTO empleados (nombre, apellido, dni, telefono, puesto) 
                VALUES ('$nombre', '$apellido', '$dni', '$telefono', '$puesto')";

        if (mysqli_query($con, $sql)) {
            $mensaje = "✅ Empleado guardado correctamente.";
        } else {
            $mensaje = "❌ Error al guardar: " . mysqli_error($con);
        }
    } else {
        $mensaje = "⚠️ Por favor completá todos los campos.";
    }
}

// Consulta empleados
$resultado = mysqli_query($con, "SELECT * FROM empleados ORDER BY id_empleado DESC");
if (!$resultado) {
    die("❌ Error en la consulta: " . mysqli_error($con));
}
?>

 
 <!DOCTYPE html>
 <html lang="es">
 <head>
     <meta charset="UTF-8">
     <title>Registrar Empleado</title>
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
             max-width: 800px;
             margin: 2rem auto;
             padding: 2rem;
             background-color: #fff;
             border-radius: 12px;
             box-shadow: 0 4px 12px rgba(0,0,0,0.1);
         }
 
         form {
             display: flex;
             flex-direction: column;
             gap: 1rem;
         }
 
         input, button {
             padding: 0.8rem;
             border: 1px solid #ddd;
             border-radius: 8px;
             font-size: 1rem;
         }
 
         button {
             background-color: #b8e1dd;
             color: #333;
             font-weight: bold;
             cursor: pointer;
         }
 
         button:hover {
             background-color: #99d2c6;
         }
 
         .mensaje {
             margin-top: 1rem;
             padding: 0.7rem;
             border-radius: 8px;
             font-weight: bold;
         }
 
         .mensaje.success {
             background-color: #d4edda;
             color: #155724;
         }
 
         .mensaje.error {
             background-color: #f8d7da;
             color: #721c24;
         }
 
         table {
             width: 100%;
             border-collapse: collapse;
             margin-top: 2rem;
         }
 
         th, td {
             border: 1px solid #ccc;
             padding: 0.8rem;
             text-align: left;
         }
 
         th {
             background-color: #e0e7ff;
         }
 
         .danger {
             background-color: #f8d7da;
             color: #721c24;
             border: none;
         }
     </style>
 </head>
 <body>
     <header>
         <h1>PowerFit</h1>
         <p>Registro de Empleados</p>
     </header>
 
     <main>
         <h2>Nuevo Empleado</h2>
         <form method="POST">
             <label for="nombre">Nombre:</label>
             <input type="text" name="nombre" id="nombre" required>
 
             <label for="apellido">Apellido:</label>
             <input type="text" name="apellido" id="apellido" required>
 
             <label for="dni">DNI:</label>
             <input type="text" name="dni" id="dni" required>
 
             <label for="telefono">Teléfono:</label>
             <input type="text" name="telefono" id="telefono" required>
 
             <label for="puesto">Puesto:</label>
             <input type="text" name="puesto" id="puesto" required>
 
             <button type="submit">Guardar Empleado</button>
         </form>
 
         <?php if (!empty($mensaje)): ?>
             <div class="mensaje <?= str_contains($mensaje, '✅') ? 'success' : 'error' ?>">
                 <?= $mensaje ?>
             </div>
         <?php endif; ?>
 
         <section class="lista">
             <h2>Empleados Registrados</h2>
             <table>
                 <thead>
                     <tr>
                         <th>Nombre</th>
                         <th>Apellido</th>
                         <th>Teléfono</th>
                         <th>DNI</th>
                         <th>Puesto</th>
                         <th>Acciones</th>
                     </tr>
                 </thead>
                 <tbody>
                     <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
                         <tr>
                             <td><?= $fila['nombre'] ?></td>
                             <td><?= $fila['apellido'] ?></td>
                             <td><?= $fila['telefono'] ?></td>
                             <td><?= $fila['dni'] ?></td>
                             <td><?= $fila['puesto'] ?></td>
                             <td>
                                 <form action='modificar_emple.php' method='POST' style='display:inline'>
                                     <input type='hidden' name='id_empleado' value='<?= $fila['id_empleado'] ?>'>
                                     <button type='submit'>Modificar</button>
                                 </form>
                                 <form action='eliminar_emple.php' method='POST' style='display:inline' onsubmit='return confirm("¿Estás seguro?")'>
                                     <input type='hidden' name='id_empleado' value='<?= $fila['id_empleado'] ?>'>
                                     <button type='submit' class='danger'>Eliminar</button>
                                 </form>
                             </td>
                         </tr>
                     <?php endwhile; ?>
                 </tbody>
             </table>
         </section>
     </main>
 </body>
 </html>