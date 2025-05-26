<?php
// conexión.php

require_once 'config.php'; // Aquí se carga la función cargarEnv()
cargarEnv(__DIR__ . '/../../.env'); // Carga el archivo .env

$host = $_ENV['DB_HOST'];
$usuario = $_ENV['DB_USER'];
$contrasenia = $_ENV['DB_PASS'];
$bd = $_ENV['DB_NAME'];


// Activar modo estricto para MySQLi
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conexion = new mysqli($host, $usuario, $contrasenia, $bd);
    $conexion->set_charset("utf8mb4"); // Evita problemas con caracteres especiales

    // Verifica si la conexión fue exitosa
} catch (mysqli_sql_exception $e) {
    error_log("Error de conexión a BD: " . $e->getMessage()); // Guarda el error en el log del servidor
    die("No se pudo conectar a la base de datos."); // Mensaje general al usuario
}
?>
