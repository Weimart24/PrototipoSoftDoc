<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once("alerta.php");

// URL base del sistema
$baseUrl = "http://localhost:8080"; // Cambia esto en producción

require '../../PHPMailer/src/Exception.php';
require '../../PHPMailer/src/PHPMailer.php';
require '../../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include("conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $conexion->real_escape_string($_POST['email']);

    // Verifica si el correo existe y si el usuario está activo
    $stmt = $conexion->prepare("SELECT * FROM funcionario WHERE correo = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Validar si está activo
        if ((int)$row['activo'] !== 1) {
            mostrarAlerta('warning', 'Usuario Inactivo', 'No puedes restablecer la contraseña de una cuenta inactiva. Contacta al administrador.', '../../login.php', null);
            exit();
        }

        // Generar token único
        $token = bin2hex(random_bytes(50));

        // Guardar el token en la BD
        $stmtUpdate = $conexion->prepare("UPDATE funcionario SET reset_token = ?, reset_expiration = DATE_ADD(NOW(), INTERVAL 10 MINUTE) WHERE correo = ?");
        $stmtUpdate->bind_param("ss", $token, $email);
        $stmtUpdate->execute();

        // Crear link
        $resetLink = "$baseUrl/resetPassword.php?token=$token";

        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'ventanilaunicaabs@gmail.com';
            $mail->Password = 'cjgd dcki imrz asgl'; // Cambiar en producción por variable segura
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Envío del correo
            $mail->setFrom('tu_correo@gmail.com', 'SoftDoc');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Restablecer Contraseña';
            $mail->Body = "Haz clic en el siguiente enlace para restablecer tu contraseña:<br><br><a href='$resetLink'>$resetLink</a><br><br>Este enlace expirará en 10 minutos.";

            $mail->send();

            mostrarAlerta('success', 'Correo Enviado', 'Se ha enviado un enlace de restablecimiento a tu correo', '../../login.php', null);
            exit();
        } catch (Exception $e) {
            mostrarAlerta('error', 'Error', 'Error al enviar el correo: ' . $mail->ErrorInfo, '', 3000);
            exit();
        }
    } else {
        mostrarAlerta('error', 'Error', 'Usuario no encontrado.', '', 3000);
        exit();
    }
}
?>
