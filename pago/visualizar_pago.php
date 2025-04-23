<?php
include '../conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtenemos los valores de los pagos y el método de pago
    $monto_pago = $_POST['monto_pago']; // Obtener monto_pago desde el formulario
    $metodo_pago = $_POST['metodo_pago']; // Obtener metodo_pago desde el formulario
    
    // Consulta para obtener los pagos con monto y metodo de pago
    $sql = "SELECT monto_pago, metodo_pago 
            FROM pago WHERE monto_pago = '$monto_pago' AND metodo_pago = '$metodo_pago'";
    
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        echo "<h1>Visualizar pagos</h1>";
        echo "<table border='1'>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Teléfono</th>
                <th>Monto de Pago</th>
                <th>Metodo de Pago</th>
            </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['nombre'] . "</td>";
            echo "<td>" . $row['apellido'] . "</td>";
            echo "<td>" . $row['telefono'] . "</td>";
            echo "<td>" . $row['monto_pago'] . "</td>";  
            echo "<td>" . $row['metodo_pago'] . "</td>"; 
            echo "</tr>";
        }

        echo "</table>";
        echo "<br>";
    } else {
        echo "No se encontraron resultados con el monto de pago y método de pago proporcionados. <br><br>";
    }
} else {
    echo "<h1>Ver pagos</h1>";
    echo "<form method='post' action='" . $_SERVER['PHP_SELF'] . "'>
            <label>Monto de Pago:</label>
            <input type='text' name='monto_pago' required>
            <label>Metodo de Pago:</label>
            <input type='text' name='metodo_pago' required>
            <input type='submit' value='Buscar'>
        </form>";
}

echo "<a href='formulario_pago.php'>Volver al inicio</a>";
?>
