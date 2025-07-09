<?php
session_start();
if (!isset($_SESSION['validate'])) {
  header('Location: ../../index.php');
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    exit('Parámetro "id" no proporcionado.');
}
$id = $_GET['id'];

include '../config/conexion.php';
include_once '../config/funciones.php';

// Consulta para seleccionar el funcionario
$query = "SELECT * FROM funcionario WHERE id_funcionario = '$id'";
$resultado = $conexion->query($query);
$fila = $resultado->fetch_assoc();
?>

<!doctype html>
<html lang="en">

<head>
  <?php include 'modulos/head.php' ?>
</head>

<body>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <aside class="left-sidebar">
      <?php include 'modulos/sidebar.php' ?>
    </aside>
    <div class="body-wrapper">
      <?php include 'modulos/header.php' ?>
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-lg-8 col-md-10">
          <div class="card mb-4 shadow-sm rounded-4">
            <div class="card-body p-4">
              <h3 class="fw-bold text-primary mb-4"><?php echo $fila['nombre_funcionario']; ?></h3>
              <div class="row">
                <div class="col-md-4 mb-3">
                  <label class="form-label fw-semibold">Cédula remitente</label>
                  <p class="mb-0"><?php echo $fila['tipo_documento'] . " " . $fila['cedula']; ?></p>
                </div>
                <div class="col-md-4 mb-3">
                  <label class="form-label fw-semibold">Teléfono</label>
                  <p class="mb-0"><?php echo $fila['telefono']; ?></p>
                </div>
                <div class="col-md-4 mb-3">
                  <label class="form-label fw-semibold">Dirección</label>
                  <p class="mb-0"><?php echo $fila['direccion']; ?></p>
                </div>
                <div class="col-md-4 mb-3">
                  <label class="form-label fw-semibold">Correo electrónico</label>
                  <p class="mb-0"><?php echo $fila['correo']; ?></p>
                </div>
                <div class="col-md-4 mb-3">
                  <label class="form-label fw-semibold">Dependencia</label>
                  <p class="mb-0"><?php echo obtenerDependenciaPorCodigo($fila['id_dependencia']); ?></p>
                </div>
                <div class="col-md-4 mb-3">
                  <label class="form-label fw-semibold">Rol</label>
                  <p class="mb-0"><?php echo obtenerRol($fila['id_funcionario']); ?></p>
                </div>
              </div>
              <div class="d-flex gap-2 mt-4">
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEditar">
                  Editar Funcionario
                </button>
                <?php if ($fila['activo'] == 1): ?>
                  <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalRestablecer">
                    Restablecer Contraseña
                  </button>
                  <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalEliminar">
                    Desactivar Funcionario
                  </button>
                <?php else: ?>
                  <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalActivar">
                    Activar Funcionario
                  </button>
                <?php endif; ?>
              </div>
              </div>
            </div>
            <div class="text-center mt-4">
              <a href="funcionario.php" class="btn btn-secondary">
              <i class="bi bi-arrow-left-circle me-1"></i> Volver
              </a>
            </div>
          </div>
        </div>
        <div class="py-6 px-6 text-center">
          <p class="mb-0 fs-4">Diseñado y desarrollado por <a href="https://softDocument.com/" target="_blank" class="pe-1 text-primary text-decoration-underline">SoftDocument.com</a></p>
        </div>
      </div>
    </div>
  </div>
  <?php include 'modulos/script.php' ?>
</body>

