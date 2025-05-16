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
              <form action="../../config/op_crear_radicado_usuario.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="admin">
                <div class="mb-3">
                  <label class="form-label">Nombre Remitente</label>
                  <input type="text" name="nombre" class="form-control" required>
                  <div class="form-text">Ingrese el nombre completo del Remitente.</div>
                </div>
                <div class="mb-3">
                  <label class="form-label">Tipo documento</label>
                  <select class="form-select" name="tipo" required>
                    <option value="" disabled selected>Seleccionar...</option>
                    <option>CC</option>
                    <option>TI</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label class="form-label">Número de Documento</label>
                  <input type="number" name="cedula" class="form-control" required>
                  <div class="form-text">Ingrese la cédula.</div>
                </div>
                <div class="mb-3">
                  <label class="form-label">Teléfono</label>
                  <input type="text" name="telefono" class="form-control" required>
                  <div class="form-text">Ingrese el teléfono.</div>
                </div>
                <div class="mb-3">
                  <label class="form-label">Correo</label>
                  <input type="email" name="correo" class="form-control" required>
                  <div class="form-text">Correo Electrónico.</div>
                </div>
                <div class="mb-3">
                  <label class="form-label">Ingrese país</label>
                  <select class="form-select" id="inputPais" name="pais" required>
                      <option value="">-- Seleccione país --</option>
                      <option value="Colombia">Colombia</option>
                  </select>
                  <div class="form-text">Ingrese país.</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ingrese departamento</label>
                    <select class="form-select" id="departamento" name="departamento" required>
                        <option value="">-- Seleccione departamento --</option>
                    </select>
                    <div class="form-text">Ingrese departamento.</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ingrese municipio</label>
                    <select class="form-select" id="municipio" name="municipio" required>
                        <option value="">-- Seleccione un departamento primero --</option>
                    </select>
                    <div class="form-text">Ingrese municipio.</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Dirección</label>
                    <input type="text" name="direccion" class="form-control" required>
                    <div class="form-text">Ingrese dirección de residencia..</div>
                </div>
                <div class="mb-3">
                  <label class="form-label">Asunto</label>
                  <input type="text" name="asunto" class="form-control" required>
                  <div class="form-text">Ingrese el asunto del radicado.</div>
                </div>
                <div class="mb-3">
                  <label class="form-label">Detalle del Radicado</label>
                  <textarea name="detalleRadicado" class="form-control" rows="4" required></textarea>
                  <div class="form-text">Ingrese el detalle del radicado.</div>
                </div>
                <div class="mb-3">
                  <label class="form-label">Adjuntar documento</label>
                  <div class="input-group">
                    <input type="file" name="file" class="form-control">
                    <button class="btn btn-danger" type="button" onclick='eliminarAdjunto()'>Eliminar adjunto</button>
                  </div>
                  <div class="form-text">Adjunte Archivo si es necesario.</div>
                </div>
                <button type="submit" class="btn btn-primary w-100 mt-3">Radicar</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
<script src="/app/assets/js/dataColombia.js"></script>