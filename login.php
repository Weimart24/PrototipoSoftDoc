<?php
// Desactivar caché del navegador
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SoftDoc - Ingreso Funcionarios</title>
  <link rel="shortcut icon" href="../assets/images/logos/favicon.png" type="image/png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      background: linear-gradient(-45deg, #e6f4ea, #c1eac5, #d1fae5, #b2f2bb);
      background-size: 400% 400%;
      animation: moverFondo 15s ease infinite;
      font-family: 'Segoe UI', sans-serif;
    }

    @keyframes moverFondo {
      0% {
        background-position: 0% 50%;
      }

      50% {
        background-position: 100% 50%;
      }

      100% {
        background-position: 0% 50%;
      }
    }

    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 6px 25px rgba(0, 128, 0, 0.1);
      padding: 2rem;
      transition: 0.3s ease-in-out;
    }

    .card:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 30px rgba(0, 128, 0, 0.15);
    }

    .form-control:focus {
      border-color: #198754;
      box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
    }

    .btn-outline-success {
      transition: background-color 0.3s ease;
    }

    .btn-outline-success:hover {
      background-color: #198754;
      color: white;
    }

    .logo-img img {
      max-width: 80%;
    }

    .g-recaptcha {
      margin-bottom: 1rem;
    }

    .text-primary {
      color: #198754 !important;
    }

    .text-center p {
      color: #198754;
    }
  </style>
</head>

<body>
  <div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="col-md-5 col-lg-4">
      <div class="card">
        <div class="text-center">
          <a href="index.php" class="logo-img d-block py-2">
            <img src="app/assets/images/logos/Logo-SOFTDOC-vud.png" alt="Logo">
          </a>
          <p class="fw-semibold mb-4">INGRESO FUNCIONARIOS</p>
        </div>
        <form action="app/config/validateLogin.php" method="POST">
          <div class="mb-3">
            <label for="correo" class="form-label">Correo</label>
            <input type="email" name="correo" class="form-control" id="correo" required>
          </div>
          <div class="mb-3">
            <label for="contrasena" class="form-label">Contraseña</label>
            <input type="password" name="contrasena" class="form-control" id="contrasena" required>
          </div>
          <div class="text-center mb-3">
            <div class="d-inline-block">
                <div class="g-recaptcha" data-sitekey="6LdDNDMrAAAAAPdajrbgZ3e8bjjn1bKnye3DUACy"></div>
            </div>
            <a class="text-primary fw-bold" href="#" data-bs-toggle="modal" data-bs-target="#modalRecuperar">
                ¿Olvidaste la contraseña?
            </a>

          </div>

          <button type="submit" class="btn btn-outline-success w-100 py-2 fs-5 rounded-3">Iniciar sesión</button>
        </form>
      </div>
    </div>
  </div>
  <!-- Modal -->
<div class="modal fade" id="modalRecuperar" tabindex="-1" aria-labelledby="modalRestablecerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-black rounded-4 shadow">
      
      <div class="modal-header" style="background-color: #81C784; color: white; border-top-left-radius: .75rem; border-top-right-radius: .75rem;">
        <h5 class="modal-title" id="modalRestablecerLabel">Restablecer Contraseña</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <form action="app/config/sendResetLink.php" method="POST">
        <div class="modal-body">
          <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="usuario@ejemplo.com" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn w-100 text-white" style="background-color: #81C784;">Enviar Enlace</button>
        </div>
      </form>
      
    </div>
  </div>
</div>




  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
          confirmButtonColor: '#198754'
        }).then(() => {
          const newUrl = window.location.origin + window.location.pathname;
          window.history.replaceState({}, document.title, newUrl);
        });
      }
    });
  </script>
</body>

</html>
