<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "Inicio del script<br>"; // Depuración

    $token = $_POST['token'] ?? '';
    $newPasswordPlain = $_POST['password'] ?? '';

    if (empty($token) || empty($newPasswordPlain)) {
        echo "Faltan datos.";
        exit();
    }

    $passwordHashed = password_hash($newPasswordPlain, PASSWORD_BCRYPT);
    echo "Token recibido: $token<br>"; // Depuración

    // Verifica si el token es válido y no ha expirado
    $stmt = $conexion->prepare("SELECT id_funcionario FROM funcionario WHERE reset_token = ? AND reset_expiration > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        echo "Error en la consulta: " . $conexion->error;
        exit();
    }

    echo "Consulta ejecutada correctamente<br>"; // Depuración

    if ($result->num_rows > 0) {
        echo "Token válido<br>"; // Depuración

        // Actualiza la contraseña
        $stmtUpdate = $conexion->prepare("UPDATE funcionario SET contrasena = ?, reset_token = NULL, reset_expiration = NULL WHERE reset_token = ?");
        $stmtUpdate->bind_param("ss", $passwordHashed, $token);

        if ($stmtUpdate->execute()) {
            echo "<script>
                alert('Contraseña actualizada correctamente.');
                window.location = '../../login.php';
            </script>";
        } else {
            echo "Error al actualizar la contraseña: " . $stmtUpdate->error;
        }

        $stmtUpdate->close();
    } else {
        echo "El token no es válido o ha expirado<br>"; // Depuración
    }

    $stmt->close();
}
?>
