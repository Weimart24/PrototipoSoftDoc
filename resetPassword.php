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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: linear-gradient(to bottom right, #e6f4ea, #c1eac5);
            font-family: 'Segoe UI', sans-serif;
        }

        .card {
            border: none;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 8px 20px rgba(0, 128, 0, 0.1);
        }

        .btn-primary {
            background-color: #28a745;
            border: none;
        }

        .btn-primary:hover {
            background-color: #218838;
        }

        .form-control:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }

        .message-box {
            max-width: 450px;
            padding: 30px;
            border-radius: 15px;
            background-color: #ffffff;
            box-shadow: 0 8px 20px rgba(0, 128, 0, 0.1);
            text-align: center;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <?php if ($tokenValido): ?>
        <div class="col-md-5">
            <div class="card">
                <h3 class="text-center text-success mb-3">Nueva Contraseña</h3>
                <form action="app/config/updatePassword.php" method="POST" onsubmit="return validarFormulario()">
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                    <div class="mb-3">
                        <label for="password" class="form-label">Nueva Contraseña</label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control" id="password" required>
                            <button type="button" class="btn btn-outline-success rounded-end-3" onclick="togglePassword('password', this)">Mostrar</button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="confirmar" class="form-label">Confirmar Contraseña</label>
                        <div class="input-group">
                            <input type="password" name="confirmar" class="form-control" id="confirmar" required>
                            <button type="button" class="btn btn-outline-success rounded-end-3" onclick="togglePassword('confirmar', this)">Mostrar</button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Actualizar Contraseña</button>
                </form>
            </div>
            <p class="text-center mt-4 text-muted">Sistema de Gestión de Radicados</p>
        </div>
    <?php else: ?>
        <div class="message-box">
            <h3 class="text-danger">Enlace no válido</h3>
            <p>Este enlace para restablecer tu contraseña ha expirado o ya fue utilizado.</p>
            <a href="../../login.php" class="btn btn-secondary mt-3">Solicitar uno nuevo</a>
        </div>
    <?php endif; ?>
</div>

<script>
    function togglePassword(id, btn) {
        const input = document.getElementById(id);
        if (input.type === 'password') {
            input.type = 'text';
            btn.textContent = 'Ocultar';
        } else {
            input.type = 'password';
            btn.textContent = 'Mostrar';
        }
    }

    function validarFormulario() {
        const pass = document.getElementById('password').value;
        const confirmar = document.getElementById('confirmar').value;
        const regex = /^(?=.*[A-Z])(?=.*\d).{8,}$/;

        if (!regex.test(pass)) {
            Swal.fire({
                icon: 'warning',
                title: 'Contraseña insegura',
                text: 'Debe tener al menos 8 caracteres, una mayúscula y un número.'
            });
            return false;
        }

        if (pass !== confirmar) {
            Swal.fire({
                icon: 'warning',
                title: 'No coinciden',
                text: 'Las contraseñas no coinciden.'
            });
            return false;
        }

        return true;
    }

    // Limpiar si se vuelve con el botón atrás
    window.addEventListener("pageshow", function (event) {
        if (event.persisted || performance.navigation.type === 2) {
            const form = document.querySelector("form");
            if (form) form.reset();
        }
    });
</script>
</body>
</html>
