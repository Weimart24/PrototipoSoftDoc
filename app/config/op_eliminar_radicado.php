<?php
//Incluir la base de datos
include_once ("conexion.php");

//Aquí hago la sentencia SQL
$query = "DELETE FROM radicacion WHERE id_radicado =" . $_GET['id'];

if($conexion->query($query)){
    echo "<script>
            alert('RADICADO ELIMINADO CORRECTAMENTE');
            window.location = '../html/radicado.php';
        </script>";
    exit();
}else{
    echo "Error al ELIMINAR al radicado: ". $conexion->error;
}
//Cierre de la conexion
$conexion->close();