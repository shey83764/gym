<?php 
//conexion a bd
include '../conexion.php';

//recibimos los datos del formulario
$metodo_pago = $_REQUEST["metodo_pago"];
$monto_pago = $_REQUEST["monto_pago"];
$nombre=$_REQUEST["nombre"];
$apellido=$_REQUEST["apellido"];
$dni=$_REQUEST["dni"];

$SQL = "INSERT INTO pago(metodo_pago,monto_pago,nombre,apellido,dni,) VALUES ('$metodo_pago','$monto_pago','$nombre','$apellido','$dni')";
$con->query($SQL);
    
