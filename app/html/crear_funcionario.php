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
                <!-- radicados.php visualizar los funcionarios -->
                <div class="container-fluid">
                    <div class="container-fluid">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title fw-semibold mb-4">REGISTRO DE FUNCIONARIOS</h5>
                                <div class="card">
                                    <div class="card-body">
                                        <form action="../config/op_crear_funcionario.php" method="POST">
                                            <div class="mb-3">
                                                <label for="tipo-documento" class="form-label">Tipo documento</label>
                                                <select class="form-select" id="tipo-documento" name="tipo">
                                                    <option selected>Seleccionar...</option>
                                                    <option>CC</option>
                                                    <option>TI</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="cedula" class="form-label">Cédula</label>
                                                <input type="text" name="cedula" class="form-control" id="cedula" aria-describedby="emailHelp" required>
                                                <div id="emailHelp" class="form-text">Ingrese la cédula.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="funcionario" class="form-label">Nombre funcionario</label>
                                                <input type="text" name="nombre" class="form-control" id="funcionario" aria-describedby="emailHelp" required>
                                                <div id="emailHelp" class="form-text">Nombre del funcionario.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="telefono" class="form-label">Teléfono</label>
                                                <input type="text" name="telefono" class="form-control" id="telefono" aria-describedby="emailHelp" required>
                                                <div id="emailHelp" class="form-text">Ingrese el teléfono.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="direccion" class="form-label">Dirección</label>
                                                <input type="text" name="direccion" class="form-control" id="direccion" aria-describedby="emailHelp" required>
                                                <div id="emailHelp" class="form-text">Ingrese el dirección.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="correo" class="form-label">Correo</label>
                                                <input type="email" name="correo" class="form-control" id="correo" aria-describedby="emailHelp" required>
                                                <div id="emailHelp" class="form-text">Correo Electrónico.</div>
                                            </div>
                                            <label class="form-label" for="dependencia">Ingrese la dependendencia donde labora.</label>
                                            <div class="mb-3">
                                                <select class="form-select" id="dependencia" name="dependencia">
                                                    <option selected>Seleccionar...</option>
                                                </select>
                                            </div>
                                            <label class="form-label" for="dependencia">Ingrese el rol del funcionario.</label>
                                            <div class="mb-3">
                                                <select class="form-select" id="roles" name="roles">
                                                    <option selected>Seleccionar...</option>
                                                </select>
                                            </div>
                                            <div class="mb-4">
                                                <label for="exampleInputPassword1" class="form-label">Contraseña</label>
                                                <div class="input-group">
                                                    <input type="password" name="contrasena" class="form-control" id="exampleInputPassword1" required>
                                                    <button type="button" id="showPassword" class="btn btn-outline-secondary">Mostrar</button>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Registrar</button>
                                        </form>
                                    </div>
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