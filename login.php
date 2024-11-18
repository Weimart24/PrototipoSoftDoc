<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SoftDoc</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="app/assets/css/styles.min.css" />
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="index.php" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="app/assets/images/logos/Logo-SOFTDOC-vud.png" width="250" alt="Logo">
                                </a>
                                <p class="text-center">INGRESO FUNCIONARIOS</p>
                                <form action="app/config/validateLogin.php" method="POST">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Correo</label>
                                        <input type="email" name="correo" class="form-control" id="exampleInputEmail1">
                                    </div>
                                    <div class="mb-4">
                                        <label for="exampleInputPassword1" class="form-label">Contraseña</label>
                                        <input type="password" name="contrasena" class="form-control" id="exampleInputPassword1">
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        
                                        <a class="text-primary fw-bold" href="./index.html">¿Olvidaste la contraseña?</a>
                                    </div>
                                    <button type="submit" class="btn btn-outline-success m-1 w-100 py-8 fs-4 mb-4 rounded-2">Iniciar sesión</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="app/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="app/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>