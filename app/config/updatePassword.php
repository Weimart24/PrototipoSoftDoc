<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'] ?? '';
    $newPasswordPlain = $_POST['password'] ?? '';

    if (empty($token) || empty($newPasswordPlain)) {
        header("Location: ../../forgotPassword.php?status=error&message=Faltan+datos");
        exit();
    }

    $passwordHashed = password_hash($newPasswordPlain, PASSWORD_BCRYPT);

    $stmt = $conexion->prepare("SELECT id_funcionario FROM funcionario WHERE reset_token = ? AND reset_expiration > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        header("Location: ../../forgotPassword.php?status=error&message=Error+en+la+consulta");
        exit();
    }

    if ($result->num_rows > 0) {
        $stmtUpdate = $conexion->prepare("UPDATE funcionario SET contrasena = ?, reset_token = NULL, reset_expiration = NULL WHERE reset_token = ?");
        $stmtUpdate->bind_param("ss", $passwordHashed, $token);

        if ($stmtUpdate->execute()) {
            header("Location: ../../login.php?status=success&message=Contraseña+actualizada+correctamente");
        } else {
            header("Location: ../../forgotPassword.php?status=error&message=Error+al+actualizar+la+contraseña");
        }

        $stmtUpdate->close();
    } else {
        header("Location: ../../forgotPassword.php?status=error&message=El+enlace+ha+expirado+o+ya+fue+utilizado");
    }

    $stmt->close();
}
?>
