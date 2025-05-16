<?php
session_start();
if (!isset($_SESSION['name']) && !isset($_SESSION['id'])) {
  header('Location: ../../index.php');
}
include '../config/conexion.php';

// Obtener la información del usuario
$id = $_SESSION['id'];
$query = "SELECT * FROM funcionario WHERE cedula = '$id'";
$resultado = $conexion->query($query);
$fila = $resultado->fetch_assoc();
?>

<!doctype html>
<html lang="es">

<head>
  <?php include 'modulos/head.php' ?>
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <?php include 'modulos/sidebar.php' ?>
      <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <?php include 'modulos/header.php' ?>
      <!--  Header End -->
      <div class="container-fluid">
        <!-- Perfil de Usuario -->
        <div class="col-lg-12">
          <div class="card mb-4">
            <div class="card-body">
              <h3 class="text-left">Perfil de Usuario</h3>
              <p><strong>Cédula:</strong> <?php echo $fila['cedula']; ?></p>
              <p><strong>Nombre:</strong> <?php echo $fila['nombre_funcionario']; ?></p>
              <p><strong>Correo:</strong> <?php echo $fila['correo']; ?></p>
              <p><strong>Teléfono:</strong> <?php echo $fila['telefono']; ?></p>
              <p><strong>Dirección:</strong> <?php echo $fila['direccion']; ?></p>
              <p><strong>Dependencia:</strong> <?php echo $fila['id_dependencia']; ?></p>
              <p><strong>Id:</strong> <?php echo $fila['id_funcionario']; ?></p>
              <!-- Añade más campos según sea necesario -->
              
              <td><button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalAct">Actualizar</button></td>
              <div class="modal fade text-black" id="modalAct">
              <?php include "modals/actualizar_funcionario.php" ?>
              </div>
            </div>
          </div>
        </div>
        <!-- FIN Perfil de Usuario -->
        <div class="py-6 px-6 text-center">
          <p class="mb-0 fs-4">Diseñado y desarrollado por <a href="https://softDocument.com/" target="_blank"
              class="pe-1 text-primary text-decoration-underline">SoftDocument.com</a></p>
        </div>
      </div>
    </div>
  </div>
  <?php include_once 'modulos/script.php' ?>
</body>

</html>

<?php
// Cerrar la conexión
$conexion->close();
?>