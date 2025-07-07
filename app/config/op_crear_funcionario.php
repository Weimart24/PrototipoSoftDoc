<?php
session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['name'])) {
    header("Location: ../../../login.php");
    exit();
}
include_once("conexion.php");
include_once("alerta.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo = $_POST['tipo'];
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $correo = $_POST['correo'];
    $dependencia = $_POST['dependencia'];
    $roles = $_POST['roles'];

    // Encriptar la contraseña
    $contrasenaHash = password_hash($cedula, PASSWORD_BCRYPT);

    // Validar cédula
    $cedulaDuplicada = false;
    $correoDuplicado = false;

    $queryCedula = "SELECT id_funcionario FROM funcionario WHERE cedula = ?";
    $stmtCedula = $conexion->prepare($queryCedula);
    $stmtCedula->bind_param("s", $cedula);
    $stmtCedula->execute();
    $stmtCedula->store_result();
    if ($stmtCedula->num_rows > 0) {
        $cedulaDuplicada = true;
    }
    $stmtCedula->close();

    // Validar correo
    $queryCorreo = "SELECT id_funcionario FROM funcionario WHERE correo = ?";
    $stmtCorreo = $conexion->prepare($queryCorreo);
    $stmtCorreo->bind_param("s", $correo);
    $stmtCorreo->execute();
    $stmtCorreo->store_result();
    if ($stmtCorreo->num_rows > 0) {
        $correoDuplicado = true;
    }
    $stmtCorreo->close();

    if ($cedulaDuplicada || $correoDuplicado) {
        $mensaje = "No se puede crear el funcionario porque ya existe ";

        if ($cedulaDuplicada && $correoDuplicado) {
            $mensaje .= "la cédula ($cedula) y el correo ($correo) registrados.";
        } elseif ($cedulaDuplicada) {
            $mensaje .= "la cédula ($cedula) registrada.";
        } elseif ($correoDuplicado) {
            $mensaje .= "el correo ($correo) registrado.";
        }

        $conexion->close();
        mostrarAlerta('warning', 'Duplicado', $mensaje, null, null);
        exit();
    }

    // Insertar funcionario
    $query = "INSERT INTO funcionario (tipo_documento, cedula, nombre_funcionario, correo, contrasena, telefono, direccion, id_dependencia)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($query);

    if ($stmt) {
        $stmt->bind_param("ssssssss", $tipo, $cedula, $nombre, $correo, $contrasenaHash, $telefono, $direccion, $dependencia);

        if ($stmt->execute()) {
            $id_funcionario = $stmt->insert_id ?: $conexion->insert_id;
            $stmt->close();

            // Insertar rol
            $queryRol = "INSERT INTO funcionario_roles (id_funcionario, id_rol) VALUES (?, ?)";
            $stmtRol = $conexion->prepare($queryRol);

            if ($stmtRol) {
                $stmtRol->bind_param("ii", $id_funcionario, $roles);
                if ($stmtRol->execute()) {
                    $stmtRol->close();
                    $conexion->close();
                    mostrarAlerta('success', '¡Éxito!', 'FUNCIONARIO CREADO CORRECTAMENTE', '../html/funcionario.php', 2500);
                    exit();
                } else {
                    mostrarAlerta('error', 'Error', 'Error al crear el rol: ' . $stmtRol->error);
                }
            } else {
                mostrarAlerta('error', 'Error', 'Error al preparar el rol: ' . $conexion->error);
            }
        } else {
            mostrarAlerta('error', 'Error', 'Error al crear el funcionario: ' . $stmt->error);
        }

        $stmt->close();
    } else {
        mostrarAlerta('error', 'Error', 'Error al preparar el insert del funcionario: ' . $conexion->error);
    }

    $conexion->close();
}
?>
