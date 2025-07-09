<?php
session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['name'])) {
    header("Location: ../../../login.php");
    exit();
}

include_once("conexion.php");
include_once("alerta.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST["nombre_rol"]);
    $descripcion = trim($_POST["descripcion"]);
    $permisos = isset($_POST["permisos"]) ? $_POST["permisos"] : [];

    if (empty($nombre) || empty($descripcion) || empty($permisos)) {
        mostrarAlerta('error', 'Error', 'Todos los campos son obligatorios y debe seleccionar al menos un permiso.', '../views/crear_rol.php', 3000);
        exit();
    }

    // Insertar el nuevo rol
    $query = "INSERT INTO roles (nombre_rol, descripcion) VALUES (?, ?)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("ss", $nombre, $descripcion);

    if ($stmt->execute()) {
        $id_nuevo_rol = $stmt->insert_id;

        // Insertar permisos seleccionados en la tabla intermedia
        $stmt_perm = $conexion->prepare("INSERT INTO rol_permisos (id_rol, id_permiso) VALUES (?, ?)");
        foreach ($permisos as $id_permiso) {
            $stmt_perm->bind_param("ii", $id_nuevo_rol, $id_permiso);
            $stmt_perm->execute();
        }

        mostrarAlerta('success', '¡Éxito!', 'ROL CREADO CORRECTAMENTE', '../html/ver_rol.php?id=' . $id_nuevo_rol, 3500);
    } else {
        mostrarAlerta('error', 'Error', 'No se pudo crear el rol.', '../html/crear_rol.php', 3000);
    }

    $stmt->close();
    $conexion->close();
} else {
    echo "Método no permitido.";
}
