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
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-tittle fs-6 mb-4 text-primary">REGISTRO DE FUNCIONARIOS</h5>
                        <form action="../config/op_crear_funcionario.php" method="POST">
                            <fieldset class="border rounded-3 p-3 mb-4">
                              <legend class="float-none w-auto px-3 text-secondary fw-semibold fs-5">Información del Remitente</legend>
                              <div class="row">
                                <div class="col-md-6 mb-3">
                                  <label class="form-label fw-bold text-dark-emphasis">Nombre Remitente</label>
                                  <input type="text" name="nombre" class="form-control rounded-3" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                  <label class="form-label fw-bold text-dark-emphasis">Tipo documento</label>
                                  <select class="form-select rounded-3" name="tipo" required>
                                    <option value="" selected disabled>Seleccionar...</option>
                                    <option>CC</option>
                                    <option>TI</option>
                                  </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                  <label class="form-label fw-bold text-dark-emphasis">Número de Documento</label>
                                  <input type="number" name="cedula" class="form-control rounded-3" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                  <label class="form-label fw-bold text-dark-emphasis">Dirección</label>
                                  <input type="text" name="direccion" class="form-control rounded-3" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                  <label class="form-label fw-bold text-dark-emphasis">Teléfono</label>
                                  <input type="text" name="telefono" class="form-control rounded-3" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                  <label class="form-label fw-bold text-dark-emphasis">Correo</label>
                                  <input type="email" name="correo" class="form-control rounded-3" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                  <label class="form-label fw-bold text-dark-emphasis">Contraseña</label>
                                  <div class="input-group">
                                    <input type="password" name="contrasena" class="form-control rounded-start-3" id="exampleInputPassword1" required>
                                    <button type="button" id="showPassword" class="btn btn-outline-secondary rounded-end-3">Mostrar</button>
                                  </div>
                                </div>
                              </div>
                            </fieldset>

                            <fieldset class="border rounded-3 p-3 mb-4">
                              <legend class="float-none w-auto px-3 text-secondary fw-semibold fs-5">Asignar Dependencia y Rol</legend>
                              <div class="row">
                                <div class="col-md-6 mb-3">
                                  <label class="form-label fw-bold text-dark-emphasis">Ingrese la dependendencia donde labora.</label>
                                    <select class="form-select" id="dependencia" name="dependencia">
                                        <option selected>Seleccionar...</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                  <label class="form-label fw-bold text-dark-emphasis">Ingrese el rol del funcionario.</label>
                                    <select class="form-select" id="roles" name="roles">
                                        <option selected>Seleccionar...</option>
                                    </select>
                                </div>
                              </div>
                            </fieldset>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary btn-lg px-4 rounded-3">Registrar Funcionario</button>
                            </div>
                        </form>
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
<script>
    // Cargar dependencias
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
    

    // Cargar roles
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


    // Mostrar/ocultar contraseña
    const passwordInput = document.getElementById('exampleInputPassword1');
    const toggleButton = document.getElementById('showPassword');
    toggleButton.addEventListener('click', function () {
      const isPassword = passwordInput.type === 'password';
      passwordInput.type = isPassword ? 'text' : 'password';
      toggleButton.textContent = isPassword ? 'Ocultar' : 'Mostrar';
    });
</script>
</html>