<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require $_SERVER["DOCUMENT_ROOT"] . '/phpmailer/src/PHPMailer.php';
require $_SERVER["DOCUMENT_ROOT"] . '/phpmailer/src/SMTP.php';
require $_SERVER["DOCUMENT_ROOT"] . '/phpmailer/src/Exception.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $nombre = filter_var($_POST["nombre"], FILTER_SANITIZE_STRING);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Correo inválido.");
    }

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
        $mail->addAddress($email, 'Destinatario');

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
                <li><strong>Correo:</strong> $email</li>
                <li><strong>País:</strong> $pais</li>
                <li><strong>Departamento:</strong> $departamento</li>
                <li><strong>Municipio:</strong> $municipio</li>
            </ul>
            <p><strong>Asunto:</strong> $asunto</p>
            <p>Nos pondremos en contacto contigo muy pronto.</p>
            <p>Atentamente,<br>El equipo de SOFTDOC</p>
        ";

        $mail->send();
        echo "Correo enviado correctamente.";
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }
} else {
    echo "Acceso no permitido.";
}
?>
