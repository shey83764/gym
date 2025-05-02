<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar turno</title>
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
        $SQL = "SELECT * FROM clientes WHERE telefono = $contacto LIMIT 1"; 

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

                    hora: 
                    <input name='hora' value='$registro[hora]' type='time'> 
                    <br> 

                    nombre: 
                    <input name='nombre' value='$registro[nombre]' type='text'> 
                    <br> 
                    
                    apellido: 
                    <input name='apellido' value='$registro[apellido]' type='text'> 
                    <br> 
                    
                    <input name='id' value='$registro[id_cliente]' type='hidden'> 
                    <br> 
                    
                    <input type='submit' value='modificar'>
                </form>
                ";
        }
    }

    if(isset($_REQUEST['id'])){

        $id = $_REQUEST["id"];
        $fecha = $_REQUEST["fecha"];
        $hora = $_REQUEST["hora"];
        $nombre = $_REQUEST["nombre"];
        $apellido = $_REQUEST["apellido"];

        //modifica el turno cuyo ID coincida con el de turno a modificar
        $SQL = "UPDATE clientes 
                SET nombre='$nombre', 
                    apellido='$apellido', 
                    fecha='$fecha',
                    hora='$hora' 
                    WHERE id_cliente = $id";

        $con->query( $SQL );

        //redirije al formulario
        header('location: formulario_cliente.php');
    }
    ?>
    </body>
</html>