<?php
//Función para obtener el nombre de la dependencia
function obtenerDependenciaPorCodigo($ID)
{
    if ($ID == "") {
        return "No se ha especificado un código de dependencia.";
    }

    include '../config/conexion.php';

    $query = "SELECT nombre_dependencia FROM dependencia WHERE id_dependencia = ?";
    $stmt = $conexion->prepare($query);
    if (!$stmt) return "Error en la consulta: " . $conexion->error;

    $stmt->bind_param("s", $ID);
    $stmt->execute();
    $stmt->bind_result($nombre_dependencia);
    
    if ($stmt->fetch()) {
        $stmt->close();
        return $nombre_dependencia;
    } else {
        $stmt->close();
        return "No se encontró ninguna dependencia con el código especificado.";
    }
}

//Función para obtener el rol
function obtenerRol($ID)
{
    if ($ID == "") {
        return "No se ha especificado un id.";
    }

    include '../config/conexion.php';

    $query = "SELECT r.nombre_rol FROM roles r
              JOIN funcionario_roles fr ON r.id_rol = fr.id_rol
              WHERE fr.id_funcionario = ?";
    $stmt = $conexion->prepare($query);
    if (!$stmt) return "Error en la consulta: " . $conexion->error;

    $stmt->bind_param("s", $ID);
    $stmt->execute();
    $stmt->bind_result($nombre_rol);

    if ($stmt->fetch()) {
        $stmt->close();
        return $nombre_rol;
    } else {
        $stmt->close();
        return "No se encontró ningun rol de ese funcionario.";
    }
}

//Función para obtener el ID del rol
function obtenerIdRol($ID)
{
    if ($ID == "") {
        return "No se ha especificado un id.";
    }

    include '../config/conexion.php';

    $query = "SELECT r.id_rol FROM roles r
              JOIN funcionario_roles fr ON r.id_rol = fr.id_rol
              WHERE fr.id_funcionario = ?";
    $stmt = $conexion->prepare($query);
    if (!$stmt) return "Error en la consulta: " . $conexion->error;

    $stmt->bind_param("s", $ID);
    $stmt->execute();
    $stmt->bind_result($id_rol);

    if ($stmt->fetch()) {
        $stmt->close();
        return $id_rol;
    } else {
        $stmt->close();
        return "No se encontró ningun rol de ese funcionario.";
    }
}
?>
