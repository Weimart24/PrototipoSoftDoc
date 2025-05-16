<?php
// Conexión a la base de datos
include_once ("app/config/conexion.php");
// Verificar la conexión
if ($conexion->connect_error){
    die("Error de conexión: " . $conexion->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selección de País, Provincia y Ciudad</title>
</head>
<body>
    <form action="" method="post">
        <!-- PAIS -->
        <label for="pais">País:</label>
        <select name="pais" id="pais">
           <option value="Seleccione una Opcion"></option>
        </select>
        <!-- DEPARTAMENTO -->
        <label for="depart">Provincia:</label>
        <select name="depart" id="depart">
            <option value="Seleccione una Opcion"></option>
        </select>
        <!-- MUNICIPIO -->
        <label for="munic">Ciudad:</label>
        <select name="munic" id="munic">
            <option value="Seleccione una Opcion"></option>
        </select>

        <input type="submit" value="Enviar">
    </form>
</body>
</html>


<?php
// Cerrar la conexión a la base de datos al finalizar
$conexion->close();
?>
