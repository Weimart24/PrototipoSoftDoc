<?php
// Desactivar caché del navegador
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include("app/config/conexion.php");

$token = $_GET['token'] ?? '';
$tokenValido = false;

if (!empty($token)) {
    $stmt = $conexion->prepare("SELECT id_funcionario FROM funcionario WHERE reset_token = ? AND reset_expiration > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $tokenValido = true;
    }

    $stmt->close();
}
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Restablecer Contraseña</title>
    <link rel="stylesheet" href="app/assets/css/styles.min.css" />
    <style>
        .message-box {
            max-width: 400px;
            margin: 100px auto;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 30px;
            background-color: #f9f9f9;
        }
        .message-box h3 {
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <?php if ($tokenValido): ?>
            <div class="card p-4">
                <h3 class="text-center">Nueva Contraseña</h3>
                <form action="app/config/updatePassword.php" method="POST">
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                    <div class="mb-3">
                        <label for="password" class="form-label">Nueva Contraseña</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Actualizar Contraseña</button>
                </form>
            </div>
        <?php else: ?>
            <div class="message-box">
                <h3>Enlace no válido</h3>
                <p>Este enlace para restablecer tu contraseña ha expirado o ya fue utilizado.</p>
                <a href="../../login.php" class="btn btn-secondary mt-3">Solicitar uno nuevo</a>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Limpiar formulario si se vuelve con la flecha "atrás"
        window.addEventListener("pageshow", function (event) {
            if (event.persisted || performance.navigation.type === 2) {
                const form = document.querySelector("form");
                if (form) form.reset();
            }
        });
    </script>
</body>

</html>
