<?php
// Incluir la base de datos
include_once("conexion.php");

// Obtener el ID del funcionario desde el parámetro GET
$idFuncionario = $_GET['id'] ?? null;

if ($idFuncionario) {
    // Primero eliminar los registros relacionados en la tabla funcionario_roles
    $queryRoles = "DELETE FROM funcionario_roles WHERE id_funcionario = $idFuncionario";
    $conexion->query($queryRoles);

    // Luego eliminar el funcionario
    $queryFuncionario = "DELETE FROM funcionario WHERE id_funcionario = $idFuncionario";

    if ($conexion->query($queryFuncionario)) {
        echo "<script>
                alert('FUNCIONARIO ELIMINADO CORRECTAMENTE');
                window.location = '../html/funcionario.php';
              </script>";
        exit();
    } else {
        echo "Error al eliminar al funcionario: " . $conexion->error;
    }
} else {
    echo "ID de funcionario no proporcionado.";
}

// Cierre de la conexión
$conexion->close();
?>

