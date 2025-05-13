<?php
session_start();
if (!isset($_SESSION['validate'])) {
  header('Location: ../../index.php');
}
include '../config/conexion.php';
$query = "SELECT * FROM radicacion WHERE id_radicado ORDER BY id_radicado DESC";
$resultado = $conexion->query($query);
include_once '../config/funciones.php';
?>


<!doctype html>
<html lang="en">

<head>
  <?php include 'modulos/head.php' ?>
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
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
        <!-- radicados.php visualizar los radicados -->
        <div class="col-lg-12">
          <div class="card mb-4">
            <div class="table-responsive p-3">
              <h3 class="text-left">REGISTRO DE CORRESPONDENCIA RECIBIDA</h3>
              <table class="table align-items-center table-flush" id="dataTable">
                <thead>
                  <tr>
                    <td>Examinar</td>
                    <td>Radicado</td>
                    <td>Nombre remitente</td>
                    <td>Fecha Radicado</td>
                    <td>Asunto</td>
                    <td>Dependencia</td>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if ($resultado->num_rows > 0) {
                    while ($fila = $resultado->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td><a href='ver_radicado.php?id=" . $fila["id_radicado"] . "' class='btn btn-outline-info btn-sm'>Ver</a></td>";
                      echo "<td>" . $fila["radicado"] . "</td>";
                      echo "<td>" . $fila["nombre_remitente"] . "</td>";
                      echo "<td>" . $fila["fecha_radicado"] . "</td>";
                      echo "<td>" . $fila["asunto"] . "</td>";
                      echo "<td>" . obtenerDependenciaPorCodigo($fila['id_dependencia']) . "</td>";
                    }
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- FIN radicados.php visualizar los radicados -->
        <div class="py-6 px-6 text-center">
          <p class="mb-0 fs-4">Diseñado y desarrollado por <a href="https://softDocument.com/" target="_blank" class="pe-1 text-primary text-decoration-underline">SoftDocument.com</a></p>
        </div>
      </div>
    </div>
  </div>
  <?php include 'modulos/script.php' ?>
</body>

</html>

<?php
// Cerrar la conexión
$conexion->close();
?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
      const urlParams = new URLSearchParams(window.location.search);
      const status = urlParams.get('status');
      const message = urlParams.get('message');

      if (status && message) {
        Swal.fire({
          icon: status === 'success' ? 'success' : 'error',
          title: status === 'success' ? '¡Éxito!' : 'Error',
          text: decodeURIComponent(message),
          confirmButtonColor: '#3085d6'
        }).then(() => {
          //  Limpiar la URL para evitar alerta en recarga o regreso
          window.history.replaceState({}, document.title, window.location.pathname);
        });
      }
    });
  </script>