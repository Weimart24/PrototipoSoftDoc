<?php
session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['name'])) {
    header("Location: ../../../login.php");
    exit();
}
include_once("conexion.php");
include_once("alerta.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $conexion->real_escape_string($_POST['id_radicado']);
    $dependencia = $conexion->real_escape_string($_POST['dependencia']);
    $funcionario = $conexion->real_escape_string($_POST['funcionario']);
    $fecha = date('Y-m-d'); // Fecha del sistema


    $stmt = $conexion->prepare("UPDATE radicacion SET id_dependencia = ?, id_funcionario = ? WHERE id_radicado = ?");
    $stmt->bind_param("sii", $dependencia, $funcionario, $id);

    // Ejecutar y verificar
    if ($stmt->execute()) {
        mostrarAlerta('success', '¡Éxito!', 'Radicado dirigido correctamente.', '/app/html/radicado.php', 2500);
        exit();
    } else {
        mostrarAlerta('error', 'Error', 'Error al actualizar: ' . $stmt->error);
    }
    $stmt->close();
    $conexion->close();
}
?>

