<?php 
//conexion a bd
include '..//conexion.php';

//recibimos los datos del formulario
$hora = $_REQUEST["hora"];
$cupo_max = $_REQUEST["cupo_max"];
$fecha = $_REQUEST["fecha"];
$nombre=$_REQUEST["nombre"];

//consulta de busqueda en el turno con la misma fecha y hora
$SQL = "SELECT * FROM clases WHERE fecha = '$fecha' AND hora='$hora'";

//ejecutar la consulta
//$res = $con->query( $SQL );

//num_rows sirve para saber la cantidad de resgistros encontrados

//consulta de insercion
    $SQL = "INSERT INTO clases (hora, cupo_max,fecha, nombre) VALUES ('$hora', '$cupo_max', '$fecha', '$nombre')";

    //ejecutar la consulta
    $con->query($SQL);
echo "Gracias por registrarte en $nombre!";
