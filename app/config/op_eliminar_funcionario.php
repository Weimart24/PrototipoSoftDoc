<?php
// Incluir la base de datos
include_once("conexion.php");
include_once("alerta.php");

// Obtener el ID del funcionario desde el parámetro GET
$idFuncionario = $_GET['id'] ?? null;

if ($idFuncionario) {
    // Primero eliminar los registros relacionados en la tabla funcionario_roles
    $queryRoles = "DELETE FROM funcionario_roles WHERE id_funcionario = $idFuncionario";
    $conexion->query($queryRoles);

    // Luego eliminar el funcionario
    $queryFuncionario = "DELETE FROM funcionario WHERE id_funcionario = $idFuncionario";

    if ($conexion->query($queryFuncionario)) {
        mostrarAlerta('success', '¡Éxito!', 'FUNCIONARIO ELIMINADO CORRECTAMENTE', '../html/funcionario.php', 2500);
        exit();
    } else {
        mostrarAlerta('error', 'Error', 'Error al eliminar al funcionario: ' . $conexion->error);
    }

} else {
     mostrarAlerta('error', 'Error', 'ID del funcionario no proporcionada.');
}

// Cierre de la conexión
$conexion->close();
?>

