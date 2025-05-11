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
        $mail->Username = 'ventanilaunicaabs@gmail.com';
        $mail->Password = 'cjgd dcki imrz asgl';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('ventanilaunicaabs@gmail.com', 'SoftDoc');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = "
            <h3>Nuevo mensaje de contacto</h3>
            <p><strong>Nombre:</strong> {$name}</p>
            <p><strong>Correo:</strong> {$email}</p>
            <p><strong>Asunto:</strong> {$subject}</p>
            <p><strong>Mensaje:</strong></p>
            <p>{$message}</p>
        ";
        $mail->AltBody = "Nuevo mensaje de contacto\n\nNombre: {$name}\nCorreo: {$email}\nAsunto: {$subject}\nMensaje:\n{$message}";

        $mail->send();
        header("Location: ../../contact.php?status=success&message=Mensaje+enviado+correctamente.");
        exit();
    } catch (Exception $e) {
        header("Location: ../../contact.php?status=error&message=Error+al+enviar:+{$mail->ErrorInfo}");
        exit();
    }
} else {
    header("Location: ../../contact.php?status=error&message=Método+no+permitido.");
    exit();
}
