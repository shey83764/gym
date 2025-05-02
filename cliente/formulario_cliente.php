<?php
include '../conexion.php';

$consulta = "SELECT * FROM clientes ORDER BY fecha, hora";
$resultado = mysqli_query($con, $consulta);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gimnasio PowerFit</title>
    <style>
        /* Estilos omitidos por brevedad, idénticos al archivo anterior */
    </style>
</head>
<body>
    <header>
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

        form button {
            padding: 0.5rem 1rem;
            margin: 0 0.2rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        form .danger {
            background-color: #f6a9b2;
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

        /* Responsive Styles */
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

            form button {
                width: auto;
            }
        }
    </style>
        <h1>Gimnasio PowerFit</h1>
        <p>Registro de Clientes</p>
    </header>

    <main>
        <section class="formulario">
            <h2>Registrar Cliente</h2>
            <form action="guardar.php" method="POST">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" required>

                <label for="apellido">Apellido:</label>
                <input type="text" name="apellido" required>

                <label for="telefono">Teléfono:</label>
                <input type="text" name="telefono" required>

                <label for="DNI">DNI:</label>
                <input type="text" name="DNI" required>

                <label for="fecha">Fecha:</label>
                <input type="date" name="fecha" id="fecha" required>


                <button type="submit">Guardar Cliente</button>
            </form>
        </section>

        <section class="lista">
            <h2>Clientes Registrados</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Teléfono</th>
                        <th>DNI</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if ($resultado && mysqli_num_rows($resultado) > 0) {
                    foreach ($resultado as $fila) {
                        echo "<tr>
                            <td data-label='Nombre'>{$fila['nombre']}</td>
                            <td data-label='Apellido'>{$fila['apellido']}</td>
                            <td data-label='Teléfono'>{$fila['telefono']}</td>
                            <td data-label='DNI'>{$fila['DNI']}</td>
                            <td data-label='Fecha'>{$fila['fecha']}</td>
                            <td data-label='Acciones'>
                                <form action='modificar.php' method='POST' style='display:inline'>
                                    <input type='hidden' name='id_cliente' value='{$fila['id_cliente']}'>
                                    <button type='submit'>Modificar</button>
                                </form>
                                <form action='eliminar.php' method='POST' style='display:inline' onsubmit='return confirm(\"¿Estás seguro?\")'>
                                    <input type='hidden' name='id_cliente' value='{$fila['id_cliente']}'>
                                    <button type='submit' class='danger'>Eliminar</button>
                                </form>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No hay clientes registrados.</td></tr>";
                }
                ?>
                </tbody>
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
