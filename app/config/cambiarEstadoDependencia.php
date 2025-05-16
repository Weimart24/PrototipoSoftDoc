<?php
include_once("conexion.php");

if (isset($_GET['id']) && isset($_GET['activo'])) {
    $id = $conexion->real_escape_string($_GET['id']);
    $estadoActual = (int)$_GET['activo'];
    $nuevoEstado = ($estadoActual === 1) ? 0 : 1;

    $query = "UPDATE dependencia SET activo = $nuevoEstado WHERE id_dependencia = '$id'";

    if ($conexion->query($query)) {
        echo "<script>
            window.location = '/app/html/dependencia.php';
        </script>";
        exit();
    } else {
        echo "Error al actualizar el estado: " . $conexion->error;
    }
}

$conexion->close();
?>

