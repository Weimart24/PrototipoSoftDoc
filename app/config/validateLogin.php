<?php
include("conexion.php");
include("alerta.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validamos el reCAPTCHA
    $recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';

    if (empty($recaptchaResponse)) {
        mostrarAlerta('error', 'Error', 'Debes completar el reCAPTCHA.', '', 3000);
        exit();
    }

    $secretKey = '6LdDNDMrAAAAABF-e6071m1r7cFEdmCHY4mx-6rH';
    $response = file_get_contents(
        "https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaResponse}"
    );
    $responseData = json_decode($response, true);

    if (!$responseData['success']) {
        mostrarAlerta('error', 'Error', 'reCAPTCHA no válido. Por favor, inténtalo de nuevo.', '', 3000);
        exit();
    }

    // Validación del usuario
    $correo = $conexion->real_escape_string($_POST['correo']);
    $password = $_POST['contrasena'];

    // Buscar usuario por correo
    $stmt = $conexion->prepare("SELECT * FROM funcionario WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verificar si está activo
        if ($row['activo'] != 1) {
            mostrarAlerta('warning', 'Acceso denegado', 'Su usuario está inactivo. Por favor, comuníquese con el administrador.', '', 4000);
            exit();
        }

        $hashedPassword = $row['contrasena'];

        // Verificar contraseña
        if (strpos($hashedPassword, '$2y$') === 0) {
            $passwordCorrecta = password_verify($password, $hashedPassword);
        } else {
            $passwordCorrecta = ($password === $hashedPassword);
        }

        if ($passwordCorrecta) {
            $estaUsandoContrasenaInicial = false;
            if (strpos($hashedPassword, '$2y$') === 0) {
                $estaUsandoContrasenaInicial = password_verify($row['cedula'], $hashedPassword);
            } else {
                $estaUsandoContrasenaInicial = ($password === $row['cedula']);
            }

            session_start();
            $_SESSION['validate'] = TRUE;
            $_SESSION['name'] = $row['nombre_funcionario'];
            $_SESSION['id'] = $row['id_funcionario'];

            $id_funcionario = $row['id_funcionario'];
            $sql = "SELECT p.id_permiso
                    FROM permisos p
                    JOIN rol_permisos rp ON p.id_permiso = rp.id_permiso
                    JOIN funcionario_roles fr ON rp.id_rol = fr.id_rol
                    WHERE fr.id_funcionario = ?";
            $stmtPerm = $conexion->prepare($sql);
            $stmtPerm->bind_param("i", $id_funcionario);
            $stmtPerm->execute();
            $resultPerm = $stmtPerm->get_result();

            $permisos = [];
            while ($perm = $resultPerm->fetch_assoc()) {
                $permisos[] = $perm['id_permiso'];
            }
            $_SESSION['permisos'] = $permisos;

            if ($estaUsandoContrasenaInicial) {
                mostrarAlerta('info', 'Cambio requerido', 'Por seguridad, debe cambiar su contraseña.', '../html/cambiar_contrasena.php', 3000);
            } else {
                mostrarAlerta('success', '¡Bienvenido!', $_SESSION['name'], '../html/radicado.php', 3000);
            }

            exit();
        } else {
            mostrarAlerta('error', '¡Error!', 'Contraseña incorrecta.', '', 3000);
            exit();
        }
    } else {
        mostrarAlerta('error', '¡Error!', 'Usuario no encontrado.', '', 3000);
        exit();
    }
}
?>
