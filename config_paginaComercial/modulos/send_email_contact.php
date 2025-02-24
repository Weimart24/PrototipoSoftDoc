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
        $mail->Body    = "Nombre: $nombre<br>Correo: $email<br>Hemos recibido tu correo electrónico, muy pronto nos pondremos en contacto contigo.";

        $mail->send();
        echo "Correo enviado correctamente.";
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }
} else {
    echo "Acceso no permitido.";
}
?>
