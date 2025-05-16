<?php
include_once("conexion.php");
include_once("alerta.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo = $conexion->real_escape_string($_POST['tipo']);
    $cedula = $conexion->real_escape_string($_POST['cedula']);
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $telefono = $conexion->real_escape_string($_POST['telefono']);
    $direccion = $conexion->real_escape_string($_POST['direccion']);
    $correo = $conexion->real_escape_string($_POST['correo']);
    $contrasena = $conexion->real_escape_string($_POST['contrasena']);
    $dependencia = $conexion->real_escape_string($_POST['dependencia']);
    $roles = $conexion->real_escape_string($_POST['roles']);


    //Creamos la query
    $query = "INSERT INTO funcionario (tipo_documento, cedula, nombre_funcionario, correo, contrasena, telefono, direccion, id_dependencia)
    VALUES ('$tipo', '$cedula', '$nombre', '$correo', '$contrasena', '$telefono', '$direccion', '$dependencia')";

    //Inicializamos la query
    if ($conexion->query($query)) {
        $id_funcionario = $conexion->insert_id;
        $queryRol = "INSERT INTO funcionario_roles (id_funcionario, id_rol) VALUES ('$id_funcionario', '$roles')";
        if ($conexion->query($queryRol)) {
            mostrarAlerta('success', '¡Éxito!', 'FUNCIONARIO CREADO CORRECTAMENTE', '../html/funcionario.php', 2500);
            exit();
        } else {
            mostrarAlerta('error', 'Error', 'Error al crear el rol: ' . $conexion->error);
        }
    }

    //Cierre de la conexion
    $conexion->close();
}
