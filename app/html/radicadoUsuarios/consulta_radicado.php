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
        <div class="col-lg-10">
          <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body px-5 py-4">
              <h3 class="text-center mb-4 text-primary fw-bold">
                DETALLES DEL RADICADO
              </h3>

              <div class="row mb-4">
                <div class="col-md-6 mb-3">
                  <label class="fw-bold text-dark">Radicado</label>
                  <div class="bg-white border rounded p-2 shadow-sm">
                    <?php echo $radicado['radicado']; ?>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="fw-bold text-dark">Nombre del Remitente</label>
                  <div class="bg-white border rounded p-2 shadow-sm">
                    <?php echo $radicado['nombre_remitente']; ?>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="fw-bold text-dark">Correo Electrónico</label>
                  <div class="bg-white border rounded p-2 shadow-sm">
                    <?php echo $radicado['correo']; ?>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="fw-bold text-dark">Fecha de Radicación</label>
                  <div class="bg-white border rounded p-2 shadow-sm">
                    <?php echo $radicado['fecha_radicado']; ?>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="fw-bold text-dark">Asunto</label>
                  <div class="bg-white border rounded p-2 shadow-sm">
                    <?php echo $radicado['asunto']; ?>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="fw-bold text-dark">Documento</label>
                  <div class="bg-white border rounded p-2 shadow-sm">
                    <?php if (!empty($radicado['documento'])): ?>
                      <a href="/<?php echo $radicado['documento']; ?>" target="_blank">📄 Ver radicado</a>
                    <?php else: ?>
                      <span class="fw-bold text-dark">Sin documento adjunto</span>
                    <?php endif; ?>
                  </div>
                </div>
              </div>

              <h5 class="text-primary fw-semibold">Seguimientos</h5>
              <hr>
              <?php if ($resulSeguimiento->num_rows > 0): ?>
                <?php while ($seguimiento = $resulSeguimiento->fetch_assoc()): ?>
                  <div class="mb-4">
                    <div class="d-flex justify-content-between mb-1">
                      <strong class="text-dark">Detalle</strong>
                      <small class="text-muted"><?php echo $seguimiento['fecha_seguimiento']; ?></small>
                    </div>
                    <div class="bg-light border rounded p-3 shadow-sm">
                      <?php echo nl2br(htmlspecialchars($seguimiento['detalle'])); ?>
                    </div>
                  </div>
                <?php endwhile; ?>
              <?php else: ?>
                <p class="text-muted">No hay seguimientos para este radicado.</p>
              <?php endif; ?>

              <div class="text-center mt-4">
                <span class="badge <?php echo ($radicado['activo'] == 0) ? 'bg-danger' : 'bg-success'; ?> fs-6 px-4 py-2">
                  <?php echo ($radicado['activo'] == 0) ? "RADICADO FINALIZADO" : "RADICADO EN SEGUIMIENTO"; ?>
                </span>
              </div>

              <div class="text-center mt-4">
                <a href="/index.php" class="btn btn-outline-primary px-4 rounded-pill">Salir</a>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
