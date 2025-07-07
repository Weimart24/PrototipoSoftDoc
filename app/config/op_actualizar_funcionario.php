<?php
session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['name'])) {
    header("Location: ../../../login.php");
    exit();
}
include_once("conexion.php");
include_once("alerta.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id_funcionario'];
    $tipo = $_POST['tipo'];
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $correo = $_POST['correo'];
    $dependencia = $_POST['dependencia'];
    $rol = $_POST['rol'];

    $contrasenaNueva = null;
    $actualizarContrasena = false;

    if (!empty($_POST['contrasena'])) {
        $contrasenaNueva = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);
        $actualizarContrasena = true;
    }

    // Armar la consulta dinámica
    if ($actualizarContrasena) {
        $query = "UPDATE funcionario SET tipo_documento = ?, cedula = ?, nombre_funcionario = ?, correo = ?, telefono = ?, direccion = ?, id_dependencia = ?, contrasena = ? WHERE id_funcionario = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("sssssssss", $tipo, $cedula, $nombre, $correo, $telefono, $direccion, $dependencia, $contrasenaNueva, $id);
    } else {
        $query = "UPDATE funcionario SET tipo_documento = ?, cedula = ?, nombre_funcionario = ?, correo = ?, telefono = ?, direccion = ?, id_dependencia = ? WHERE id_funcionario = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("ssssssss", $tipo, $cedula, $nombre, $correo, $telefono, $direccion, $dependencia, $id);
    }

    if ($stmt && $stmt->execute()) {
        $stmt->close();

        // Actualizar rol
        $queryRol = "UPDATE funcionario_roles SET id_rol = ? WHERE id_funcionario = ?";
        $stmtRol = $conexion->prepare($queryRol);
        if ($stmtRol) {
            $stmtRol->bind_param("ss", $rol, $id);
            if ($stmtRol->execute()) {
                mostrarAlerta('success', '¡Éxito!', 'FUNCIONARIO ACTUALIZADO CORRECTAMENTE', '../html/funcionario.php', 2500);
                $stmtRol->close();
                $conexion->close();
                exit();
            } else {
                mostrarAlerta('error', 'Error', 'Error al actualizar el rol: ' . $stmtRol->error);
            }
        } else {
            mostrarAlerta('error', 'Error', 'Error al preparar el update de rol: ' . $conexion->error);
        }
    } else {
        mostrarAlerta('error', 'Error', 'Error al actualizar el funcionario: ' . $stmt->error);
    }

    $conexion->close();
}
