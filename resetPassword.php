<!-- filepath: c:\Users\dinny\Desktop\PrototipoSoftDoc\resetPassword.php -->
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
            <h3 class="text-center">Nueva Contraseña</h3>
            <form action="app/config/updatePassword.php" method="POST">
                <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                <div class="mb-3">
                    <label for="password" class="form-label">Nueva Contraseña</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Actualizar Contraseña</button>
            </form>
        </div>
    </div>
</body>

</html>