<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        contacto
        <input type="tel" name="contacto">

        <input type="submit" value="Eliminar">
    </form>

    <?php
    include '../conexion.php';
    //isset : es para verificar existe un determinado dato
    if(  isset( $_REQUEST["contacto"] )  ) {


        //tomo el dato del telefono del formulario
        $contacto = $_REQUEST["contacto"];

        //armo la consulta a mi base de datos por turno que coincida el telefono
        $SQL = "SELECT * FROM clases WHERE telefono = $contacto LIMIT 1"; 

        //ejecutando la consuta y guardo el resultado en res
        $res = $con->query( $SQL );

        //debug = depurar el codigo
        //var_dump($res);

        if( $res->num_rows == 0){
            echo "<h1>No existe turno con ese numero de telefono</h1>";
        } else {
            //->fetch_assoc() = agarrar un registro y transformarlo en un arreglo
            $registro = $res->fetch_assoc();

            echo "clases <hr> <br> 
                fecha: $registro[fecha] <br> 
                hora: $registro[hora] <br>
                Esta seguro que quiere eliminar esto ? $registro[nombre]
                <a href='?id=$registro[id_clases]'>Si</a>
                <a href='formulario_clases.php'>No</a>";
        }
    }

    if(  isset( $_REQUEST["id"] )  ) {
        include '../conexion.php';
        $id = $_REQUEST["id_clase"];

        $SQL = "DELETE FROM clases WHERE id_clase = $id";

        $con->query( $SQL );

        header('location: formulario_clases.php');
    }


    ?>
</body>
</html>