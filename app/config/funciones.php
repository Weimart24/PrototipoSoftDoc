
<?php 
//Función para obtener el nombre de la dependencia
function obtenerDependenciaPorCodigo($ID)
{
    if ($ID == "") {
        return "No se ha especificado un código de dependencia.";
    }
    include '../config/conexion.php';
    $query = "SELECT * FROM dependencia WHERE id_dependencia = '$ID'";
    $resultado = $conexion->query($query);

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        return $fila["nombre_dependencia"];
    } else {
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
    $query = "SELECT r.id_rol, r.nombre_rol FROM roles r
    JOIN funcionario_roles fr ON r.id_rol = fr.id_rol
    WHERE fr.id_funcionario = '$ID'";
    $resultadoRol = $conexion->query($query);

    if ($resultadoRol->num_rows > 0) {
        $filaRol = $resultadoRol->fetch_assoc();
        return $filaRol["nombre_rol"];
    } else {
        return "No se encontró ningun rol de ese funcionario.";
    }
}

function obtenerIdRol($ID)
{
    if ($ID == "") {
        return "No se ha especificado un id.";
    }
    include '../config/conexion.php';
    $query = "SELECT r.id_rol, r.nombre_rol FROM roles r
    JOIN funcionario_roles fr ON r.id_rol = fr.id_rol
    WHERE fr.id_funcionario = '$ID'";
    $resultadoRol = $conexion->query($query);

    if ($resultadoRol->num_rows > 0) {
        $filaRol = $resultadoRol->fetch_assoc();
        return $filaRol["id_rol"];
    } else {
        return "No se encontró ningun rol de ese funcionario.";
    }
}

?>