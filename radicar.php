<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SoftDoc</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="app/assets/css/styles.min.css" />
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <div class="container-fluid">
                <!-- Formulario para crear un radicado-->
                <div class="container-fluid">
                    <div class="container-fluid">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title fw-semibold mb-4">FORMULARIO REGISTRO DE CORRESPONDENCIA</h5>
                                <div class="card">
                                    <div class="card-body">
                                        <form action="app/config/op_crear_radicado_usuario.php" method="POST" enctype="multipart/form-data">
                                            <input type="hidden" name="admin">
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">Nombre Remitente</label>
                                                <input type="text" name="nombre" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                                                <div id="emailHelp" class="form-text">Ingrese el nombre completo del Remitente.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="inputGroupSelect02" class="form-label">Tipo documento</label>
                                                <select class="form-select" id="inputGroupSelect02" name="tipo" required>
                                                    <option value="" disabled selected>Seleccionar...</option>
                                                    <option>CC</option>
                                                    <option>TI</option>
                                                    <option>NIT</option>
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
                                                <div id="emailHelp" class="form-text">Ingrese la dirección.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">Correo</label>
                                                <input type="email" name="correo" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                                                <div id="emailHelp" class="form-text">Correo Electrónico.</div>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">País</label>
                                                <input type="text" name="pais" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required value="Colombia">
                                                <div id="emailHelp" class="form-text">Ingrese el País.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">Departamento</label>
                                                <input type="text" name="departamento" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required value="Caldas">
                                                <div id="emailHelp" class="form-text">Ingrese el departamento.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">Municipio</label>
                                                <input type="text" name="municipio" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required value="Manizales">
                                                <div id="emailHelp" class="form-text">Ingrese el municipio.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">Asunto</label>
                                                <input type="text" name="asunto" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                                                <div id="emailHelp" class="form-text">Ingrese el asunto.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="asuntoTextarea" class="form-label">Detalle del Radicado</label>
                                                <textarea name="detalleRadicado" class="form-control" id="asuntoTextarea" rows="4" required></textarea>
                                                <div id="emailHelp" class="form-text">Ingrese el detalle del radicado.</div>
                                            </div>
                                            <label for="documento" class="form-label">Adjuntar documento</label>
                                            <div class="input-group" id="adjuntarDocumento">
                                                <input type="file" name="file" class="form-control" id="documento" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                                                <button class="btn btn-danger" type="button" id="inputGroupFileAddon04" onclick='eliminarAdjunto()'>Eliminar adjunto</button>
                                                <div id="emailHelp" class="form-text w-100">Adjunte Archivo si es necesario.</div>
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-3">Radicar</button>
                                            <button type="button" class="btn btn-secondary mt-3" onclick="window.location.href='index.php'">Atrás</button>
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
</body>
</html>