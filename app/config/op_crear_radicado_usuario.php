<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require $_SERVER["DOCUMENT_ROOT"] . '/phpmailer/src/PHPMailer.php';
require $_SERVER["DOCUMENT_ROOT"] . '/phpmailer/src/SMTP.php';
require $_SERVER["DOCUMENT_ROOT"] . '/phpmailer/src/Exception.php';

include_once("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    $id_dependencia = "RG";
    $id_funcionario = 3;
    $fecha = date('Y-m-d');

    $ultimo_numero = obtenerUltimoNumero($conexion);
    $radicado = generarRadicado($id_dependencia, $ultimo_numero);

    // Manejo del archivo
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == UPLOAD_ERR_OK) {
        $nombre_archivo = $_FILES["file"]["name"];
        $ruta_temporal = $_FILES["file"]["tmp_name"];
        $ruta_destino = "../document/" . $nombre_archivo;
        move_uploaded_file($ruta_temporal, $ruta_destino);
        $ruta_final = "app/document/" . $nombre_archivo;
    } else {
        $ruta_final = "";
    }

    // Insertar en la tabla radicacion
    $queryRadicado = "INSERT INTO radicacion (
        radicado, nombre_remitente, tipo_documento, cedula_remitente, telefono, direccion,
        correo, fecha_radicado, asunto, pais, departamento, municipio,
        documento, id_dependencia, id_funcionario
    ) VALUES (
        '$radicado', '$nombre', '$tipo', '$cedula', '$telefono', '$direccion',
        '$correo', '$fecha', '$asunto', '$pais', '$departamento', '$municipio',
        '$ruta_final', '$id_dependencia', '$id_funcionario'
    )";

    if ($conexion->query($queryRadicado)) {
        $id_radicado = $conexion->insert_id;

        $querySeguimiento = "INSERT INTO seguimiento_radicado (
            id_radicado, fecha_seguimiento, detalle
        ) VALUES (
            '$id_radicado', '$fecha', '$detalleRadicado'
        )";

        if (!$conexion->query($querySeguimiento)) {
            $status = 'error';
            $message = 'Error al insertar el seguimiento: ' . $conexion->error;
            header("Location: /app/html/radicadoUsuarios/crear_radicado.php?status=$status&message=" . urlencode($message));
            exit();
        }

        // Envío de correo
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'weimart24@gmail.com'; // Cambia por tu correo
            $mail->Password = 'wrkf uest hbhd ennk'; // Contraseña de aplicación
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('softdoc@gmail.com', 'SOFTDOC');
            $mail->addAddress($correo, $nombre);

            $mail->isHTML(true);
            $mail->Subject = 'Verificación de recibido';
            $mail->Body = "
                <h3>Verificación de recibido</h3>
                <p>Estimado(a) $nombre,</p>
                <p>Hemos generado tu radicado # <strong>$radicado</strong> con los siguientes datos:</p>
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

            $status = 'success';
            $message = "Radicado creado y correo enviado correctamente. Número de radicado: $radicado";
        } catch (Exception $e) {
            $status = 'success';
            $message = "Radicado creado, pero el correo no pudo enviarse. Número de radicado: $radicado";
        }

        header("Location: /app/html/radicadoUsuarios/radicados.php?status=$status&message=" . urlencode($message));
        exit();
    } else {
        $status = 'error';
        $message = 'Error al crear el radicado: ' . $conexion->error;
        header("Location: /app/html/radicadoUsuarios/radicados.php?status=$status&message=" . urlencode($message));
        exit();
    }

    $conexion->close();
}

function generarRadicado($dependencia, $nuevo) {
    $fecha = date('dmY');
    return $dependencia . $fecha . $nuevo;
}

function obtenerUltimoNumero($conexion){
    $query = "SELECT id_radicado FROM radicacion ORDER BY id_radicado DESC LIMIT 1";
    $result = mysqli_query($conexion, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $ultimo_id = $row['id_radicado'];
        $nuevo_id = $ultimo_id + 1;

        if ($nuevo_id > 999) {
            $nuevo_id = 1; // Reinicia a 001 si se pasa de 999
        }
    } else {
        $nuevo_id = 1; // Si no hay registros aún
    }

    // Formatear a tres dígitos con ceros a la izquierda
    $numero_formateado = str_pad($nuevo_id, 3, "0", STR_PAD_LEFT);

    return $numero_formateado;

};
?>
