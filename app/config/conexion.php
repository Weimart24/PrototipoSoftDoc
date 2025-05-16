<?php
// Conexion a la base de datos
$host = "127.0.0.1"; //Ip de localhost
$usuario = "root";
$contrasenia = "";
$bd = "prototipo3"; //Nombre de la base de datos

$conexion = new mysqli($host, $usuario, $contrasenia, $bd);

if ($conexion->connect_error){
    die("Error de conexión: {$conexion->connect_error}");
}