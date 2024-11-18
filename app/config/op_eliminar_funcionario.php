<?php
//Incluir la base de datos
include_once("conexion.php");

//Aquí hago la sentencia SQL
$query = "DELETE FROM funcionario WHERE id_funcionario =" . $_GET['id'];

if ($conexion->query($query)) {
    echo "<script>
            alert('FUNCIONARIO ELIMINADO CORRECTAMENTE');
            window.location = '../html/funcionario.php';
        </script>";
    exit();
} else {
    echo "Error al ELIMINAR al funcionario: " . $conexion->error;
}
//Cierre de la conexion
$conexion->close();
