<?php
try {
    require_once __DIR__ . '/config/db_connection.php';
    require_once __DIR__ . '/routes/api.php';
} catch (Exception $e) {
    header("Content-Type: application/json");
    http_response_code(500);
    echo json_encode(["message" => "Critical Server Error: " . $e->getMessage()]);
}
?>