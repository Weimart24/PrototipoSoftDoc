<?php
// conexión.php

$host = "127.0.0.1";
$usuario = "root";
$contrasenia = "";
$bd = "prototipo3";

// Activar modo estricto para MySQLi (buena práctica)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conexion = new mysqli($host, $usuario, $contrasenia, $bd);
    $conexion->set_charset("utf8mb4"); // Evita problemas con caracteres especiales

    // Ya no se necesita verificar con if, porque el try/catch lo captura
} catch (mysqli_sql_exception $e) {
    error_log("Error de conexión a BD: " . $e->getMessage()); // Guarda el error en el log del servidor
    die("No se pudo conectar a la base de datos."); // Mensaje general al usuario (sin detalles sensibles)
}
?>
