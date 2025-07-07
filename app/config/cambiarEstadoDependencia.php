<?php
include_once("conexion.php");

if (isset($_GET['id']) && isset($_GET['activo'])) {
    $id = $_GET['id'];
    $estadoActual = (int)$_GET['activo'];
    $nuevoEstado = ($estadoActual === 1) ? 0 : 1;

    $query = "UPDATE dependencia SET activo = ? WHERE id_dependencia = ?";
    $stmt = $conexion->prepare($query);

    if ($stmt) {
        $stmt->bind_param("is", $nuevoEstado, $id);
        if ($stmt->execute()) {
            echo "<script>
                window.location = '/app/html/dependencia.php';
            </script>";
            $stmt->close();
            $conexion->close();
            exit();
        } else {
            echo "Error al ejecutar la consulta: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conexion->error;
    }
}

$conexion->close();
?>
