<?php
session_start();
header('Content-Type: application/json');

// Verifica si el usuario está autenticado correctamente
if (!isset($_SESSION['id'])) {
    echo json_encode([
        'error' => 'Usuario no autenticado',
        'session' => $_SESSION // Útil para depuración
    ]);
    exit;
}

// Conexión a la base de datos
require_once 'conexion.php';

$user_id = $_SESSION['id']; // ID del funcionario autenticado
$notifications = [];

try {
    // Consulta: radicados asignados al funcionario, activos y no vistos
    $query = "
        SELECT r.id_radicado, r.radicado, r.asunto, r.fecha_radicado 
        FROM radicacion r
        WHERE r.id_funcionario = ? AND r.activo = 1 AND r.estado_visto = 0
        ORDER BY r.fecha_radicado DESC
    ";
    
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Construye la lista de notificaciones
    while ($row = $result->fetch_assoc()) {
        $notifications[] = [
            'message' => "Nuevo radicado: {$row['radicado']} - {$row['asunto']}",
            'time' => $row['fecha_radicado'],
            'radicado' => $row['id_radicado']
        ];
    }

    // Marca los radicados como vistos
    if (!empty($notifications)) {
        // Se marca como visto los radicados ya consultados
        $ids = array_map(function($notification) {
            return $notification['radicado'];
        }, $notifications);
        
        $ids_imploded = implode(',', $ids);
        $update_query = "UPDATE radicacion SET estado_visto = 1 WHERE id_radicado IN ($ids_imploded)";
        $conexion->query($update_query);
    }

    $stmt->close();

    // Devuelve los resultados (array vacío o con notificaciones)
    echo json_encode($notifications);

} catch (Exception $e) {
    echo json_encode(['error' => 'Error al obtener notificaciones: ' . $e->getMessage()]);
}
?>
