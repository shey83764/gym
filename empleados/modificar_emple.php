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
        <input type="text" name="puesto">

        <input type="submit" value="Modificar">
    </form>
    <?php
    include '../conexion.php';

    //isset : es para verificar existe un determinado dato
    if(  isset( $_REQUEST["puesto"] )  ) {

        //tomo el dato del telefono del formulario
        $puesto = $_REQUEST["puesto"];

        //armo la consulta a mi base de datos por turno que coincida el telefono
        $SQL = "SELECT * FROM empleados WHERE puesto = $puesto LIMIT 1"; 

        //ejecutando la consuta y guardo el resultado en res
        $res = $con->query( $SQL );

        //debug = depurar el codigo
        //var_dump($res);

        if( $res->num_rows == 0){
            echo "<h1>No existe este puesto</h1>";
        } else {
            //->fetch_assoc() = agarrar un registro y transformarlo en un arreglo
            $registro = $res->fetch_assoc();

            //Crea un formulario con los datos del turno ya cargados
            echo "
                <form>
                    Empleados <hr> <br> 

                    fecha: 
                    <input name='puesto' value='$registro[puesto]' type='text'> 
                    <br> 

                    nombre: 
                    <input name='nombre' value='$registro[nombre]' type='text'> 
                    <br> 
                    
                    apellido: 
                    <input name='apellido' value='$registro[apellido]' type='text'> 
                    <br> 
                    
                    <input name='id' value='$registro[id_entrenador]' type='hidden'> 
                    <br> 
                    
                    <input type='submit' value='modificar'>
                </form>
                ";
        }
    }

    if(isset($_REQUEST['id_entrenador'])){
        $con = new mysqli("localhost", "root", "", "gimnasio");

        $id = $_REQUEST["id"];
        $puesto =$_REQUEST["puesto"]; 
        $nombre = $_REQUEST["nombre"];
        $apellido = $_REQUEST["apellido"];
        $dni= $_REQUEST["dni"];

        //modifica el turno cuyo ID coincida con el de turno a modificar
        $SQL = "UPDATE empleados SET nombre='$nombre',apellido='$apellido',puesto='$pusto',dni='$dni'WHERE id_entrenador = $id_entrenador";

        $con->query( $SQL );

        //redirije al formulario
        header('location: formulario_emple.php');
    }
    ?>
    </body>
</html>