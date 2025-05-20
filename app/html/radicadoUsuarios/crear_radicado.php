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
          <div class="card shadow border-0 rounded-4">
            <div class="card-body p-4">
              <h5 class="card-title fw-semibold mb-4 text-primary">FORMULARIO REGISTRO DE RADICADO</h5>

              <form action="../../config/op_crear_radicado_usuario.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="admin">

                <!-- Datos remitente -->
                <fieldset class="mb-4 border rounded-3 p-3">
                  <legend class="float-none w-auto text-secondary fw-semibold fs-5 px-2">Datos del Remitente</legend>
                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label text-dark fw-bold">Nombre Remitente</label>
                      <input type="text" name="nombre" class="form-control rounded-3" required>
                      <div class="form-text">Ingrese el nombre completo del Remitente.</div>
                    </div>

                    <div class="col-md-6">
                      <label class="form-label text-dark fw-bold">Tipo documento</label>
                      <select class="form-select rounded-3" name="tipo" required>
                        <option value="" disabled selected>Seleccionar...</option>
                        <option>CC</option>
                        <option>TI</option>
                      </select>
                    </div>

                    <div class="col-md-6">
                      <label class="form-label text-dark fw-bold">Número de Documento</label>
                      <input type="number" name="cedula" class="form-control rounded-3" required>
                      <div class="form-text">Ingrese la cédula.</div>
                    </div>

                    <div class="col-md-6">
                      <label class="form-label text-dark fw-bold">Teléfono</label>
                      <input type="text" name="telefono" class="form-control rounded-3" required>
                      <div class="form-text">Ingrese el teléfono.</div>
                    </div>

                    <div class="col-md-6">
                      <label class="form-label text-dark fw-bold">Correo</label>
                      <input type="email" name="correo" class="form-control rounded-3" required>
                      <div class="form-text">Correo Electrónico.</div>
                    </div>
                  </div>
                </fieldset>

                <!-- Ubicación -->
                <fieldset class="mb-4 border rounded-3 p-3">
                  <legend class="float-none w-auto text-secondary fw-semibold fs-5 px-2">Ubicación</legend>
                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label text-dark fw-bold">Ingrese país</label>
                      <select class="form-select rounded-3" id="inputPais" name="pais" required>
                        <option value="">-- Seleccione país --</option>
                        <option value="Colombia">Colombia</option>
                      </select>
                      <div class="form-text">Ingrese país.</div>
                    </div>

                    <div class="col-md-6">
                      <label class="form-label text-dark fw-bold">Ingrese departamento</label>
                      <select class="form-select rounded-3" id="departamento" name="departamento" required>
                        <option value="">-- Seleccione departamento --</option>
                      </select>
                      <div class="form-text">Ingrese departamento.</div>
                    </div>

                    <div class="col-md-6">
                      <label class="form-label text-dark fw-bold">Ingrese municipio</label>
                      <select class="form-select rounded-3" id="municipio" name="municipio" required>
                        <option value="">-- Seleccione un departamento primero --</option>
                      </select>
                      <div class="form-text">Ingrese municipio.</div>
                    </div>

                    <div class="col-md-6">
                      <label class="form-label text-dark fw-bold">Dirección</label>
                      <input type="text" name="direccion" class="form-control rounded-3" required>
                      <div class="form-text">Ingrese dirección de residencia.</div>
                    </div>
                  </div>
                </fieldset>

                <!-- Detalles y Documentación del Radicado -->
                <fieldset class="border rounded-3 p-3 mb-4">
                  <legend class="float-none w-auto px-3 text-secondary fw-semibold fs-5">Documentación del Radicado</legend>
                  <div class="row">
                    <div class="col-5 mb-3">
                      <label class="form-label fw-bold text-dark-emphasis">Asunto</label>
                      <input type="text" name="asunto" class="form-control rounded-3" maxlength="42" required>
                    </div>
                    <div class="col-7 mb-3">
                      <label class="form-label fw-bold text-dark-emphasis">Adjuntar documento</label>
                      <div class="input-group">
                        <input type="file" name="file" class="form-control rounded-start-3" id="fileInput" accept=".pdf, .jpg">
                        <button class="btn btn-danger rounded-end-3" type="button" onclick="eliminarAdjunto()">Eliminar</button>
                      </div>
                      <div class="form-text">Adjunte el documento si es necesario.</div>
                    </div>
                    <div class="mb-3">
                      <label class="form-label fw-bold text-dark-emphasis">Detalle del Radicado</label>
                      <textarea name="detalleRadicado" class="form-control rounded-3" rows="4" required></textarea>
                    </div>
                  </div>
                </fields>
                <button type="submit" class="btn btn-primary w-100 mt-4 rounded-pill">Radicar</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>


<script>
  function eliminarAdjunto() {
    document.getElementById('fileInput').value = '';
  }
</script>
<script src="/app/assets/js/dataColombia.js"></script>