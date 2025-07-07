<?php
session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['name'])) {
    header("Location: ../../../login.php");
    exit();
}
include_once("conexion.php");
include_once("alerta.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $estado = 1;

    // Validar si el ID ya existe
    $checkQuery = "SELECT id_dependencia FROM dependencia WHERE id_dependencia = ?";
    $stmtCheck = $conexion->prepare($checkQuery);
    if ($stmtCheck) {
        $stmtCheck->bind_param("s", $id);
        $stmtCheck->execute();
        $stmtCheck->store_result();

        if ($stmtCheck->num_rows > 0) {
            $stmtCheck->close();
            $conexion->close();
            mostrarAlerta('warning', 'Atención', 'EL ID DE DEPENDENCIA YA EXISTE, INGRESE UNO DIFERENTE', '', 3500);
        exit();
}

        $stmtCheck->close();
    } else {
        mostrarAlerta('error', 'Error', 'Error al validar ID: ' . $conexion->error);
        $conexion->close();
        exit();
    }

    // Insertar si no existe
    $insertQuery = "INSERT INTO dependencia (id_dependencia, nombre_dependencia, telefono, activo)
                    VALUES (?, ?, ?, ?)";
    $stmtInsert = $conexion->prepare($insertQuery);
    if ($stmtInsert) {
        $stmtInsert->bind_param("sssi", $id, $nombre, $telefono, $estado);
        if ($stmtInsert->execute()) {
            mostrarAlerta('success', '¡Listo!', 'DEPENDENCIA CREADA CORRECTAMENTE', '../html/dependencia.php', 2000);
            $stmtInsert->close();
            $conexion->close();
            exit();
        } else {
            mostrarAlerta('error', 'Error', 'Error al crear la dependencia: ' . $stmtInsert->error);
        }
        $stmtInsert->close();
    } else {
        mostrarAlerta('error', 'Error', 'Error al preparar el insert: ' . $conexion->error);
    }

    $conexion->close();
}
?>
