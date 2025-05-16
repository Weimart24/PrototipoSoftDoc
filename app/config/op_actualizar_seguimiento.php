<?php
include_once("conexion.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $conexion->real_escape_string($_POST['id_radicado']);
    $respuesta = $conexion->real_escape_string($_POST['respuesta']);
    $finalizar = $conexion->real_escape_string($_POST['finalizar']);
    $fecha = date('Y-m-d'); // Fecha actual del sistema

    // Si finalizar es 1, se modifica el mensaje y se actualiza la tabla radicacion
    if ($finalizar == '1') {
        $nombreUsuario = $_SESSION['name'] ?? 'Usuario desconocido';
        $respuesta .= "\n\nRadicado finalizado por <strong>$nombreUsuario</strong>";
        $respuesta .= "\n\nFecha de finalización: " . date('Y-m-d H:i:s');
        $respuesta .= "\n\nGracias por utilizar nuestro sistema de gestión de radicados.";

        // Actualizar estado en radicacion
        $updateQuery = "UPDATE radicacion SET activo = FALSE WHERE id_radicado = '$id'";
        $conexion->query($updateQuery); // Se ejecuta la actualización sin comprobar si fue exitosa
    }

    // Insertar el seguimiento
    $insertQuery = "INSERT INTO seguimiento_radicado (id_radicado, fecha_seguimiento, detalle)
                    VALUES ('$id', '$fecha', '$respuesta')";

    if ($conexion->query($insertQuery)) {
        $mensaje = ($finalizar == '1') ? 'SEGUIMIENTO FINALIZADO CORRECTAMENTE' : 'SEGUIMIENTO AGREGADO CORRECTAMENTE';
        $redirect = ($finalizar == '1') ? "/app/html/radicado.php?id=$id" : "/app/html/ver_radicado.php?id=$id";
        echo "<script>
            alert('$mensaje');
            window.location = '$redirect';
        </script>";
        exit();
    } else {
        echo "Error al agregar el seguimiento: " . $conexion->error;
    }
    

    $conexion->close();
}
?>

