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
                      <h5 class="card-tittle fs-6 mb-4 text-primary">FORMULARIO REGISTRO DE RADICADO</h5>
                      <form action="../config/op_crear_radicado.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="admin">

                        <!-- Información del remitente -->
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
                            <div class="col-md-6 mb-3">
                              <label class="form-label fw-bold text-dark-emphasis">Teléfono</label>
                              <input type="text" name="telefono" class="form-control rounded-3" required>
                            </div>
                            <div class="col-md-6 mb-3">
                              <label class="form-label fw-bold text-dark-emphasis">Correo</label>
                              <input type="email" name="correo" class="form-control rounded-3" required>
                            </div>
                          </div>
                        </fieldset>

                        <!-- Ubicación -->
                        <fieldset class="border rounded-3 p-3 mb-4">
                          <legend class="float-none w-auto px-3 text-secondary fw-semibold fs-5">Ubicación</legend>
                          <div class="row">
                            <div class="col-md-4 mb-3">
                              <label class="form-label fw-bold text-dark-emphasis">País</label>
                              <select class="form-select rounded-3" id="inputPais" name="pais" required>
                                <option value="">-- Seleccione país --</option>
                                <option value="Colombia">Colombia</option>
                              </select>
                            </div>
                            <div class="col-md-4 mb-3">
                              <label class="form-label fw-bold text-dark-emphasis">Departamento</label>
                              <select class="form-select rounded-3" id="departamento" name="departamento" required>
                               <option value="">-- Seleccione departamento --</option>
                              </select>
                            </div>
                            <div class="col-md-4 mb-3">
                              <label class="form-label fw-bold text-dark-emphasis">Municipio</label>
                              <select class="form-select rounded-3" id="municipio" name="municipio" required>
                                <option value="">-- Seleccione un departamento primero --</option>
                              </select>
                            </div>
                            <div class="col-4 mb-3">
                              <label class="form-label fw-bold text-dark-emphasis">Dirección</label>
                              <input type="text" name="direccion" class="form-control rounded-3" required>
                            </div>
                          </div>
                        </fieldset>

                        <!-- Detalles y Documentación del Radicado -->
                        <fieldset class="border rounded-3 p-3 mb-4">
                          <legend class="float-none w-auto px-3 text-secondary fw-semibold fs-5">Documentación del Radicado</legend>
                          <div class="row">
                            <div class="col-5 mb-3">
                              <label class="form-label fw-bold text-dark-emphasis">Asunto</label>
                              <input type="text" name="asunto" class="form-control rounded-3" maxlength="42" required>
                            </div>
                            <div class="col-7 mb-3">
                              <label class="form-label fw-bold text-dark-emphasis">Adjuntar documento</label>
                              <div class="input-group">
                                <input type="file" name="file" class="form-control rounded-start-3" id="fileInput" accept=".pdf, .jpg">
                                <button class="btn btn-danger rounded-end-3" type="button" onclick="eliminarAdjunto()">Eliminar</button>
                              </div>
                              <div class="form-text">Adjunte el documento si es necesario.</div>
                            </div>
                            <div class="mb-3">
                              <label class="form-label fw-bold text-dark-emphasis">Detalle del Radicado</label>
                              <textarea name="detalleRadicado" class="form-control rounded-3" rows="4" required></textarea>
                            </div>
                          </div>
                        </fieldset>

                        <!-- Asignación interna -->
                        <fieldset class="border rounded-3 p-3 mb-4">
                          <legend class="float-none w-auto px-3 text-secondary fw-semibold fs-5">Asignación Interna</legend>
                          <div class="row">
                            <div class="col-md-6 mb-3">
                              <label class="form-label fw-bold text-dark-emphasis">Dependencia</label>
                              <select class="form-select rounded-3" id="inputDependencia" name="dependencia" required></select>
                            </div>
                            <div class="col-md-6 mb-3">
                              <label class="form-label fw-bold text-dark-emphasis">Funcionario</label>
                              <select class="form-select rounded-3" id="inputFuncionario" name="funcionario" required>
                                <option value="">-- Seleccione una dependencia primero --</option>
                              </select>
                            </div>
                          </div>
                        </fieldset>

                        <!-- Botón enviar -->
                        <div class="text-end">
                          <button type="submit" class="btn btn-primary btn-lg px-4 rounded-3">Registrar Radicado</button>
                        </div>
                      </form>
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
</body>
</html>

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

  function eliminarAdjunto() {
    document.getElementById('fileInput').value = '';
  }
    </script>

<script src="/app/assets/js/dataColombia.js"></script>
