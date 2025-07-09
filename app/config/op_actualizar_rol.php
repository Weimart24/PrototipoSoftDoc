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
  $nombre = trim($_POST['nombre_rol']);
  $descripcion = trim($_POST['descripcion']);

  $query = "UPDATE roles SET nombre_rol = ?, descripcion = ? WHERE id_rol = ?";
  $stmt = $conexion->prepare($query);
  $stmt->bind_param("ssi", $nombre, $descripcion, $id_rol);

  if ($stmt->execute()) {
    mostrarAlerta('success', '¡Éxito!', 'ROL ACTUALIZADO CORRECTAMENTE', "../html/ver_rol.php?id=$id_rol", 3500);
  } else {
    mostrarAlerta('error', '¡Error!', 'No se pudo actualizar el rol.', "../html/ver_rol.php?id=$id_rol", 3500);
  }
} else {
  echo "Método no permitido.";
}
?>
