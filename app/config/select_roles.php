<?php
// Conexion a la base de datos
include 'conexion.php';
// Consulta para seleccionar las dependencias
$query = "SELECT id_rol, nombre_rol FROM roles";
// Ejecutar la consulta";
$resultado = $conexion->query($query);

$roles = [];

while ($fila = $resultado->fetch_assoc()) {
    $roles[] = $fila;
}

echo json_encode($roles);

$conexion->close();
