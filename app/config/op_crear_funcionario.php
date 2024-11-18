<?php
include_once("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo = $conexion->real_escape_string($_POST['tipo']);
    $cedula = $conexion->real_escape_string($_POST['cedula']);
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $telefono = $conexion->real_escape_string($_POST['telefono']);
    $direccion = $conexion->real_escape_string($_POST['direccion']);
    $correo = $conexion->real_escape_string($_POST['correo']);
    $contrasena = $conexion->real_escape_string($_POST['contrasena']);
    $dependencia = $conexion->real_escape_string($_POST['dependencia']);


    //Creamos la query
    $query = "INSERT INTO funcionario (tipo_documento, cedula, nombre_funcionario, correo, contrasena, telefono, direccion, id_dependencia)
    VALUES ('$tipo', '$cedula', '$nombre', '$correo', '$contrasena', '$telefono', '$direccion', '$dependencia')";


    //Inicializamos la query
    if ($conexion->query($query)) {
        echo "<script>
            alert('FUNCIONARIO CREADO CORRECTAMENTE');
            window.location = '../html/funcionario.php';
        </script>";
        exit();
    } else {
        echo "Error al crear el funcionario: " . $conexion->error;
    }
    //Cierre de la conexion
    $conexion->close();
}
