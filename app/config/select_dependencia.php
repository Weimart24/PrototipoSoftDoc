<?php
// Conexion a la base de datos
include 'conexion.php';
// Consulta para seleccionar las dependencias
$query = "SELECT id_dependencia, nombre_dependencia FROM dependencia";
$resultado = $conexion->query($query);

$dependencias = [];

while ($fila = $resultado->fetch_assoc()) {
    $dependencias[] = $fila;
}

echo json_encode($dependencias);

$conexion->close();
