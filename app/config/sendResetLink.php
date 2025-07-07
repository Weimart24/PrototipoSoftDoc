<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once("alerta.php");

// URL base del sistema
$baseUrl = "http://localhost:8080"; // ⚠️ Cambie esta URL al desplegar

require '../../PHPMailer/src/Exception.php';
require '../../PHPMailer/src/PHPMailer.php';
require '../../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include("conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $conexion->real_escape_string($_POST['email']);
    $cedula = $conexion->real_escape_string($_POST['cedula']);

    // Verifica si el correo existe
    $stmt = $conexion->prepare("SELECT * FROM funcionario WHERE correo = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$row = $result->fetch_assoc()) {
        mostrarAlerta('error', 'Error', 'Usuario no encontrado.', '', 3500);
        exit();
    }

    // Verifica si la cédula coincide
    if ($row['cedula'] != $cedula) {
        mostrarAlerta('warning', 'Datos incorrectos', 'La cédula no coincide con el correo ingresado.', '', 4000);
        exit();
    }

    // Verifica si el usuario está activo
    if ((int)$row['activo'] !== 1) {
        mostrarAlerta('warning', 'Usuario Inactivo', 'No puedes restablecer la contraseña de una cuenta inactiva. Contacta al administrador.', '../../login.php', null);
        exit();
    }

    // Generar token
    $token = bin2hex(random_bytes(50));

    // Guardar token
    $stmtUpdate = $conexion->prepare("UPDATE funcionario SET reset_token = ?, reset_expiration = DATE_ADD(NOW(), INTERVAL 10 MINUTE) WHERE correo = ?");
    $stmtUpdate->bind_param("ss", $token, $email);
    $stmtUpdate->execute();

    // Crear enlace
    $resetLink = "$baseUrl/resetPassword.php?token=$token";

    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';

    try {
        // Configuración SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ventanilaunicaabs@gmail.com';
        $mail->Password = 'cjgd dcki imrz asgl'; // Reemplace por variable segura
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Cabecera del correo
        $mail->setFrom('ventanilaunicaabs@gmail.com', 'SoftDoc');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Solicitud de Restablecimiento de Contraseña - SoftDoc';

        // Cuerpo del correo mejorado
        $mail->Body = "
            <div style='font-family: Arial, sans-serif; color: #333; padding: 20px; border: 1px solid #ddd; border-radius: 8px;'>
                <h2 style='color: #0d6efd;'>Solicitud de Restablecimiento de Contraseña</h2>
                <p>Hola <strong>{$row['nombre_funcionario']}</strong>,</p>
                <p>Hemos recibido una solicitud para restablecer la contraseña asociada a esta dirección de correo electrónico.</p>
                <p>Si usted realizó esta solicitud, haga clic en el siguiente botón para crear una nueva contraseña:</p>
                <p style='margin: 20px 0;'>
                    <a href='$resetLink' style='background-color: #0d6efd; color: white; padding: 12px 20px; text-decoration: none; border-radius: 6px; font-weight: bold;'>Restablecer Contraseña</a>
                </p>
                <p>Este enlace expirará en <strong>10 minutos</strong> por motivos de seguridad.</p>
                <hr style='margin: 20px 0;'>
                <p style='font-size: 14px; color: #777;'>Si usted no solicitó este restablecimiento, puede ignorar este mensaje. Su contraseña actual seguirá siendo válida.</p>
                <p style='font-size: 14px; color: #777;'>Gracias,<br>El equipo de <strong>SoftDoc</strong></p>
            </div>
        ";

        $mail->send();

        mostrarAlerta('success', 'Correo Enviado', 'Se ha enviado un enlace de restablecimiento a tu correo', '../../login.php', null);
        exit();
    } catch (Exception $e) {
        mostrarAlerta('error', 'Error', 'Error al enviar el correo: ' . $mail->ErrorInfo, '', 3000);
        exit();
    }
}
?>
