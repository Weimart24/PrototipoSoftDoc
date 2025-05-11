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
$id_radicado = $resulRadicado->fetch_assoc();

// Consulta para obtener los seguimientos del radicado
$stmt = $conexion->prepare("SELECT * FROM seguimiento_radicado WHERE id_radicado = ?");
$stmt->bind_param("i", $id_radicado['id_radicado']); // Usar el id_radicado obtenido
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
                <label for="radicado" class="form-label">Radicado</label>
                <input type="text" name="radicado" class="form-control" value="<?php echo $id_radicado['radicado']; ?>" readonly>
              </div>
              <div class="mb-3">
                <label for="nombre_remitente" class="form-label">Nombre Remitente</label>
                <input type="text" name="nombre_remitente" class="form-control" value="<?php echo $id_radicado['nombre_remitente']; ?>" readonly>
              </div>
              <div class="mb-3">
                <label for="correo" class="form-label">Correo</label>
                <input type="email" name="correo" class="form-control" value="<?php echo $id_radicado['correo']; ?>" readonly>
              </div>
              <div class="mb-3">
                <label for="fecha_radicado" class="form-label">Fecha de Radicado</label>
                <input type="text" name="fecha_radicado" class="form-control" value="<?php echo $id_radicado['fecha_radicado']; ?>" readonly>
              </div>
              <div class="mb-3">
                <label for="asunto" class="form-label">Asunto</label>
                <input type="text" name="asunto" class="form-control" value="<?php echo $id_radicado['asunto']; ?>" readonly>
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
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