<!-- Modal -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"> <!-- Aumenté tamaño a modal-lg -->
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Actualizar funcionario</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="../config/op_actualizar_funcionario.php" method="POST">
        <input type="hidden" name="id_funcionario" value="<?php echo $fila['id_funcionario'] ?>">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Tipo documento</label>
              <select class="form-select" name="tipo">
                <option selected><?php echo $fila['tipo_documento'] ?></option>
                <option>CC</option>
                <option>TI</option>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Cédula</label>
              <input type="text" name="cedula" class="form-control" value="<?php echo $fila['cedula'] ?>" required>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Nombre funcionario</label>
              <input type="text" name="nombre" class="form-control" value="<?php echo $fila['nombre_funcionario'] ?>" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Teléfono</label>
              <input type="text" name="telefono" class="form-control" value="<?php echo $fila['telefono'] ?>" required>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Dirección</label>
              <input type="text" name="direccion" class="form-control" value="<?php echo $fila['direccion'] ?>" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Correo</label>
              <input type="email" name="correo" class="form-control" value="<?php echo $fila['correo'] ?>" required>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Dependencia</label>
              <select class="form-select" id="dependencia" name="dependencia">
                <option value="<?php echo $fila['id_dependencia'] ?>"><?php echo obtenerDependenciaPorCodigo($fila["id_dependencia"]) ?></option>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Rol</label>
              <select class="form-select" id="roles" name="rol">
                <option value="<?php echo obtenerIdRol($fila["id_funcionario"]) ?>"><?php echo obtenerRol($fila["id_funcionario"]) ?></option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <input type="submit" value="Actualizar" class="btn btn-primary">
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal de confirmación -->
<div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-black">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEliminarLabel">Confirmar Desactivación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        ¿Realmente desea desactivar al usuario <strong><?php echo $fila['nombre_funcionario']; ?></strong>?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        <a href="../config/op_desactivar_funcionario.php?id=<?php echo $fila['id_funcionario']; ?>" class="btn btn-danger">Sí</a>
      </div>
    </div>
  </div>
</div>

<!-- Modal de activación -->
<div class="modal fade" id="modalActivar" tabindex="-1" aria-labelledby="modalActivarLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-black">
      <div class="modal-header">
        <h5 class="modal-title" id="modalActivarLabel">Confirmar Activación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        ¿Realmente desea activar al usuario <strong><?php echo $fila['nombre_funcionario']; ?></strong>?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        <a href="../config/op_desactivar_funcionario.php?id=<?php echo $fila['id_funcionario']; ?>" class="btn btn-success">Sí</a>
      </div>
    </div>
  </div>
</div>

<!-- Modal de restablecer contraseña -->
<div class="modal fade" id="modalRestablecer" tabindex="-1" aria-labelledby="modalRestablecerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-black">
      <div class="modal-header">
        <h5 class="modal-title" id="modalRestablecerLabel">Restablecer Contraseña</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        ¿Realmente desea restablecerla contraseña al usuario <strong><?php echo $fila['nombre_funcionario']; ?></strong>?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        <a href="../config/op_res_contraseña_funcionario.php?id=<?php echo $fila['id_funcionario']; ?>" class="btn btn-warning">Sí</a>
      </div>
    </div>
  </div>
</div>

</html>

<?php
$conexion->close();
?>

<script>
  fetch('../config/select_dependencia.php')
    .then(res => res.json())
    .then(data => {
      const dependenciaSelect = document.getElementById('dependencia');
      data.forEach(depen => {
        const option = document.createElement('option');
        option.value = depen.id_dependencia;
        option.textContent = depen.nombre_dependencia;
        dependenciaSelect.appendChild(option);
      });
    });

  fetch('../config/select_roles.php')
    .then(res => res.json())
    .then(data => {
      const rolesSelect = document.getElementById('roles');
      data.forEach(rol => {
        const option = document.createElement('option');
        option.value = rol.id_rol;
        option.textContent = rol.nombre_rol;
        rolesSelect.appendChild(option);
      });
    });

  const passwordInput = document.getElementById('exampleInputPassword1');
  const toggleButton = document.getElementById('showPassword');
  toggleButton.addEventListener('click', function () {
    const isPassword = passwordInput.type === 'password';
    passwordInput.type = isPassword ? 'text' : 'password';
    toggleButton.textContent = isPassword ? 'Ocultar' : 'Mostrar';
  });
</script>
