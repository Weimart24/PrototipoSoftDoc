<?php 
include_once ("conexion.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $radicado = $conexion->real_escape_string($_POST['radicado']);
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $tipo = $conexion->real_escape_string($_POST['tipo']);
    $cedula = $conexion->real_escape_string($_POST['cedula']);
    $telefono = $conexion->real_escape_string($_POST['telefono']);
    $direccion = $conexion->real_escape_string($_POST['direccion']);
    $correo = $conexion->real_escape_string($_POST['correo']);
    $fecha = $conexion->real_escape_string($_POST['fecha']);
    $medio = $conexion->real_escape_string($_POST['medio']);
    $asunto = $conexion->real_escape_string($_POST['asunto']);
    $dependencia = $conexion->real_escape_string($_POST['dependencia']);
    $pais = $conexion->real_escape_string($_POST['pais']);
    $departamento = $conexion->real_escape_string($_POST['departamento']);
    $municipio = $conexion->real_escape_string($_POST['municipio']);
    
    //Creamos la query
    $query = "UPDATE radicacion SET
    nombre_remitente = '$nombre',
    tipo_documento = '$tipo',
    cedula_remitente = '$cedula',
    telefono = '$telefono',
    direccion = '$direccion',
    correo = '$correo',
    fecha_radicado = '$fecha',
    medio_recepcion = '$medio',
    asunto = '$asunto',
    dependencia = '$dependencia',
    pais = '$pais',
    departamento = '$departamento',
    municipio = '$municipio'
    WHERE id_radicado = '$radicado'";

//Inicializamos la query
if($conexion->query($query)){
    echo "<script>
            alert('RADICADO ACTUALIZADO CORRECTAMENTE');
            window.location = '../html/radicado.php';
        </script>";
    exit();
}else{
    echo "Error al actualizar el Radicado: ". $conexion->error;
}
//Cierre de la conexion
$conexion->close();
}
?>