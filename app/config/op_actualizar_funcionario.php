<?php
include_once("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $conexion->real_escape_string($_POST['id_funcionario']);
    $tipo = $conexion->real_escape_string($_POST['tipo']);
    $cedula = $conexion->real_escape_string($_POST['cedula']);
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $telefono = $conexion->real_escape_string($_POST['telefono']);
    $direccion = $conexion->real_escape_string($_POST['direccion']);
    $correo = $conexion->real_escape_string($_POST['correo']);
    $contrasena = $conexion->real_escape_string($_POST['contrasena']);
    $dependencia = $conexion->real_escape_string($_POST['dependencia']);

    //Elimina las palabras extras que no necesitamos de la base de datos
    $dependencia = explode(' ', $dependencia)[0];

    //Creamos la query
    $query = "UPDATE funcionario SET
    tipo_documento = '$tipo',
    cedula = '$cedula',
    nombre_funcionario = '$nombre',
    correo = '$correo',
    contrasena = '$contrasena',
    telefono = '$telefono',
    direccion = '$direccion',
    id_dependencia = '$dependencia'
    WHERE id_funcionario = '$id'";
    

    //Inicializamos la query
    if($conexion->query($query)) {
        echo "<script>
            alert('FUNCIONARIO ACTUALIZADO CORRECTAMENTE');
            window.location = '../html/funcionario.php';
        </script>";
        exit();
    } else {
        echo "Error al actualizar el funcionario: " . $conexion->error;
    }
    //Cierre de la conexion
    $conexion->close();
}
