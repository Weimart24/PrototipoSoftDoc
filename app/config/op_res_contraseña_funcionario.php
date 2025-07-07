<?php
include("conexion.php");
include("alerta.php");

if (!isset($_GET['id']) || empty($_GET['id'])) {
    mostrarAlerta('error', 'Error', 'ID del funcionario no proporcionado.', '../html/funcionario.php', 3000);
    exit();
}

$idFuncionario = intval($_GET['id']);

// Obtener la cédula del funcionario
$stmt = $conexion->prepare("SELECT cedula FROM funcionario WHERE id_funcionario = ?");
$stmt->bind_param("i", $idFuncionario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    mostrarAlerta('error', 'Error', 'Funcionario no encontrado.', '../html/funcionario.php', 3000);
    exit();
}

$row = $result->fetch_assoc();
$nuevaContrasena = password_hash($row['cedula'], PASSWORD_DEFAULT); // Encriptar cédula

// Actualizar contraseña
$update = $conexion->prepare("UPDATE funcionario SET contrasena = ? WHERE id_funcionario = ?");
$update->bind_param("si", $nuevaContrasena, $idFuncionario);

if ($update->execute()) {
    mostrarAlerta('success', '¡Listo!', 'Contraseña restablecida con la cédula. Recuerde que cuando inicie sesión el usuario el sistema le pide cambio de contraseña obligatorio.', '', null);
} else {
    mostrarAlerta('error', 'Error', 'No se pudo restablecer la contraseña.', '', null);
}

$update->close();
$stmt->close();
$conexion->close();
?>
