<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Actualizar radicado</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="../config/op_actulizar_radicado.php" method="post">
            <div class="modal-body">
                <input type="hidden" name="radicado" value="<?php echo $fila['id_radicado'] ?>">
                <label for="nombre" class="form-label">Actualizar Nombre remitente</label>
                <input type="text" name="nombre" value="<?php echo $fila['nombre_remitente'] ?>" class="form-control" required>
                <br>
                <label for="tipo" class="form-label">Actualizar tipo de documento</label>
                <select class="form-select" name="tipo">
                    <option selected><?php echo $fila['tipo_documento'] ?></option>
                    <option>CC</option>
                    <option>TI</option>
                    <option>NIT</option>
                </select>
                <br>
                <label for="cedula" class="form-label">Cédula remitente</label>
                <input type="text" name="cedula" value="<?php echo $fila['cedula_remitente'] ?>" class="form-control" required>
                <br>
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" name="telefono" value="<?php echo $fila['telefono'] ?>" class="form-control" required>
                <br>
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" name="direccion" value="<?php echo $fila['direccion'] ?>" class="form-control" required>
                <br>
                <label for="correo" class="form-label">Correo electrónico</label>
                <input type="text" name="correo" value="<?php echo $fila['correo'] ?>" class="form-control" required>
                <br>
                <label for="fecha" class="form-label">Fecha radicado</label>
                <input type="date" name="fecha" value="<?php echo $fila['fecha_radicado'] ?>" class="form-control" required>
                <br>
                <label for="medio" class="form-label">Medio recepción</label>
                <select class="form-select" name="medio">
                    <option selected><?php echo $fila['medio_recepcion'] ?></option>
                    <option>Físico</option>
                    <option>Electrónico</option>
                    <option>Fax</option>
                </select>
                <br>
                <label for="asunto" class="form-label">Asunto</label>
                <input type="text" name="asunto" value="<?php echo $fila['asunto'] ?>" class="form-control" required>
                <br>
                <label for="dependencia" class="form-label">Dependencia</label>
                <select class="form-select" name="dependencia">
                    <option selected><?php echo obtenerDependenciaPorCodigo($fila["dependencia"]) ?></option>
                    <?php include '../config/select_dependencia.php'; ?>
                </select>
                <br>
                <label for="pais" class="form-label">Pais</label>
                <input type="text" name="pais" value="<?php echo $fila['pais'] ?>" class="form-control" required>
                <br>
                <label for="departamento" class="form-label">Departamento</label>
                <input type="text" name="departamento" value="<?php echo $fila['departamento'] ?>" class="form-control" required>
                <br>
                <label for="municipio" class="form-label">Municipio</label>
                <input type="text" name="municipio" value="<?php echo $fila['municipio'] ?>" class="form-control" required>
                <br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <input type="submit" value="Actualizar" class="btn btn-primary" onclick="return confirm('¿Desea modificar ese Radicado?')">
            </div>
        </form>
    </div>
</div>