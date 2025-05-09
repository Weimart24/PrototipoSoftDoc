<?php
include("conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validamos el reCAPTCHA
    $recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';

    if (empty($recaptchaResponse)) {
        echo "<script>
            alert('Debes completar el reCAPTCHA.');
            window.location = '../../login.php';
        </script>";
        exit();
    }

    $secretKey = '6LdDNDMrAAAAABF-e6071m1r7cFEdmCHY4mx-6rH'; // Clave secreta
    $response = file_get_contents(
        "https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaResponse}"
    );
    $responseData = json_decode($response, true);

    if (!$responseData['success']) {
        echo "<script>
            alert('Error: reCAPTCHA no válido. Por favor, inténtalo de nuevo.');
            window.location = '../../login.php';
        </script>";
        exit();
    }

    // Validación del usuario
    $correo = $conexion->real_escape_string($_POST['correo']);
    $password = $_POST['contrasena'];

    // Verificamos si existe el usuario
    $stmt = $conexion->prepare("SELECT * FROM funcionario WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['contrasena'];

        // Verificamos si la contraseña está encriptada
        if (strpos($hashedPassword, '$2y$') === 0) {
            $passwordCorrecta = password_verify($password, $hashedPassword);
        } else {
            $passwordCorrecta = ($password === $hashedPassword);
        }

        if ($passwordCorrecta) {
            session_start();
            $_SESSION['validate'] = TRUE;
            $_SESSION['name'] = $row['nombre_funcionario'];
            $_SESSION['id'] = $row['cedula'];
            $_SESSION['rol'] = $row['id_dependencia'];
            $_SESSION['id_funcionario'] = $row['id_funcionario'];
            echo "<script>
                window.location = '../html/radicado.php';
            </script>";
            exit();
        } else {
            echo "<script>
                alert('Usuario o contraseña incorrectos.');
                window.location = '../../login.php';
            </script>";
            exit();
        }
    } else {
        echo "<script>
            alert('Usuario no encontrado.');
            window.location = '../../login.php';
        </script>";
        exit();
    }
}
?>
