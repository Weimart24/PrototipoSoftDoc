<?php
if (!isset($_POST['radicado'])) {
    exit();
}
// Incluir la conexión a la base de datos
include '../../config/conexion.php';

$radicado = $_POST['radicado'];

// Consulta para obtener los datos del radicado
$stmt = $conexion->prepare("SELECT * FROM radicacion WHERE radicado = ?");
$stmt->bind_param("s", $radicado); // "s" porque es string
$stmt->execute();
$resulRadicado = $stmt->get_result();

// Verificar si se encontró el radicado
if ($resulRadicado->num_rows === 0) {
    echo "<script>
        alert('No se encontró ningún radicado.');
        window.location.href = 'radicados.php';
    </script>";
    exit; // Detener ejecución del PHP
}

// Obtener la información del radicado
$radicado = $resulRadicado->fetch_assoc();

// Consulta para obtener los seguimientos del radicado
$stmt = $conexion->prepare("SELECT * FROM seguimiento_radicado WHERE id_radicado = ?");
$stmt->bind_param("i", $radicado['id_radicado']); // Usar el id_radicado obtenido
$stmt->execute();
$resulSeguimiento = $stmt->get_result();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SoftDoc</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="../../assets/css/styles.min.css" />
</head>
<body class="bg-light">
  <div class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="card shadow">
            <div class="card-body">
              <h5 class="card-title fw-semibold mb-4 text-center">FORMULARIO REGISTRO DE CORRESPONDENCIA</h5>
              
              <!-- Mostrar la información del radicado -->
              <div class="mb-3">
                <label class="form-label">Radicado</label>
                <p class="form-control"><?php echo $radicado['radicado']; ?></p>
              </div>
              <div class="mb-3">
                <label class="form-label">Nombre Remitente</label>
                <p class="form-control-plaintext"><?php echo $radicado['nombre_remitente']; ?></p>
              </div>
              <div class="mb-3">
                <label class="form-label">Correo</label>
                <p class="form-control"><?php echo $radicado['correo']; ?></p>
              </div>
              <div class="mb-3">
                <label class="form-label">Fecha de Radicado</label>
                <p class="form-control"><?php echo $radicado['fecha_radicado']; ?></p>
              </div>
              <div class="mb-3">
                <label class="form-label">Asunto</label>
                <p class="form-control"><?php echo $radicado['asunto']; ?></p>
              </div>
              <div class="mb-3">
                <label class="form-label">Documento</label>
                <?php if (!empty($radicado['documento'])): ?>
                  <p class="form-control"><a href="/<?php echo $radicado['documento']; ?>" target="_blank">Ver radicado</a></p>
                <?php else: ?>
                  <p class="form-control"><span class="text-muted">Sin documento</span></p>
                <?php endif; ?>
              </div>
                

              <!-- Mostrar los seguimientos -->
              <h5 class="mt-3">Seguimientos</h5>
              <hr>
              <?php
              if ($resulSeguimiento->num_rows > 0) {
                  while ($seguimiento = $resulSeguimiento->fetch_assoc()) {
                    ?>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <label class="form-label">Detalle</label>
                            <small class="text-muted"><?php echo $seguimiento['fecha_seguimiento']; ?></small>
                        </div>
                        <textarea name="detalle" class="form-control" rows="3" readonly><?php echo $seguimiento['detalle']; ?></textarea>
                    </div>
                    <br>
                    <br>
              <?php
                  }
              } else {
                  echo "<p>No hay seguimientos para este radicado.</p>";
              }
              // Mostrar estado del radicado
              $estadoTexto = ($radicado['activo'] == 0) ? "RADICADO FINALIZADO" : "RADICADO EN SEGUIMIENTO";
              echo "<div class='text-center mt-4'><strong class='text-primary'>$estadoTexto</strong></div>";
              ?>
              <!-- Botón Salir -->
              <div class="text-center mt-4">
                <a href="/index.php" class="btn btn-secondary">Salir</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
