<?php
$host = "localhost";
$user = "root";
$pass = "";
$database = "airline_db";

try {
    $connection = new PDO("mysql:host=$host;dbname=$database", $user, $pass);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $err) {
    header("Content-Type: application/json");
    http_response_code(500);
    echo json_encode(["message" => "Database connection failed: " . $err->getMessage()]);
    exit();
}
?>