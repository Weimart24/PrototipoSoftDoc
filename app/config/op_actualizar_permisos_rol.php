<?php
session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['name'])) {
    header("Location: ../../../login.php");
    exit();
}

include_once("conexion.php");
include_once("alerta.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id_rol = $_POST['id_rol'];
  $permisos = isset($_POST['permisos']) ? $_POST['permisos'] : [];

  // 1. Eliminar todos los permisos actuales del rol
  $conexion->query("DELETE FROM rol_permisos WHERE id_rol = $id_rol");

  // 2. Insertar los permisos seleccionados
  $stmt = $conexion->prepare("INSERT INTO rol_permisos (id_rol, id_permiso) VALUES (?, ?)");
  foreach ($permisos as $id_permiso) {
    $stmt->bind_param("ii", $id_rol, $id_permiso);
    $stmt->execute();
  }

  mostrarAlerta('success', '¡Éxito!', 'PERMISOS ACTUALIZADOS CORRECTAMENTE', "../html/ver_rol.php?id=$id_rol", 3500);
} else {
  echo "Acceso no permitido.";
}
?>
