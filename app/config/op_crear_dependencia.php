<?php
include_once("conexion.php");
include_once("alerta.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $conexion->real_escape_string($_POST['id']);
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $telefono = $conexion->real_escape_string($_POST['telefono']);
    $estado = 1;

    // Validar si el id ya existe
    $checkQuery = "SELECT id_dependencia FROM dependencia WHERE id_dependencia = '$id'";
    $resultado = $conexion->query($checkQuery);

    if ($resultado->num_rows > 0) {
        echo "<script>
            alert('EL ID DE DEPENDENCIA YA EXISTE, INGRESE UNO DIFERENTE');
            window.history.back();
        </script>";
        exit();
    }

    // Insertar si no existe
    $query = "INSERT INTO dependencia (id_dependencia, nombre_dependencia, telefono, activo)
              VALUES ('$id', '$nombre', '$telefono', '$estado')";

    if ($conexion->query($query)) {
        mostrarAlerta('success', '¡Listo!', 'DEPENDENCIA CREADA CORRECTAMENTE', '../html/dependencia.php', 2000);
        exit();
    } else {
        mostrarAlerta('error', 'Error', 'Error al crear la dependencia: ' . $conexion->error);
    }

    $conexion->close();
}
?>

