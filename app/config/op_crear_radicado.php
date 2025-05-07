<?php 
include_once ("conexion.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $tipo = $conexion->real_escape_string($_POST['tipo']);
    $cedula = $conexion->real_escape_string($_POST['cedula']);
    $telefono = $conexion->real_escape_string($_POST['telefono']);
    $direccion = $conexion->real_escape_string($_POST['direccion']);
    $correo = $conexion->real_escape_string($_POST['correo']);
    //$fecha = $conexion->real_escape_string($_POST['fecha']);
    //$medio = $conexion->real_escape_string($_POST['medio']);
    $asunto = $conexion->real_escape_string($_POST['asunto']);
    //ojo, compicado
    $dependencia = $conexion->real_escape_string($_POST['dependencia']);
    $funcionario = $conexion->real_escape_string($_POST['funcionario']);

    $pais = $conexion->real_escape_string($_POST['pais']);
    $departamento = $conexion->real_escape_string($_POST['departamento']);
    $municipio = $conexion->real_escape_string($_POST['municipio']);


    // Asignar valores directamente
    $fecha = date('Y-m-d'); // Fecha del sistema

    //Lógica obtener el último número
    $nuevo_numero=0;
    $ultimo_numero = obtenerUltimoNumero($conexion);
    if($ultimo_numero>999){
        $nuevo_numero =100;
    }else{
        $nuevo_numero = $ultimo_numero + 1;
    }

    $radicado = generarRadicado($nuevo_numero);
    
    //Verificación del archivo
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == UPLOAD_ERR_OK) {
        $nombre_archivo = $_FILES["file"]["name"];
        $ruta_temporal = $_FILES["file"]["tmp_name"];

        // Mover el archivo a una ubicación permanente en tu servidor
        $ruta_destino = "../document/" . $nombre_archivo;
        move_uploaded_file($ruta_temporal, $ruta_destino);
        $ruta_final = "app/document/" . $nombre_archivo;

        echo "Archivo subido con éxito.";
    } else {
        echo "Error al subir el archivo.";
    }
    //Creamos la query
    $query = "INSERT INTO radicacion(
    radicado,
    nombre_remitente,
    tipo_documento,
    cedula_remitente,
    telefono,
    direccion,
    correo,
    fecha_radicado,
    asunto,
    pais,
    departamento,
    municipio,
    documento,
    id_dependencia,
    id_dependencia,
    )
    VALUES(
        '$radicado',
        '$nombre',
        '$tipo',
        '$cedula',
        '$telefono',
        '$direccion',
        '$correo',
        '$fecha',
        '$asunto',
        '$pais',
        '$departamento',
        '$municipio',
        '$ruta_final'
        '$dependencia',
        '$funcionario',

    )";
//Inicializamos la query
if($conexion->query($query)){
    echo "Radicado creado con exito";
    echo "<script>
            alert('RADICADO CREADO CORRECTAMENTE');
            window.location = '../html/radicado.php';
        </script>";
    exit();
}else{
    echo "Error al crear al Radicado: ". $conexion->error;
}
//Cierre de la conexion
$conexion->close();
}

function generarRadicado($nuevo){
    $fecha = date('Y-m-d');
    return $fecha . ' - ' .$nuevo;
}


function obtenerUltimoNumero($conexion){
    $query = "SELECT radicado FROM radicacion ORDER BY id_radicado DESC LIMIT 1";
    $resultado = $conexion->query($query);

    if ($resultado->num_rows > 0) {
        // Obtener el resultado como arreglo asociativo
        $row = $resultado->fetch_assoc();

        // Obtener el radicado del resultado
        $ultimo_radicado = $row['radicado'];

        // Obtener el último número a partir del radicado
        $partes = explode(" - ", $ultimo_radicado);
        $ultimo_numero_string = end($partes);
        
        // Convertir el número a entero
        $ultimo_numero = intval($ultimo_numero_string);

        return $ultimo_numero;
    } 
};
?>