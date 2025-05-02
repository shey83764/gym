<?php
include '../conexion.php';

// Guardar clase si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['clase'], $_POST['cupo_max'], $_POST['fecha'], $_POST['hora'], $_POST['entrenador'])) {
    $clase = $_POST['clase'];
    $cupo_max = $_POST['cupo_max'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $entrenador = $_POST['entrenador'];

    $insert = "INSERT INTO clases (clase, cupo_max, fecha, hora, id_entrenador)
               VALUES ('$clase', '$cupo_max', '$fecha', '$hora', '$entrenador')";
    mysqli_query($con, $insert);
}

// Obtener clases registradas
$consulta = "SELECT * FROM clases ORDER BY fecha, hora";
$resultado = mysqli_query($con, $consulta);

// Obtener entrenadores para el select
$entrenadores = mysqli_query($con, "SELECT id_empleado, nombre FROM empleados ORDER BY nombre");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clases PowerFit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            padding: 1rem;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        h2 {
            margin-top: 0;
            color: #d4a5a5;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        input, select, button {
            padding: 0.7rem;
            border: 1px solid #ddd;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th, td {
            padding: 0.8rem;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f8e1f4;
            color: #333;
        }

        td {
            background-color: #fff;
        }

        footer {
            text-align: center;
            padding: 1rem;
            background-color: #a3c4f3;
            color: white;
            margin-top: 2rem;
        }

        @media (max-width: 768px) {
            main {
                margin: 1rem;
                padding: 1rem;
            }

            input, select, button {
                width: 100%;
                font-size: 1rem;
            }

            table, thead, tbody, th, td, tr {
                display: block;
            }

            thead {
                display: none;
            }

            tr {
                margin-bottom: 1rem;
                background-color: #fff;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 0.5rem;
            }

            td {
                display: flex;
                justify-content: space-between;
                padding: 0.5rem;
                border: none;
                border-bottom: 1px solid #eee;
            }

            td::before {
                content: attr(data-label);
                font-weight: bold;
                color: #666;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Gimnasio PowerFit</h1>
        <p>Gestión de Clases</p>
    </header>

    <main>
        <section class="formulario">
            <h2>Registrar Clase</h2>
            <form action="formulario_clases.php" method="POST">
                <label for="clase">Nombre de la clase:</label>
                <input type="text" name="clase" required>

                <label for="cupo_max">Cupo de personas:</label>
                <input type="number" name="cupo_max" required>

                <label for="fecha">Fecha:</label>
                <input type="date" name="fecha" required>

                <label for="hora">Hora:</label>
                <select name="hora" required>
                    <option value="">Seleccione una hora</option>
                    <?php
                    for ($i = 8; $i <= 21; $i++) {
                        echo "<option>$i:00</option>";
                    }
                    ?>
                </select>

                <label for="entrenador">Selecciona el entrenador:</label>
                <select name="entrenador" required>
                    <option value="">Seleccione un entrenador</option>
                    <?php
                    while ($entrenador = mysqli_fetch_assoc($entrenadores)) {
                        echo "<option value='{$entrenador['id_empleado']}'>{$entrenador['nombre']}</option>";
                    }
                    ?>
                </select>

                <button type="submit">Guardar Clase</button>
            </form>
        </section>

        <section class="lista">
            <h2>Clases Registradas</h2>
            <table>
                <thead>
                    <tr>
                        <th>Clase</th>
                        <th>Cupo</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($resultado && mysqli_num_rows($resultado) > 0) {
                        foreach ($resultado as $fila) {
                            echo "<tr>
                                <td>{$fila['clase']}</td>
                                <td>{$fila['cupo_max']}</td>
                                <td>{$fila['fecha']}</td>
                                <td>{$fila['hora']}</td>
                                <td>
                                    <form action='modificar_clases.php' method='POST' style='display:inline'>
                                        <input type='hidden' name='id_clases' value='{$fila['id_clases']}'>
                                        <button type='submit'>Modificar</button>
                                    </form>
                                    <form action='eliminar_clases.php' method='POST' style='display:inline' onsubmit='return confirm(\"¿Estás seguro?\")'>
                                        <input type='hidden' name='id_clases' value='{$fila['id_clases']}'>
                                        <button type='submit' class='danger'>Eliminar</button>
                                    </form>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No hay clases programadas.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 PowerFit Gym</p>
    </footer>
</body>
</html>
