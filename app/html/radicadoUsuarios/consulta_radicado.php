<?php
// Funciones para ocultar información sensible
function ocultarNombre($nombreCompleto) {
    $palabras = explode(' ', $nombreCompleto);
    $resultado = [];

    foreach ($palabras as $palabra) {
        $visibles = mb_substr($palabra, 0, 2, 'UTF-8');
        $ocultos = str_repeat('*', max(2, mb_strlen($palabra, 'UTF-8') - 2));
        $resultado[] = $visibles . $ocultos;
    }

    return implode(' ', $resultado);
}

function ocultarCorreo($correo) {
    $partes = explode('@', $correo);
    $usuario = $partes[0];
    $dominio = $partes[1];

    $longitud = mb_strlen($usuario, 'UTF-8');

    if ($longitud <= 2) {
        $oculto = str_repeat('*', $longitud);
    } else {
        $visibles = min(2, $longitud - 1);
        $inicio = mb_substr($usuario, 0, $visibles, 'UTF-8');
        $ocultos = str_repeat('*', $longitud - $visibles);
        $oculto = $inicio . $ocultos;
    }

    return $oculto . '@' . $dominio;
}



// Verificar si se ha enviado el formulario con el radicado
if (!isset($_POST['radicado'])) {
    header("Location: ../../../index.php");
    exit();
}

// Incluir la conexión a la base de datos
include '../../config/conexion.php';
include '../../config/alerta.php';

$radicado = $_POST['radicado'];
$cedula = $_POST['cedula'];

// Consulta para obtener los datos del radicado con la cédula
$stmt = $conexion->prepare("SELECT * FROM radicacion WHERE radicado = ? AND cedula_remitente = ?");
$stmt->bind_param("ss", $radicado, $cedula); // ambos como strings
$stmt->execute();
$resulRadicado = $stmt->get_result();

// Verificar si se encontró el radicado con la cédula correspondiente
if ($resulRadicado->num_rows === 0) {
    mostrarAlerta(
        'error',
        'No encontrado',
        'No existe un radicado asociado con esa cédula. Verifique los datos.',
        '/app/html/radicadoUsuarios/radicados.php'
    );
    exit;
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
          <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body px-5 py-4">
              <h3 class="text-center mb-4 text-primary fw-bold">
                Detalles del Radicado
              </h3>

              <div class="row g-3">
                <!-- Campo -->
                <?php
                  $campos = [
                    'Radicado' => $radicado['radicado'],
                    'Nombre del Remitente' => ocultarNombre($radicado['nombre_remitente']),
                    'Correo Electrónico' => ocultarCorreo($radicado['correo']),
                    'Fecha de Radicación' => $radicado['fecha_radicado'],
                    'Asunto' => $radicado['asunto'],
                  ];
                  foreach ($campos as $label => $valor):
                ?>
                <div class="col-md-6">
                  <label class="form-label text-secondary fw-semibold fs-6"><?php echo $label; ?></label>
                  <div class="bg-white border rounded-3 p-2 px-3 shadow-sm fs-7">
                    <?php echo $valor; ?>
                  </div>
                </div>
                <?php endforeach; ?>

                <!-- Documento -->
                <div class="col-md-6">
                  <label class="form-label text-secondary fw-semibold fs-6">Documento</label>
                  <div class="bg-white border rounded-3 p-2 px-3 shadow-sm fs-7">
                    <?php if (!empty($radicado['documento'])): ?>
                      <a href="/<?php echo $radicado['documento']; ?>" target="_blank" class="text-decoration-none text-primary fw-semibold">
                        📄 Ver documento adjunto
                      </a>
                    <?php else: ?>
                      <span class="text-muted">Sin documento adjunto</span>
                    <?php endif; ?>
                  </div>
                </div>
              </div>

              <!-- Seguimientos -->
              <div class="mt-5">
                <h5 class="text-primary fw-bold">Seguimientos</h5>
                <hr>
                <?php if ($resulSeguimiento->num_rows > 0): ?>
                  <?php while ($seguimiento = $resulSeguimiento->fetch_assoc()): ?>
                    <div class="mb-4">
                      <div class="d-flex justify-content-between align-items-center mb-1">
                        <strong class="text-secondary">Detalle</strong>
                        <small class="text-muted"><?php echo $seguimiento['fecha_seguimiento']; ?></small>
                      </div>
                      <div class="bg-light border rounded-3 p-3 shadow-sm">
                        <?php echo nl2br(htmlspecialchars($seguimiento['detalle'])); ?>
                      </div>
                    </div>
                  <?php endwhile; ?>
                <?php else: ?>
                  <p class="text-muted fst-italic">No hay seguimientos para este radicado.</p>
                <?php endif; ?>
              </div>

              <!-- Estado -->
              <div class="text-center mt-4">
                <span class="badge <?php echo ($radicado['activo'] == 0) ? 'bg-danger' : 'bg-success'; ?> fs-6 px-4 py-2 rounded-pill">
                  <?php echo ($radicado['activo'] == 0) ? "RADICADO FINALIZADO" : "RADICADO EN SEGUIMIENTO"; ?>
                </span>
              </div>

              <!-- Botón salir -->
              <div class="text-center mt-4">
                <a href="/index.php" class="btn btn-outline-primary px-4 py-2 rounded-pill">Salir</a>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>


</html>
