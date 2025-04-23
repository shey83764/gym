<?php 
//conexion a bd
include '../conexion.php';

//recibimos los datos del formulario
$nombre = $_REQUEST["nombre"];
$apellido = $_REQUEST["apellido"];
$DNi = $_REQUEST["DNi"];
$fecha = $_REQUEST["fecha"];

//consulta de busqueda en el turno con la misma fecha y hora
//$SQL = "SELECT * FROM inscripcion WHERE fecha = '$fecha' ";

//ejecutar la consulta
//$res = $con->query( $SQL );

//num_rows sirve para saber la cantidad de resgistros encontrados

    $SQL = "INSERT INTO inscripciones(nombre,apellido,DNi,fecha) VALUE ('$nombre','$apellido','$DNi','$fecha')";
    $con->query( $SQL );