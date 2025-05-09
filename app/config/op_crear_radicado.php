<?php 
include_once ("conexion.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $tipo = $conexion->real_escape_string($_POST['tipo']);
    $cedula = $conexion->real_escape_string($_POST['cedula']);
    $telefono = $conexion->real_escape_string($_POST['telefono']);
    $direccion = $conexion->real_escape_string($_POST['direccion']);
    $correo = $conexion->real_escape_string($_POST['correo']);

    $asunto = $conexion->real_escape_string($_POST['asunto']);
    $detalleRadicado = $conexion->real_escape_string($_POST['detalleRadicado']);

    $pais = $conexion->real_escape_string($_POST['pais']);
    $departamento = $conexion->real_escape_string($_POST['departamento']);
    $municipio = $conexion->real_escape_string($_POST['municipio']);

    $dependencia = $conexion->real_escape_string($_POST['dependencia']);
    $funcionario = $conexion->real_escape_string($_POST['funcionario']);


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
        $ruta_final = ""; // En caso de que no se suba el archivo, dejar el campo vacío
    }
    //Creamos la query
    $queryRadicado = "INSERT INTO radicacion(
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
    id_funcionario
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
        '$ruta_final',
        '$dependencia',
        '$funcionario'
    )";

//Inicializamos la query
if($conexion->query($queryRadicado)){
    $id_radicado = $conexion->insert_id; // ← ID del radicado recién creado

    $querySeguimiento = "INSERT INTO seguimiento_radicado(
        id_radicado,
        fecha_seguimiento,
        detalle
    ) VALUES (
        '$id_radicado',
        '$fecha',
        '$detalleRadicado'
    )";

    if(!$conexion->query($querySeguimiento)){
        echo "Error al insertar seguimiento: " . $conexion->error;
    }

    // Enviar correo electrónico
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->CharSet = 'UTF-8'; // Asegura la codificación
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'weimart24@gmail.com'; // Cambia esto
        $mail->Password = 'wrkf uest hbhd ennk'; // Usa una contraseña de aplicación si usas Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Remitente y destinatario
        $mail->setFrom('softdoc@gmail.com', 'SOFTDOC');
        $mail->addAddress($correo, $nombre);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Verificación de recibido';
        $mail->Body    = "
            <h3>Verificación de recibido</h3>
            <p>Estimado(a) $nombre,</p>
            <p>Hemos recibido tu radicado con los siguientes datos:</p>
            <ul>
                <li><strong>Nombre Remitente:</strong> $nombre</li>
                <li><strong>Tipo de Documento:</strong> $tipo</li>
                <li><strong>Número de Documento:</strong> $cedula</li>
                <li><strong>Teléfono:</strong> $telefono</li>
                <li><strong>Dirección:</strong> $direccion</li>
                <li><strong>Correo:</strong> $correo</li>
                <li><strong>País:</strong> $pais</li>
                <li><strong>Departamento:</strong> $departamento</li>
                <li><strong>Municipio:</strong> $municipio</li>
            </ul>
            <p><strong>Asunto:</strong> $asunto</p>
            <p><strong>Detalle del Radicado:</strong> $detalleRadicado</p>
            <p>Nos pondremos en contacto contigo muy pronto.</p>
            <p>Atentamente,<br>El equipo de SOFTDOC</p>
        ";

        $mail->send();
        echo "Correo enviado correctamente.";
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }

    echo "<script>
            alert('RADICADO CREADO CORRECTAMENTE');
            window.location = '/index.php';
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