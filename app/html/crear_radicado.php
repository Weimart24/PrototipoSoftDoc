<?php 
session_start(); 
if(!isset($_SESSION['name']) && !isset($_SESSION['id'])){
    header('Location: ../../index.php');
    exit();
}
?>
<!doctype html>
<html lang="en">

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
            <?php include('modulos/header.php') ?>

            <div class="container-fluid">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title fw-semibold mb-4">FORMULARIO REGISTRO DE CORRESPONDENCIA</h5>
                            <div class="card">
                                <div class="card-body">
                                    <form action="../config/op_crear_radicado.php" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="admin">
                                        <div class="mb-3">
                                            <label class="form-label">Nombre Remitente</label>
                                            <input type="text" name="nombre" class="form-control" required>
                                            <div class="form-text">Ingrese el nombre completo del Remitente.</div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Tipo documento</label>
                                            <select class="form-select" name="tipo" required>
                                                <option value="" selected disabled>Seleccionar...</option>
                                                <option>CC</option>
                                                <option>TI</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Número de Documento</label>
                                            <input type="number" name="cedula" class="form-control" required>
                                            <div class="form-text">Ingrese la cédula.</div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Teléfono</label>
                                            <input type="text" name="telefono" class="form-control" required>
                                            <div class="form-text">Ingrese el teléfono.</div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Dirección</label>
                                            <input type="text" name="direccion" class="form-control" required>
                                            <div class="form-text">Ingrese la dirección.</div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Correo</label>
                                            <input type="email" name="correo" class="form-control" required>
                                            <div class="form-text">Correo Electrónico.</div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Ingrese la dependencia competente</label>
                                            <select class="form-select" id="inputDependencia" name="dependencia" required>
                                                <option value="">-- Seleccione --</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Ingrese el funcionario relacionado</label>
                                            <select class="form-select" id="inputFuncionario" name="funcionario" required>
                                                <option value="">-- Seleccione una dependencia primero --</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">País</label>
                                            <input type="text" name="pais" class="form-control" required value="Colombia">
                                            <div class="form-text">Ingrese el país.</div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Departamento</label>
                                            <input type="text" name="departamento" class="form-control" required value="Caldas">
                                            <div class="form-text">Ingrese el departamento.</div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Municipio</label>
                                            <input type="text" name="municipio" class="form-control" required value="Manizales">
                                            <div class="form-text">Ingrese el municipio.</div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Asunto</label>
                                            <input type="text" name="asunto" class="form-control" maxlength="42" required>
                                            <div class="form-text">Ingrese el asunto (máx. 42 caracteres).</div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Detalle del Radicado</label>
                                            <textarea name="detalleRadicado" class="form-control" rows="4" required></textarea>
                                            <div class="form-text">Ingrese el detalle del radicado.</div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Adjuntar documento</label>
                                            <div class="input-group">
                                                <input type="file" name="file" class="form-control">
                                                <button class="btn btn-danger" type="button" onclick='eliminarAdjunto()'>Eliminar adjunto</button>
                                            </div>
                                            <div class="form-text">Adjunte el documento si es necesario.</div>
                                        </div>

                                        <button type="submit" class="btn btn-primary mt-3">Radicar</button>
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
    </div>

    <?php include('modulos/script.php') ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- SweetAlert y manejo de formulario -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');
            const message = urlParams.get('message');

            if (status && message) {
                Swal.fire({
                    icon: status === 'success' ? 'success' : 'error',
                    title: status === 'success' ? '¡Éxito!' : 'Error',
                    text: decodeURIComponent(message),
                    confirmButtonColor: '#3085d6'
                }).then(() => {
                    window.history.replaceState({}, document.title, window.location.pathname);
                });
            }
        });

        // Limpiar formulario al volver con botón "atrás"
        window.addEventListener("pageshow", function (event) {
            if (event.persisted || performance.navigation.type === 2) {
                const form = document.querySelector("form");
                if (form) form.reset();
            }
        });

        function eliminarAdjunto() {
            document.querySelector('input[type="file"]').value = '';
        }
    </script>

    <!-- Cargar dependencias y funcionarios -->
    <script>
        fetch('../config/select_dependencia.php')
            .then(res => res.json())
            .then(data => {
                const dependenciaSelect = document.getElementById('inputDependencia');
                data.forEach(depen => {
                    const option = document.createElement('option');
                    option.value = depen.id_dependencia;
                    option.textContent = depen.nombre_dependencia;
                    dependenciaSelect.appendChild(option);
                });
            });

        document.getElementById('inputDependencia').addEventListener('change', function () {
            const depenId = this.value;
            const funcSelect = document.getElementById('inputFuncionario');
            funcSelect.innerHTML = '<option value="">-- Cargando funcionarios --</option>';

            if (depenId) {
                fetch('../config/select_funcionario.php?id_dependencia=' + depenId)
                    .then(res => res.json())
                    .then(data => {
                        funcSelect.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(func => {
                                const option = document.createElement('option');
                                option.value = func.id_funcionario;
                                option.textContent = func.nombre_funcionario;
                                funcSelect.appendChild(option);
                            });
                        } else {
                            funcSelect.innerHTML = '<option value="">Sin funcionarios disponibles</option>';
                        }
                    });
            } else {
                funcSelect.innerHTML = '<option value="">-- Seleccione una dependencia primero --</option>';
            }
        });
    </script>
</body>
</html>
