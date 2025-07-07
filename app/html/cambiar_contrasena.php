<?php
session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['name'])) {
    header("Location: ../../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cambiar Contraseña</title>
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

        a {
            color: #28a745;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body class="d-flex align-items-center" style="min-height: 100vh;">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4">
                <div class="card-body">
                    <h4 class="card-title text-center text-success mb-3">Hola, <?php echo htmlspecialchars($_SESSION['name']); ?></h4>
                    <p class="text-center text-muted">Por seguridad, debe cambiar su contraseña.</p>
                    <form action="../config/op_cambio_contrasena.php" method="POST" onsubmit="return validarContrasenas()">
                        <div class="mb-3">
                            <label for="nueva" class="form-label">Nueva contraseña</label>
                            <div class="input-group">
                                <input type="password" name="nueva_contrasena" id="nueva" class="form-control rounded-start-3" required>
                                <button type="button" id="toggleNueva" class="btn btn-outline-success rounded-end-3" onclick="togglePassword('nueva', this)">Mostrar</button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="confirmar" class="form-label">Confirmar contraseña</label>
                            <div class="input-group">
                                <input type="password" name="confirmar_contrasena" id="confirmar" class="form-control rounded-start-3" required>
                                <button type="button" id="toggleConfirmar" class="btn btn-outline-success rounded-end-3" onclick="togglePassword('confirmar', this)">Mostrar</button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Cambiar contraseña</button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="../config/close.php">Volver al inicio de sesión</a>
                    </div>
                </div>
            </div>
            <p class="text-center mt-4 text-muted">Sistema de Gestión de Radicados</p>
        </div>
    </div>
</div>

<script>
    function togglePassword(idCampo, boton) {
        const input = document.getElementById(idCampo);
        if (input.type === "password") {
            input.type = "text";
            boton.textContent = "Ocultar";
        } else {
            input.type = "password";
            boton.textContent = "Mostrar";
        }
    }

    function validarContrasenas() {
        const nueva = document.getElementById('nueva').value;
        const confirmar = document.getElementById('confirmar').value;

        const regexMayuscula = /[A-Z]/;
        const regexNumero = /\d/;

        if (nueva.length < 8 || !regexMayuscula.test(nueva) || !regexNumero.test(nueva)) {
            Swal.fire({
                icon: 'warning',
                title: 'Contraseña débil',
                html: 'Debe tener al menos <b>8 caracteres</b>, <b>una mayúscula</b> y <b>un número</b>.'
            });
            return false;
        }

        if (nueva !== confirmar) {
            Swal.fire({
                icon: 'warning',
                title: 'No coinciden',
                text: 'Las contraseñas no coinciden.'
            });
            return false;
        }

        return true;
    }
</script>
</body>
</html>
