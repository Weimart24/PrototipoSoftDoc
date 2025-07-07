<?php
session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['name'])) {
    header("Location: ../../../login.php");
    exit();
}

include_once("conexion.php");
include_once("alerta.php");

$idFuncionario = $_GET['id'] ?? null;

// ID del usuario con sesión activa
$idSesion = $_SESSION['id'];

if ($idFuncionario) {
    // Evitar que el usuario se desactive a sí mismo
    if ($idFuncionario == $idSesion) {
        mostrarAlerta('warning', 'Acción no permitida', 'No puede desactivarse a usted mismo.', '../html/funcionario.php', 3000);
        exit();
    }

    // Verificar estado actual del funcionario
    $stmt = $conexion->prepare("SELECT activo FROM funcionario WHERE id_funcionario = ?");
    $stmt->bind_param("i", $idFuncionario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $estadoActual = $row['activo'];
        $nuevoEstado = ($estadoActual == 1) ? 0 : 1;

        // Actualizar estado
        $update = $conexion->prepare("UPDATE funcionario SET activo = ? WHERE id_funcionario = ?");
        $update->bind_param("ii", $nuevoEstado, $idFuncionario);

        if ($update->execute()) {
            $mensaje = $nuevoEstado == 1 
                ? 'FUNCIONARIO ACTIVADO CORRECTAMENTE' 
                : 'FUNCIONARIO DESACTIVADO CORRECTAMENTE';
            mostrarAlerta('success', '¡Éxito!', $mensaje, '../html/funcionario.php', 3500);
        } else {
            mostrarAlerta('error', 'Error', 'Error al actualizar el estado: ' . $update->error);
        }

        $update->close();
    } else {
        mostrarAlerta('error', 'Error', 'Funcionario no encontrado.');
    }

    $stmt->close();
} else {
    mostrarAlerta('error', 'Error', 'ID del funcionario no proporcionado.');
}

$conexion->close();
