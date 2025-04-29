<?php
include '../conexion.php';

$consulta = "SELECT * FROM clases ORDER BY fecha, hora";
$resultado = mysqli_query($con, $consulta);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gimnasio PowerFit</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #fef6e4; /* pastel suave */
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #a3c4f3; /* azul pastel */
            color: #fff;
            text-align: center;
            padding: 1.5rem;
        }

        main {
            max-width: 900px;
            margin: 2rem auto;
            padding: 1rem;
            background-color: #fff; /* blanco para contraste */
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        h2 {
            margin-top: 0;
            color: #d4a5a5; /* rosa pastel */
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
            background-color: #b8e1dd; /* aqua pastel */
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
            background-color: #f8e1f4; /* lavanda claro */
            color: #333;
        }

        td {
            background-color: #fff;
        }

        form button {
            padding: 0.5rem 1rem;
            margin: 0 0.2rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        form .danger {
            background-color: #f6a9b2; /* rosa pastel */
            color: white;
        }

        form .danger:hover {
            background-color: #f28291;
        }

        footer {
            text-align: center;
            padding: 1rem;
            background-color: #a3c4f3;
            color: white;
            margin-top: 2rem;
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
            <form action="guardar_clases.php" method="POST">
                <label for="nombre">Nombre de la clase:</label>
                <input type="text" name="nombre" required>

                <label for="fecha">Fecha:</label>
                <input type="date" name="fecha" id="fecha" required>

                <label for="hora">Hora:</label>
                <select name="hora" id="hora">
                    <!-- Se llena dinámicamente -->
                </select>

                <button type="submit">Guardar Clase</button>
            </form>
        </section>

        <section class="lista">
            <h2>Clases Programadas</h2>
            <table>
                <tr>
                    <th>Nombre</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Acciones</th>
                </tr>
                <?php
                if ($resultado && mysqli_num_rows($resultado) > 0) {
                    foreach ($resultado as $fila) {
                        echo "<tr>
                            <td>{$fila['nombre']}</td>
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
                    echo "<tr><td colspan='4'>No hay clases programadas.</td></tr>";
                }
                ?>
            </table>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 PowerFit Gym</p>
    </footer>

    <script>
        document.getElementById('fecha').addEventListener("change", function () {
            let fecha = document.getElementById('fecha').value;

            fetch('verifica_hora.php', {
                method: 'POST',
                body: JSON.stringify({ f: fecha })
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('hora').innerHTML = data;
            });
        });
    </script>
</body>
</html>
