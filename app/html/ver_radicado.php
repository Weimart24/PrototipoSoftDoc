<?php
session_start();
if (!isset($_SESSION['validate'])) {
  header('Location: ../../index.php');
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    exit('Parámetro "id" no proporcionado.');
}
$id = $_GET['id'];



include '../config/conexion.php';
$query = "SELECT * FROM radicacion WHERE id_radicado = '$id'";
$resultado = $conexion->query($query);
$fila = $resultado->fetch_assoc();

$queryS = "SELECT * FROM seguimiento_radicado WHERE id_radicado = '$id'";
$resulS = $conexion->query($queryS);
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
              <h3 class="text-left">Radicado # <?php echo $fila['radicado'] ?></h3>
            <div class="table-responsive p-3">
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Nombre Remitente</label>
                    <p><?php echo $fila['nombre_remitente'] ?></p>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Tipo de documento</label>
                    <p><?php echo $fila['tipo_documento'] ?></p>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Cédula remitente</label>
                    <p><?php echo $fila['cedula_remitente'] ?></p>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Teléfono</label>
                    <p><?php echo $fila['telefono'] ?></p>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Dirección</label>
                    <p><?php echo $fila['direccion'] ?></p>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Correo electrónico</label>
                    <p><?php echo $fila['correo'] ?></p>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Fecha radicado</label>
                    <p><?php echo $fila['fecha_radicado'] ?></p>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="form-label">País</label>
                    <p><?php echo $fila['pais'] ?></p>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Departamento</label>
                    <p><?php echo $fila['departamento'] ?></p>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Municipio</label>
                    <p><?php echo $fila['municipio'] ?></p>
                  </div>
                </div>
                
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Asunto</label>
                    <p><?php echo $fila['asunto'] ?></p>
                  </div>
                  <h5 class="mt-5">Seguimientos</h5>
                    <hr>
                    <?php
                    if ($resulS->num_rows > 0) {
                        while ($seguimiento = $resulS->fetch_assoc()) {
                            ?>
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="form-label mb-0">Detalle</label>
                                    <small class="text-muted"><?php echo $seguimiento['fecha_seguimiento']; ?></small>
                                </div>
                                <textarea name="detalle" class="form-control" rows="3" readonly><?php echo $seguimiento['detalle']; ?></textarea>
                            </div>
                            <?php
                        }
                    } else {
                        echo "<p class='text-muted'>No hay seguimientos para este radicado.</p>";
                    }
                    ?>
              </div>

            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalNuevaRespuesta">
              Añadir respuesta
            </button>

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

<!-- Modal -->
<div class="modal fade" id="modalNuevaRespuesta" tabindex="-1" aria-labelledby="modalNuevaRespuestaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="/app/config/op_actualizar_seguimiento.php" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalNuevaRespuestaLabel">Nueva respuesta</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <input type="number" name="id_radicado" value="<?php echo $fila['id_radicado'] ?>" hidden>
            <label for="detalle" class="form-label">Detalle</label>
            <textarea name="respuesta" id="detalle" class="form-control" rows="4" required></textarea>
          </div>
          <!-- Aquí puede incluir un input hidden si necesita enviar el ID del radicado -->
          <input type="hidden" name="id_radicado" value="<?php echo $fila['id_radicado']; ?>">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
      </div>
    </form>
  </div>
</div>
</html>

<?php
// Cerrar la conexión
$conexion->close();
?>