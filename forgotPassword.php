<!-- filepath: c:\Users\dinny\Desktop\PrototipoSoftDoc\forgotPassword.php -->
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Restablecer Contraseña</title>
    <link rel="stylesheet" href="app/assets/css/styles.min.css" />
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
</body>

</html>