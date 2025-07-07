<?php
session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['name'])) {
    header("Location: ../../../login.php");
    exit();
}
include_once("conexion.php");
include_once("alerta.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id_radicado'];
    $respuesta = $_POST['respuesta'];
    $finalizar = $_POST['finalizar'];
    $fecha = date('Y-m-d');

    if ($finalizar == '1') {
        $nombreUsuario = $_SESSION['name'] ?? 'Usuario desconocido';
        $respuesta .= "\n\nRadicado finalizado por $nombreUsuario";
        $respuesta .= "\n\nFecha de finalización: " . date('Y-m-d H:i:s');
        $respuesta .= "\n\nGracias por utilizar nuestro sistema de gestión de radicados.";

        // Actualizar estado en radicacion con prepared statement
        $updateQuery = "UPDATE radicacion SET activo = FALSE WHERE id_radicado = ?";
        $stmtUpdate = $conexion->prepare($updateQuery);
        if ($stmtUpdate) {
            $stmtUpdate->bind_param("s", $id);
            $stmtUpdate->execute();
            $stmtUpdate->close();
        } else {
            mostrarAlerta('error', 'Error', 'Error al preparar la actualización: ' . $conexion->error);
            exit();
        }
    }

    // Insertar el seguimiento con prepared statement
    $insertQuery = "INSERT INTO seguimiento_radicado (id_radicado, fecha_seguimiento, detalle) VALUES (?, ?, ?)";
    $stmtInsert = $conexion->prepare($insertQuery);
    if ($stmtInsert) {
        $stmtInsert->bind_param("sss", $id, $fecha, $respuesta);
        if ($stmtInsert->execute()) {
            $mensaje = ($finalizar == '1') ? 'SEGUIMIENTO FINALIZADO CORRECTAMENTE' : 'SEGUIMIENTO AGREGADO CORRECTAMENTE';
            $redirect = ($finalizar == '1') ? "/app/html/radicado.php?id=$id" : "/app/html/ver_radicado.php?id=$id";

            mostrarAlerta('success', '¡Hecho!', $mensaje, $redirect, 3500);
            $stmtInsert->close();
            $conexion->close();
            exit();
        } else {
            mostrarAlerta('error', 'Error', 'Error al ejecutar el insert: ' . $stmtInsert->error);
        }
    } else {
        mostrarAlerta('error', 'Error', 'Error al preparar el insert: ' . $conexion->error);
    }

    $conexion->close();
}
?>
