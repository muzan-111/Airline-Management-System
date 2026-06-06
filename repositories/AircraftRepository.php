<?php
function GetAllAircraftRepo($conn) {
    $stmt = $conn->prepare("SELECT a.*, al.name AS airline_name FROM aircraft AS a JOIN airlines AS al ON a.airline_id = al.id");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function CreateAircraftRepo($conn, $model, $capacity, $airline_id) {
    $stmt = $conn->prepare("INSERT INTO aircraft (model, capacity, airline_id) VALUES (?, ?, ?)");
    $stmt->execute([$model, $capacity, $airline_id]);
    return $conn->lastInsertId();
}
?>