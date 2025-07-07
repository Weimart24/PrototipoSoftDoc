<?php
session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['name'])) {
    header("Location: ../../../login.php");
    exit();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require $_SERVER["DOCUMENT_ROOT"] . '/phpmailer/src/PHPMailer.php';
require $_SERVER["DOCUMENT_ROOT"] . '/phpmailer/src/SMTP.php';
require $_SERVER["DOCUMENT_ROOT"] . '/phpmailer/src/Exception.php';

include_once("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $tipo = $_POST['tipo'];
    $cedula = $_POST['cedula'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $correo = $_POST['correo'];
    $asunto = $_POST['asunto'];
    $detalleRadicado = $_POST['detalleRadicado'];
    $pais = $_POST['pais'];
    $departamento = $_POST['departamento'];
    $municipio = $_POST['municipio'];
    $dependencia = $_POST['dependencia'];
    $funcionario = $_POST['funcionario'];

    $fecha = date('Y-m-d');
    $ultimo_numero = obtenerUltimoNumero($conexion);
    $radicado = generarRadicado($dependencia, $ultimo_numero);

    // Subida del archivo
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == UPLOAD_ERR_OK) {
        $nombre_archivo = $_FILES["file"]["name"];
        $ruta_temporal = $_FILES["file"]["tmp_name"];
        $ruta_destino = "../document/" . $nombre_archivo;
        move_uploaded_file($ruta_temporal, $ruta_destino);
        $ruta_final = "app/document/" . $nombre_archivo;
    } else {
        $ruta_final = "";
    }

    $stmtRadicado = $conexion->prepare("INSERT INTO radicacion (
        radicado, nombre_remitente, tipo_documento, cedula_remitente,
        telefono, direccion, correo, fecha_radicado, asunto, pais,
        departamento, municipio, documento, id_dependencia, id_funcionario
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmtRadicado->bind_param("sssssssssssssss",
        $radicado, $nombre, $tipo, $cedula, $telefono, $direccion, $correo,
        $fecha, $asunto, $pais, $departamento, $municipio, $ruta_final, $dependencia, $funcionario
    );

    if ($stmtRadicado->execute()) {
        $id_radicado = $stmtRadicado->insert_id;

        $stmtSeguimiento = $conexion->prepare("INSERT INTO seguimiento_radicado (
            id_radicado, fecha_seguimiento, detalle
        ) VALUES (?, ?, ?)");

        $stmtSeguimiento->bind_param("iss", $id_radicado, $fecha, $detalleRadicado);

        if (!$stmtSeguimiento->execute()) {
            $status = "error";
            $message = "Error al insertar seguimiento: " . $stmtSeguimiento->error;
            header("Location: /app/html/crear_radicado.php?status=$status&message=" . urlencode($message));
            exit();
        }

        // Enviar correo
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'weimart24@gmail.com';
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

            $status = "success";
            $message = "Radicado creado y correo enviado. Radicado: $radicado";
        } catch (Exception $e) {
            $status = "success";
            $message = "Radicado creado, pero error al enviar correo.";
        }

        header("Location: /app/html/radicado.php?status=$status&message=" . urlencode($message));
        exit();
    } else {
        $status = "error";
        $message = "Error al crear radicado: " . $stmtRadicado->error;
        header("Location: /app/html/radicado.php?status=$status&message=" . urlencode($message));
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

    return str_pad($nuevo_id, 3, "0", STR_PAD_LEFT);
}
