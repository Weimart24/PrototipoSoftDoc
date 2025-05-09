<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// URL base del sistema
$baseUrl = "http://localhost:8081"; // Cambia a "https://tudominio.com" en producción

require '../../PHPMailer/src/Exception.php';
require '../../PHPMailer/src/PHPMailer.php';
require '../../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include("conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $conexion->real_escape_string($_POST['email']);

    // Verifica si el correo existe en la base de datos
    $query = "SELECT * FROM funcionario WHERE correo = '$email'";
    $result = $conexion->query($query);

    if ($result->num_rows > 0) {
        // Genera un token único
        $token = bin2hex(random_bytes(50));

        // Guarda el token en la base de datos
        $query = "UPDATE funcionario SET reset_token = '$token', reset_expiration = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE correo = '$email'";
        $conexion->query($query);

        // Enlace de restablecimiento usando la URL base
        $resetLink = "$baseUrl/resetPassword.php?token=$token";

        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'ventanilaunicaabs@gmail.com';
            $mail->Password = 'cjgd dcki imrz asgl';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Configuración del correo
            $mail->setFrom('tu_correo@gmail.com', 'SoftDoc');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Restablecer Contraseña';
            $mail->Body = "Haz clic en el siguiente enlace para restablecer tu contraseña: <a href='$resetLink'>$resetLink</a>";

            $mail->send();
            echo "<script>
                alert('Se ha enviado un enlace de restablecimiento a tu correo.');
                window.location = '../../login.php';
            </script>";
        } catch (Exception $e) {
            echo "<script>
                alert('Error al enviar el correo: {$mail->ErrorInfo}');
                window.location = '../../forgotPassword.php';
            </script>";
        }
    } else {
        echo "<script>
            alert('El correo no está registrado.');
            window.location = '../../forgotPassword.php';
        </script>";
    }
}
?>
