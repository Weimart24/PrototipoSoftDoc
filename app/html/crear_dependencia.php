<?php session_start();
if (!isset($_SESSION['name']) && !isset($_SESSION['id'])) {
    header('Location: ../../index.php');
}
?>
<!doctype html>
<html lang="en">

<head>
    <?php include('modulos/head.php') ?>
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <?php include('modulos/sidebar.php') ?>
            <!-- End Sidebar scroll-->
        </aside>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <?php include('modulos/header.php') ?>
            <!--  Header End -->
            <div class="container py-5">
              <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                  <div class="card shadow-sm rounded-4">
                    <div class="card-body">
                      <h5 class="card-title fw-semibold mb-4 text-center">CREAR NUEVA DEPENDENCIA</h5>
                      <form action="../config/op_crear_dependencia.php" method="POST">
                        <div class="mb-3">
                          <label for="cedula" class="form-label">Id Dependencia</label>
                          <input type="text" name="id" class="form-control" id="id" required>
                          <div class="form-text">Ingrese un id de dependencia no repetido.</div>
                        </div>
                        <div class="mb-3">
                          <label for="funcionario" class="form-label">Nombre de la dependencia</label>
                          <input type="text" name="nombre" class="form-control" id="nombre" required>
                          <div class="form-text">Nombre de la dependencia.</div>
                        </div>
                        <div class="mb-3">
                          <label for="telefono" class="form-label">Teléfono de la dependencia</label>
                          <input type="text" name="telefono" class="form-control" id="telefono" required>
                          <div class="form-text">Ingrese el teléfono relacionado a la dependencia.</div>
                        </div>
                        <div class="d-grid">
                          <button type="submit" class="btn btn-primary">Agregar</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>

                <!-- Fin formulario para crear los funcionarios-->
                <div class="py-6 px-6 text-center">
                    <p class="mb-0 fs-4">Diseñado y desarrollado por <a href="https://softDocument.com/" target="_blank" class="pe-1 text-primary text-decoration-underline">SoftDocument.com</a></p>
                </div>
            </div>
        </div>
    </div>
    <?php include('modulos/script.php') ?>
</body>

</html>