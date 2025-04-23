<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar pago</title>
</head>
<body>
    <form action="" method="post">
    monto de pago
        <input type="number" name="monto_pago">

        <input type="submit" value="Modificar">
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
            echo "<h1>No existe el monto de ese pago</h1>";
        } else {
            //->fetch_assoc() = agarrar un registro y transformarlo en un arreglo
            $registro = $res->fetch_assoc();

            //Crea un formulario con los datos del turno ya cargados
            echo "
                <form>
                    pago <hr> <br> 

                    monto: 
                    <input name='fecha' value='$registro[monto_pago]' type='number'> 
                    <br> 

                    metodo: 
                    <input name='hora' value='$registro[metodo_pago]' type='text'> 
                    <br> 
                    <input type='submit' value='modificar'>
                </form>
                ";
        }
    }

    if(isset($_REQUEST['id_pago'])){
        include '../conexion.php';

        $id = $_REQUEST["id_pago"];
        $monto_pago = $_REQUEST["nombre"];
        $metodo_pago = $_REQUEST["apellido"];

        //modifica el turno cuyo ID coincida con el de turno a modificar
        $SQL = "UPDATE pago 
                SET monto_pago='$monto_pago', 
                    metodo_pago='$metodo_pago' 
                    WHERE id_pago = $id";

        $con->query( $SQL );

        //redirije al formulario
        header('location: formulario_pago.php');
    }
    ?>
    </body>
</html>