<?php
session_start();
if (!isset($_SESSION['name']) && !isset($_SESSION['id'])) {
  header('Location: ../../index.php');
}
include '../config/conexion.php';
$query = "SELECT * FROM radicacion WHERE NOT id_radicado=1";
$resultado = $conexion->query($query);
include_once '../config/listar_dependencia.php';
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
                  <td>Documento</td>
                  <td>Radicado</td>
                  <td>Cédula</td>
                  <td>Nombre remitente</td>
                  <td>Teléfono</td>
                  <td>Correo</td>
                  <td>Fecha Radicado</td>
                  <td>Medio Recepción</td>
                  <td>Asunto</td>
                  <td>Dependencia</td>
                  <td>Pais</td>
                  <td>Departamento</td>
                  <td>Municipio</td>
                  <td>Actualizar</td>
                  <td>Eliminar</td>
                </thead>
                <tbody>
                  <?php
                  if ($resultado->num_rows > 0) {
                    while ($fila = $resultado->fetch_assoc()) {
                      echo "<tr>";
                        if (!empty($fila["documento"])) {
                        echo '<td><a href="../../' . $fila["documento"] . '" target="_blank">Ver Documento</a></td>';
                        } else {
                        echo '<td>No hay documento</td>';
                        }
                      echo "<td>" . $fila["radicado"] . "</td>";
                      echo "<td>" . $fila["cedula_remitente"] . "</td>";
                      echo "<td>" . $fila["nombre_remitente"] . "</td>";
                      echo "<td>" . $fila["telefono"] . "</td>";
                      echo "<td>" . $fila["correo"] . "</td>";
                      echo "<td>" . $fila["fecha_radicado"] . "</td>";
                      echo "<td>" . $fila["medio_recepcion"] . "</td>";
                      echo "<td>" . $fila["asunto"] . "</td>";
                      echo "<td>" . $fila["dependencia"] . "</td>";
                      echo "<td>" . $fila["pais"] . "</td>";
                      echo "<td>" . $fila["departamento"] . "</td>";
                      echo "<td>" . $fila["municipio"] . "</td>";
                      echo '<td><button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalAct' . $fila['id_radicado'] . '">Actualizar</button></td>'; ?>
                      <div class="modal fade text-black" id="modalAct<?php echo $fila['id_radicado'] ?>">
                        <?php include "modals/actualizar_radicado.php" ?>
                      </div>
                  <?php
                      echo "<td><a href='../config/op_eliminar_radicado.php?id=" . $fila["id_radicado"] . "' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este registro?\")'><i class='ti ti-backspace'></i></a></td>";
                      echo "</tr>";
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