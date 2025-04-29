<?php 
//conexion a bd
include '..//conexion.php';

//recibimos los datos del formulario
$nombre = $_REQUEST["nombre"];
$apellido = $_REQUEST["apellido"];
$telefono = $_REQUEST["telefono"];
$DNI=$_REQUEST["DNI"];
$fecha = $_REQUEST["fecha"];
$hora=$_REQUEST["hora"];

//consulta de busqueda en el turno con la misma fecha y hora
$SQL = "SELECT * FROM clientes WHERE DNI=$DNI";

//ejecutar la consulta
//$res = $con->query( $SQL );

//num_rows sirve para saber la cantidad de resgistros encontrados
//if( $res->num_rows > 0){
  //  echo "<h1>Ese turno ya fue tomado</h1>";
//}else {
    //consulta de insercion
    $SQL = "INSERT INTO clientes (nombre, apellido, telefono, DNI, fecha, hora) VALUES ('$nombre', '$apellido', $telefono ,'$DNI', '$fecha', '$hora')";

    //ejecutar la consulta
    $con->query($SQL);
    
