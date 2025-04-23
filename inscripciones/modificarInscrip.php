<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar inscripcion</title>
</head>
<body>
    <form action="" method="post">
        contacto
        <input type="tel" name="contacto">

        <input type="submit" value="Modificar">
    </form>
    <?php
    include '../conexion.php';

    //isset : es para verificar existe un determinado dato
    if(  isset( $_REQUEST["contacto"] )  ) {

        //tomo el dato del telefono del formulario
        $contacto = $_REQUEST["contacto"];

        //armo la consulta a mi base de datos por turno que coincida el telefono
        $SQL = "SELECT * FROM inscripcion WHERE telefono = $contacto LIMIT 1"; 

        //ejecutando la consuta y guardo el resultado en res
        $res = $con->query( $SQL );

        //debug = depurar el codigo
        //var_dump($res);

        if( $res->num_rows == 0){
            echo "<h1>No existe turno con ese numero de telefono</h1>";
        } else {
            //->fetch_assoc() = agarrar un registro y transformarlo en un arreglo
            $registro = $res->fetch_assoc();

            //Crea un formulario con los datos del turno ya cargados
            echo "
                <form>
                    gimnasio <hr> <br> 

                    fecha: 
                    <input name='fecha' value='$registro[fecha]' type='date'> 
                    <br> 

                    telefono: 
                    <input name='telefono' value='$registro[telefono]' type='number'> 
                    <br> 
 
                    <input name='id' value='$registro[id_inscrip]' type='hidden'> 
                    <br> 
                    
                    <input type='submit' value='modificar'>
                </form>
                ";
        }
    }

    if(isset($_REQUEST['id_inscrip'])){

        $id = $_REQUEST["id_inscrip"];
        $fecha = $_REQUEST["fecha"];
        $telefono = $_REQUEST["telefono"];

        //modifica el turno cuyo ID coincida con el de turno a modificar
        $SQL = "UPDATE inscripcion 
                SET 
                    fecha='$fecha',
                    telefono='$telefono' 
                    WHERE id_inscrip = $id";

        $con->query( $SQL );

        //redirije al formulario
        header('location: formulario_inscrip.php');
    }
    ?>
    </body>
</html>