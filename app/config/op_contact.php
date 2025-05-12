<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../../phpmailer/src/PHPMailer.php';
require __DIR__ . '/../../phpmailer/src/SMTP.php';
require __DIR__ . '/../../phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $subject = htmlspecialchars(trim($_POST['subject'] ?? ''));
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        header("Location: ../../contact.php?status=error&message=Todos+los+campos+son+obligatorios.");
        exit();
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'informacion.softdoc@gmail.com'; //   correo de donde se enviará el mensaje
        $mail->Password = 'qknx kzpi isvi kdzz'; //  contraseña segura o de aplicación
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('informacion.softdoc@gmail.com', 'Formulario de Contacto');
        $mail->addAddress('ventanilaunicaabs@gmail.com', 'SoftDoc');
        $mail->addReplyTo($email, $name);

        $mail->isHTML(true);
        $mail->Subject = "Nuevo mensaje de contacto: {$subject}";
        $mail->Body = "
            <h3>Has recibido un nuevo mensaje a través del formulario de contacto de tu sitio web.</h3>
            <h4>Datos del usuario:</h4>       
            <p><strong>Nombre:</strong> {$name}</p>
            <p><strong>Correo:</strong> {$email}</p>
            <p><strong>Asunto:</strong> {$subject}</p>
            <p><strong>Mensaje:</strong></p>
            <p>{$message}</p>
        ";
        $mail->AltBody = "Nuevo mensaje de contacto\n\nNombre: {$name}\nCorreo: {$email}\nAsunto: {$subject}\nMensaje:\n{$message}";

        $mail->send();
        header("Location: ../../contact.php?status=success&message=Mensaje+enviado+correctamente.+Nuestro+personal+se+comunicará+contigo+pronto.");
        exit();
    } catch (Exception $e) {
        header("Location: ../../contact.php?status=error&message=No+se+pudo+enviar+el+mensaje.+Intenta+de+nuevo+más+tarde.");
        exit();
    }
} else {
    header("Location: ../../contact.php?status=error&message=Método+no+permitido.");
    exit();
}
