<?php
include_once("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $conexion->real_escape_string($_POST['id_radicado']);
    $dependencia = $conexion->real_escape_string($_POST['dependencia']);
    $funcionario = $conexion->real_escape_string($_POST['funcionario']);
    $fecha = date('Y-m-d'); // Fecha del sistema


    $stmt = $conexion->prepare("UPDATE radicacion SET id_dependencia = ?, id_funcionario = ? WHERE id_radicado = ?");
    $stmt->bind_param("sii", $dependencia, $funcionario, $id);

    // Ejecutar y verificar
    if ($stmt->execute()) {
        echo "Actualización exitosa.";
    } else {
        echo "Error al actualizar: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
}
?>

