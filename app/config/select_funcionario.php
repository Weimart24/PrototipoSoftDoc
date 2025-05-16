<?php
if (!isset($_GET['id_dependencia'])) {
    echo json_encode([]);
    exit;
}
$id = $_GET['id_dependencia'];
// Conexion a la base de datos
include 'conexion.php';
// Consulta para seleccionar las dependencias
$query = "SELECT id_funcionario, nombre_funcionario FROM funcionario WHERE id_dependencia = '$id'";
$resultado = $conexion->query($query);

$funcionario = [];

while ($fila = $resultado->fetch_assoc()) {
    $funcionario[] = $fila;
}

echo json_encode($funcionario);

$conexion->close();
