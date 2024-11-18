
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
        return $fila['id_dependencia'].' - '.$fila["nombre_dependencia"];
    } else {
        return "No se encontró ninguna dependencia con el código especificado.";
    }
}
// 

?>