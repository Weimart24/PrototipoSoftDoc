<?php session_start(); 
if(!isset($_SESSION['name'])&& !isset($_SESSION['id'])){
    header('Location: ../../index.php');
  
  }
?>
<!doctype html>
<html lang="en">

<head>
    <?php include 'modulos/head.php' ?>
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <?php include 'modulos/sidebar.php' ?>
            <!-- End Sidebar scroll-->
        </aside>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <?php include('modulos/header.php') ?>
            <!--  Header End -->
            <div class="container-fluid">
                <!-- Formulario para crear un radicado-->
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
                                                <label for="exampleInputEmail1" class="form-label">Nombre Remitente</label>
                                                <input type="text" name="nombre" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required">
                                                <div id="emailHelp" class="form-text">Ingrese el nombre completo del Remitente.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="inputGroupSelect02" class="form-label">Tipo documento</label>
                                                <select class="form-select" id="inputGroupSelect02" name="tipo">
                                                    <option selected>Seleccionar...</option>
                                                    <option>CC</option>
                                                    <option>TI</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">Número de Documento</label>
                                                <input type="number" name="cedula" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                                                <div id="emailHelp" class="form-text">Ingrese la cédula.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">Teléfono</label>
                                                <input type="text" name="telefono" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                                                <div id="emailHelp" class="form-text">Ingrese el teléfono.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">Dirección</label>
                                                <input type="text" name="direccion" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                                                <div id="emailHelp" class="form-text">Ingrese el dirección.</div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">Correo</label>
                                                <input type="email" name="correo" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                                                <div id="emailHelp" class="form-text">Correo Electrónico.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="inputGroupSelect02">Ingrese la dependendencia compentente.</label>
                                                <select class="form-select" id="inputDependencia" name="dependencia">
                                                    <option value="">-- Seleccione --</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="inputGroupSelect02">Ingrese el funcionario relacionado.</label>
                                                <select class="form-select" id="inputFuncionario" name="funcionario">
                                                    <option value="">-- Seleccione una dependencia primero --</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">País</label>
                                                <input type="text" name="pais" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required value="Colombia">
                                                <div id="emailHelp" class="form-text">Ingrese el Pais.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">Departamento</label>
                                                <input type="text" name="departamento" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required value="Caldas">
                                                <div id="emailHelp" class="form-text">Ingrese el departemento.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">Municipio</label>
                                                <input type="text" name="municipio" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required value="Manizales">
                                                <div id="emailHelp" class="form-text">Ingrese el municipio.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">Asunto</label>
                                                <input type="text" name="asunto" class="form-control" id="exampleInputEmail1" maxlength="42" aria-describedby="emailHelp" required>
                                                <div id="emailHelp" class="form-text">Ingrese el asunto (max 42 carácteres).</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="asuntoTextarea" class="form-label">Detalle del Radicado</label>
                                                <textarea name="detalleRadicado" class="form-control" id="asuntoTextarea" rows="4" required></textarea>
                                                <div id="emailHelp" class="form-text">Ingrese el detalle del radicado.</div>
                                            </div>
                                            <label for="documento" class="form-label">Adjuntar documento</label>
                                            <div class="input-group" id="adjuntarDocumento">
                                                <input type="file" name="file" class="form-control" id="documento" aria-describedby="inputGroupFileAddon04" aria-label="Upload" re>
                                                <button class="btn btn-danger" type="button" id="inputGroupFileAddon04" onclick='eliminarAdjunto()'>Eliminar adjunto</button>
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-3">Radicar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fin formulario para crear un radicado-->
                <div class="py-6 px-6 text-center">
                    <p class="mb-0 fs-4">Diseñado y desarrollado por <a href="https://softDocument.com/" target="_blank" class="pe-1 text-primary text-decoration-underline">SoftDocument.com</a></p>
                </div>
            </div>
        </div>
    </div>
    <?php include('modulos/script.php') ?>

</body>
<script>
        // Cargar dependencias al inicio
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

        // Escuchar cambios en el select de usuarios
        document.getElementById('inputDependencia').addEventListener('change', function() {
            const depenId = this.value;
            const funcSelect = document.getElementById('inputFuncionario');

            funcSelect.innerHTML = '<option value="">-- Cargando funcionarios --</option>';
            if (depenId) {
                fetch('../config/select_funcionario.php?id_dependencia=' + depenId)
                    .then(res => res.json())
                    .then(data => {
                        console.log(depenId);
                        funcSelect.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(func => {
                                const option = document.createElement('option');
                                option.value = func.id_funcionario;
                                option.textContent = `${func.nombre_funcionario}`;
                                funcSelect.appendChild(option);
                            });
                        } else {
                            funcSelect.innerHTML = '<option value="">Sin órdenes</option>';
                        }
                    });
            } else {
                funcSelect.innerHTML = '<option value="">-- Seleccione un usuario primero --</option>';
            }
        });
    </script>

</html>