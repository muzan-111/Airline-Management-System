<?php
function GetEmployeesByNameRepo($conn, $name) {
    $stmt = $conn->prepare("SELECT * FROM employees WHERE name LIKE ?");
    $stmt->execute(["%$name%"]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>