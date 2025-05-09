<?php
include ("conexion.php");

// Validamos y capturamos los datos enviados por el método POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $conexion->real_escape_string($_POST['correo']);
    $password = $conexion->real_escape_string($_POST['contrasena']);

    // Llamamos al procedimiento almacenado
    $stmt = $conexion->prepare("CALL validar_usuario(?, ?, @mensaje)");
    $stmt->bind_param("ss", $correo, $password);
    $stmt->execute();
    $stmt->close();

    // Obtenemos el mensaje devuelto por el procedimiento
    $result = $conexion->query("SELECT @mensaje AS mensaje");
    $row = $result->fetch_assoc();
    $mensaje = $row['mensaje'];

    // Si el mensaje es 'Usuario válido', iniciamos la sesión y redirigimos
    if ($mensaje == 'Usuario válido') {
        $query = "SELECT * FROM funcionario WHERE correo = '$correo' AND contrasena = '$password'";
        $validate = $conexion->query($query);

        if ($validate->num_rows > 0) {
            $row = $validate->fetch_assoc();
            session_start();
            $_SESSION['validate'] = TRUE;
            $_SESSION['name'] = $row['nombre_funcionario'];
            $_SESSION['id'] = $row['cedula'];
            $_SESSION['rol'] = $row['id_dependencia'];
            $_SESSION['id_funcionario'] = $row['id_funcionario'];
            echo "<script>
                window.location = '../html/radicado.php';
            </script>";
            exit(); // Asegúrate de que el script se detenga aquí
        }
    } else {
        // Mostramos el mensaje devuelto por el procedimiento
        echo "<script>
            alert('$mensaje');
            window.location = '../../login.php';
        </script>";
        session_destroy();
        exit(); // Asegúrate de que el script se detenga aquí
    }
}
?>






<?php
include ("conexion.php");

// Validamos y capturamos los datos enviados por el método POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validar reCAPTCHA
    $recaptchaResponse = $_POST['g-recaptcha-response'];
    $secretKey = '6LcnbIYqAAAAAFTOmQMYkbz9GUTyaFaDDBD31ZQY'; // Reemplaza con tu clave secreta de reCAPTCHA

    // Verificar la respuesta del reCAPTCHA con la API de Google
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = [
        'secret' => $secretKey,
        'response' => $recaptchaResponse,
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ],
    ];

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $response = json_decode($result, true);
    print_r($response);


    if (!$response['success']) {
        // Si el reCAPTCHA no es válido, redirigir o mostrar un error
        echo "<script>
            alert('Error: reCAPTCHA no válido. Por favor, inténtalo de nuevo.');
            window.location = '../../login.php';
        </script>";
        exit(); // Detener el script si el reCAPTCHA falla
    }

    // Validamos y capturamos los datos enviados por el método POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $conexion->real_escape_string($_POST['correo']);
    $password = $conexion->real_escape_string($_POST['contrasena']);

    // Llamamos al procedimiento almacenado
    $stmt = $conexion->prepare("CALL validar_usuario(?, ?, @mensaje)");
    $stmt->bind_param("ss", $correo, $password);
    $stmt->execute();
    $stmt->close();

    // Obtenemos el mensaje devuelto por el procedimiento
    $result = $conexion->query("SELECT @mensaje AS mensaje");
    $row = $result->fetch_assoc();
    $mensaje = $row['mensaje'];
    echo "Mensaje devuelto por SP: $mensaje";


    // Si el mensaje es 'Usuario válido', iniciamos la sesión y redirigimos
    if ($mensaje == 'Usuario válido') {
        $query = "SELECT * FROM funcionario WHERE correo = '$correo' AND contrasena = '$password'";
        $validate = $conexion->query($query);

        if ($validate->num_rows > 0) {
            $row = $validate->fetch_assoc();
            session_start();
            $_SESSION['validate'] = TRUE;
            $_SESSION['name'] = $row['nombre_funcionario'];
            $_SESSION['id'] = $row['cedula'];
            $_SESSION['rol'] = $row['id_dependencia'];
            $_SESSION['id_funcionario'] = $row['id_funcionario'];
            echo "<script>
                window.location = '../html/radicado.php';
            </script>";
            exit(); // Asegúrate de que el script se detenga aquí
        }
    } else {
        // Mostramos el mensaje devuelto por el procedimiento
        echo "<script>
            alert('$mensaje');
            window.location = '../../login.php';
        </script>";
        session_destroy();
        exit(); // Asegúrate de que el script se detenga aquí
    }
}
}
?>






validate


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

    // Depuración: imprime la respuesta de la API
    if (!$responseData['success']) {
        var_dump($responseData); // Depuración
        echo "<script>
            alert('Error: reCAPTCHA no válido. Por favor, inténtalo de nuevo.');
            window.location = '../../login.php';
        </script>";
        exit();
    }

    // Validación del usuario
    $correo = $conexion->real_escape_string($_POST['correo']);
    $password = $conexion->real_escape_string($_POST['contrasena']);

    $stmt = $conexion->prepare("CALL validar_usuario(?, ?, @mensaje)");
    $stmt->bind_param("ss", $correo, $password);
    $stmt->execute();
    $stmt->close();

    $result = $conexion->query("SELECT @mensaje AS mensaje");
    $row = $result->fetch_assoc();
    $mensaje = $row['mensaje'];

    if ($mensaje == 'Usuario válido') {
        $query = "SELECT * FROM funcionario WHERE correo = '$correo' AND contrasena = '$password'";
        $validate = $conexion->query($query);

        if ($validate->num_rows > 0) {
            $row = $validate->fetch_assoc();
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
        }
    } else {
        echo "<script>
            alert('$mensaje');
            window.location = '../../login.php';
        </script>";
        session_destroy();
        exit();
    }
}
?>









