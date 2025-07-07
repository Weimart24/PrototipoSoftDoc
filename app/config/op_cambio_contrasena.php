<?php
session_start();
include_once("conexion.php");
include_once("alerta.php");

if (!isset($_SESSION['id']) || !isset($_SESSION['name'])) {
    mostrarAlerta('error', 'Acceso denegado', 'Debe iniciar sesión.', '../../login.php', 3000);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nueva = $_POST['nueva_contrasena'] ?? '';
    $confirmar = $_POST['confirmar_contrasena'] ?? '';

    if (empty($nueva) || empty($confirmar)) {
        mostrarAlerta('warning', 'Campos vacíos', 'Debes ingresar y confirmar la nueva contraseña.');
        exit();
    }

    if ($nueva !== $confirmar) {
        mostrarAlerta('warning', 'No coinciden', 'Las contraseñas no coinciden.');
        exit();
    }

    $nuevaHash = password_hash($nueva, PASSWORD_BCRYPT);
    $id = $_SESSION['id'];

    $stmt = $conexion->prepare("UPDATE funcionario SET contrasena = ? WHERE id_funcionario = ?");
    $stmt->bind_param("si", $nuevaHash, $id);

    if ($stmt->execute()) {
        $stmt->close();
        $conexion->close();
        mostrarAlerta('success', 'Contraseña actualizada', 'Has cambiado tu contraseña correctamente.', '../html/radicado.php', 3000);
        exit();
    } else {
        mostrarAlerta('error', 'Error', 'No se pudo actualizar la contraseña.');
        exit();
    }
}
?>
