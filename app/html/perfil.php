<?php
session_start();
if (!isset($_SESSION['name']) && !isset($_SESSION['id'])) {
  header('Location: ../../index.php');
}
include '../config/conexion.php';
include_once '../config/funciones.php';

// Obtener la información del usuario
$id = $_SESSION['id'];
$query = "SELECT * FROM funcionario WHERE id_funcionario = '$id'";
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
        <div class="container py-4">
          <div class="row justify-content-center">
              <div class="col-lg-8">
                  <div class="card shadow rounded-4">
                      <div class="card-body p-4">
                          <div class="d-flex justify-content-between align-items-center mb-3">
                              <h3 class="fw-bold mb-0 text-primary">
                                  <?php echo $fila['nombre_funcionario']; ?>
                              </h3>
                          </div>

                          <ul class="list-group list-group-flush">
                              <li class="list-group-item">
                                  <strong>Cédula:</strong> <?php echo $fila['cedula']; ?>
                              </li>
                              <li class="list-group-item">
                                  <strong>Correo:</strong> <?php echo $fila['correo']; ?>
                              </li>
                              <li class="list-group-item">
                                  <strong>Teléfono:</strong> <?php echo $fila['telefono']; ?>
                              </li>
                              <li class="list-group-item">
                                  <strong>Dirección:</strong> <?php echo $fila['direccion']; ?>
                              </li>
                              <li class="list-group-item">
                                  <strong>Dependencia:</strong> <?php echo obtenerDependenciaPorCodigo($fila['id_dependencia']); ?>
                              </li>
                          </ul>
                      </div>
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