<?php
include_once("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $conexion->real_escape_string($_POST['id_radicado']);
    $respuesta = $conexion->real_escape_string($_POST['respuesta']);
    $fecha = date('Y-m-d'); // Fecha del sistema

    //Creamos la query
    $query = "INSERT INTO seguimiento_radicado (id_radicado, fecha_seguimiento, detalle)
              VALUES ('$id', '$fecha', '$respuesta')";

    //Inicializamos la query
    if($conexion->query($query)) {
        echo "<script>
            alert('SEGUIMIENTO AGREGADO CORRECTAMENTE');
            window.location = '/app/html/ver_radicado.php?id=" . $id ."';
        </script>";
        exit();
    } else {
        echo "Error al actualizar el funcionario: " . $conexion->error;
    }
    //Cierre de la conexion
    $conexion->close();
}
