<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        Monto de pago
        <input type="number" name="monto_pago">

        <input type="submit" value="Eliminar">
    </form>

    <?php
    include '../conexion.php';
    //isset : es para verificar existe un determinado dato
    if(  isset( $_REQUEST["monto_pago"] )  ) {


        //tomo el dato del telefono del formulario
        $monto_pago = $_REQUEST["monto_pago"];

        //armo la consulta a mi base de datos por turno que coincida el telefono
        $SQL = "SELECT * FROM pago WHERE monto_pago = $monto_pago LIMIT 1"; 

        //ejecutando la consuta y guardo el resultado en res
        $res = $con->query( $SQL );

        //debug = depurar el codigo
        //var_dump($res);

        if( $res->num_rows == 0){
            echo "<h1>No existe ese monto de pago</h1>";
        } else {
            //->fetch_assoc() = agarrar un registro y transformarlo en un arreglo
            $registro = $res->fetch_assoc();

            echo "clientes <hr> <br> 
                fecha: $registro[fecha] <br> 
                Esta seguro que quiere eliminar esto ? $registro[monto_pago]
                <a href='?id=$registro[id_pago]'>Si</a>
                <a href='formulario_pago.php'>No</a>";
        }
    }

    if(  isset( $_REQUEST["id_pago"] )  ) {

        $id = $_REQUEST["id_pago"];

        $SQL = "DELETE FROM pago WHERE id_pago = $id_pago";

        $con->query( $SQL );

        header('location: formulario_pago.php');
    }


    ?>
</body>
</html>