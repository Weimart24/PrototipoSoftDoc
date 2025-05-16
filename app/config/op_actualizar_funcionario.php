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
    $rol = $conexion->real_escape_string($_POST['rol']);
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
        $queryRol = "UPDATE funcionario_roles SET id_rol = '$rol' WHERE id_funcionario = '$id'";
        //Ejecutamos la query
        if ($conexion->query($queryRol)) {
            //Si se inserta correctamente el rol, redirigimos a la pagina de funcionarios
            echo "<script>
                alert('FUNCIONARIO ACTUALIZADO CORRECTAMENTE');
                window.location = '../html/funcionario.php';
            </script>";
            exit();
        } else {
            echo "Error al crear el rol: " . $conexion->error;
        }
    }
};
$conexion->close();
