<?php
session_start();
if (!isset($_SESSION['name']) && !isset($_SESSION['id'])) {
    header('Location: ../../index.php');
}
?>
<!doctype html>
<html lang="es">

<head>
  <?php include('modulos/head.php') ?>
</head>

<body>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6"
       data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <aside class="left-sidebar">
      <?php include('modulos/sidebar.php') ?>
    </aside>
    <div class="body-wrapper">
      <?php include('modulos/header.php') ?>
      <div class="container py-5">
        <div class="row justify-content-center">
          <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm rounded-4">
              <div class="card-body">
                <h5 class="card-title fw-semibold mb-4 text-center">CREAR NUEVO ROL</h5>
                <form action="../config/op_crear_rol.php" method="POST" id="formRol">
                  <div class="mb-3">
                    <label for="nombre_rol" class="form-label">Nombre del Rol</label>
                    <input type="text" name="nombre_rol" class="form-control" id="nombre_rol" required>
                  </div>
                  <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" id="descripcion" rows="3" required></textarea>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Seleccionar Permisos <span class="text-danger">*</span></label>
                    <div class="border rounded-3 p-3" style="max-height: 200px; overflow-y: auto;">
                      <?php
                      include('../config/conexion.php');
                      $consulta = $conexion->query("SELECT * FROM permisos ORDER BY nombre_permiso ASC");
                      while ($permiso = $consulta->fetch_assoc()) {
                        echo '<div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permisos[]" value="' . $permiso['id_permiso'] . '" id="permiso_' . $permiso['id_permiso'] . '">
                                <label class="form-check-label" for="permiso_' . $permiso['id_permiso'] . '">
                                  ' . $permiso['nombre_permiso'] . ' <small class="text-muted">(' . $permiso['descripcion'] . ')</small>
                                </label>
                              </div>';
                      }
                      ?>
                    </div>
                    <div id="permisoError" class="text-danger mt-2 d-none">Debe seleccionar al menos un permiso.</div>
                  </div>
                  <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Agregar Rol</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="py-6 px-6 text-center">
        <p class="mb-0 fs-4">Diseñado y desarrollado por 
          <a href="https://softDocument.com/" target="_blank" class="pe-1 text-primary text-decoration-underline">SoftDocument.com</a>
        </p>
      </div>
    </div>
  </div>
  <?php include('modulos/script.php') ?>
  <script>
    document.getElementById('formRol').addEventListener('submit', function (e) {
      const checkboxes = document.querySelectorAll('input[name="permisos[]"]:checked');
      const error = document.getElementById('permisoError');
      if (checkboxes.length === 0) {
        e.preventDefault();
        error.classList.remove('d-none');
        error.scrollIntoView({ behavior: 'smooth' });
      } else {
        error.classList.add('d-none');
      }
    });
  </script>
</body>

</html>
