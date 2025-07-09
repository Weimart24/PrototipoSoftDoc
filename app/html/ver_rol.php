<?php
session_start();
if (!isset($_SESSION['validate'])) {
  header('Location: ../../index.php');
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
  exit('Parámetro "id" no proporcionado.');
}

include '../config/conexion.php';

$id_rol = $_GET['id'];

// Traer datos del rol
$query_rol = "SELECT * FROM roles WHERE id_rol = ?";
$stmt_rol = $conexion->prepare($query_rol);
$stmt_rol->bind_param("i", $id_rol);
$stmt_rol->execute();
$rol_resultado = $stmt_rol->get_result();
$rol_info = $rol_resultado->fetch_assoc();

// Traer permisos asociados
$query_permisos = "
  SELECT p.id_permiso, p.nombre_permiso, p.descripcion
  FROM permisos p
  INNER JOIN rol_permisos rp ON rp.id_permiso = p.id_permiso
  WHERE rp.id_rol = ?
";
$stmt_perm = $conexion->prepare($query_permisos);
$stmt_perm->bind_param("i", $id_rol);
$stmt_perm->execute();
$permisos_resultado = $stmt_perm->get_result();
?>

<!doctype html>
<html lang="es">
<head>
  <?php include 'modulos/head.php' ?>
</head>
<body>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6"
       data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <aside class="left-sidebar">
      <?php include 'modulos/sidebar.php' ?>
    </aside>
    <div class="body-wrapper">
      <?php include 'modulos/header.php' ?>
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-lg-6 col-md-10">
            <div class="card mb-4 shadow-sm rounded-4">
              <div class="card-body p-4">
                <h3 class="fw-bold text-primary mb-4 text-center">Detalle del Rol -<?php echo $rol_info['nombre_rol']; ?>-</h3>

                <div class="d-flex justify-content-center gap-3 mb-4">
                  <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEditarRol">Editar Rol</button>
                  <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalEditarPermisos">Editar Permisos</button>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Descripción</label>
                    <p class="mb-0"><?php echo $rol_info['descripcion']; ?></p>
                  </div>
                </div>

                <div class="mt-4">
                  <h5 class="fw-bold text-primary mb-3">Permisos Asociados</h5>
                  <?php if ($permisos_resultado->num_rows > 0): ?>
                    <div class="row">
                      <?php while($permiso = $permisos_resultado->fetch_assoc()): ?>
                        <div class="col-md-6 mb-3">
                          <div class="border-primary border-3 shadow-sm h-100">
                            <div class="card-body">
                              <h6 class="fw-bold"><?php echo $permiso['nombre_permiso']; ?></h6>
                              <p class="text-muted mb-0"><?php echo $permiso['descripcion']; ?></p>
                            </div>
                          </div>
                        </div>
                      <?php endwhile; ?>
                    </div>
                  <?php else: ?>
                    <p class="text-muted fst-italic">Este rol no tiene permisos asignados.</p>
                  <?php endif; ?>
                </div>
              </div>
            </div>
            <div class="text-center">
              <a href="rol.php" class="btn btn-secondary mt-4">Volver</a>
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
  </div>

  <!-- Modal Editar Rol -->
  <div class="modal fade" id="modalEditarRol" tabindex="-1" aria-labelledby="modalEditarRolLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form action="../config/op_actualizar_rol.php" method="POST" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEditarRolLabel">Editar Rol</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_rol" value="<?php echo $rol_info['id_rol']; ?>">
          <div class="mb-3">
            <label class="form-label">Nombre del Rol</label>
            <input type="text" name="nombre_rol" class="form-control" value="<?php echo $rol_info['nombre_rol']; ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" rows="3"><?php echo $rol_info['descripcion']; ?></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal Editar Permisos -->
  <div class="modal fade" id="modalEditarPermisos" tabindex="-1" aria-labelledby="modalEditarPermisosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <form action="../config/op_actualizar_permisos_rol.php" method="POST" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEditarPermisosLabel">Editar Permisos del Rol</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_rol" value="<?php echo $rol_info['id_rol']; ?>">
          <div class="row">
            <?php
              $all_permisos = $conexion->query("SELECT * FROM permisos");
              while($perm = $all_permisos->fetch_assoc()):
                $checked = $conexion->query("SELECT * FROM rol_permisos WHERE id_rol = $id_rol AND id_permiso = {$perm['id_permiso']}")->num_rows > 0 ? 'checked' : '';
            ?>
              <div class="col-md-6 mb-2">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="permisos[]" value="<?php echo $perm['id_permiso']; ?>" <?php echo $checked; ?>>
                  <label class="form-check-label">
                    <strong><?php echo $perm['nombre_permiso']; ?></strong>: <?php echo $perm['descripcion']; ?>
                  </label>
                </div>
              </div>
            <?php endwhile; ?>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
      </form>
    </div>
  </div>

  <?php include 'modulos/script.php' ?>
</body>
</html>

<?php $conexion->close(); ?>
