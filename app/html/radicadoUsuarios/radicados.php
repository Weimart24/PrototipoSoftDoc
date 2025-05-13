<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inicio - SOFTDOC</title>
  <link rel="shortcut icon" type="image/png" href="../../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="../../assets/css/styles.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    .brand-logo {
      max-height: 200px;
    }
    .softdoc-subtitle {
      font-size: 1.1rem;
      color: #6c757d;
      max-width: 800px;
      margin: auto;
    }
  </style>
</head>
<body>
  <!-- Modal -->
  <div class="modal fade" id="consultaModal" tabindex="-1" aria-labelledby="consultaModalLabel" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form id="formConsulta" action="../../html/radicadoUsuarios/consulta_radicado.php" method="POST">
          <div class="modal-header">
            <h5 class="modal-title fw-bold">Consulta de Radicado</h5>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="codigo" class="form-label">Código de radicado</label>
              <input type="text" class="form-control" id="radicado" name="radicado" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary w-100">Aceptar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="page-wrapper d-flex justify-content-center align-items-center min-vh-100 bg-light" id="main-wrapper">
    <div class="container text-center">
      <img src="../../assets/images/logos/logoSoftDoc.svg" alt="Logo SoftDoc" class="brand-logo mb-4">
      <p class="softdoc-subtitle mb-5 px-3">
        Bienvenido al sistema de radicación SOFTDOC. Desde aquí puede registrar nueva correspondencia o consultar el estado de radicados existentes.
      </p>

      <div class="row justify-content-center">
        <div class="col-md-4 mb-3">
          <div class="card shadow text-center">
            <div class="card-body">
              <h5 class="fw-bold mb-2">Crear nuevo radicado</h5>
              <p>Registre una nueva correspondencia en el sistema.</p>
              <a href="crear_radicado.php" class="btn btn-primary w-100">Ir al formulario</a>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <div class="card shadow text-center">
            <div class="card-body">
              <h5 class="fw-bold mb-2">Consultar radicado</h5>
              <p>Verifique el estado o respuesta de un radicado.</p>
              <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#consultaModal">Consultar radicado</button>
            </div>
          </div>
        </div>
      </div>
      <div class="row justify-content-center mt-4">
        <div class="col-md-4">
          <a href="/index.php" class="btn btn-outline-secondary w-100">Volver al inicio</a>
        </div>
      </div>

      <footer class="mt-5">
        <p class="mb-0 text-muted">Diseñado y desarrollado por 
          <a href="https://softDocument.com/" target="_blank" class="text-primary text-decoration-underline">SoftDocument.com</a>
        </p>
      </footer>
    </div>
  </div>

  <!-- Script de Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<!--  Script con limpieza de la URL -->
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
