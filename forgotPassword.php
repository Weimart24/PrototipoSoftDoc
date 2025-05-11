<?php
// Desactivar caché del navegador
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Restablecer Contraseña</title>
    <link rel="stylesheet" href="app/assets/css/styles.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card p-4">
            <h3 class="text-center">Restablecer Contraseña</h3>
            <form action="app/config/sendResetLink.php" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control" id="email" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Enviar Enlace</button>
            </form>
        </div>
    </div>

    <script>
        // Mostrar alertas
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
                });
            }
        });

        // Limpiar formulario si se vuelve con la flecha "atrás"
        window.addEventListener("pageshow", function (event) {
            if (event.persisted || performance.navigation.type === 2) {
                document.querySelector("form").reset();
            }
        });
    </script>
</body>
</html>
