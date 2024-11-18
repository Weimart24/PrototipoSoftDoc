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