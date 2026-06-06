<?php
function GetAllRoutesRepo($conn) {
    $stmt = $conn->prepare("SELECT * FROM routes");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function CreateRouteRepo($conn, $origin, $destination, $distance, $classification) {
    $stmt = $conn->prepare("INSERT INTO routes (origin, destination, distance, classification) VALUES (?, ?, ?, ?)");
    $stmt->execute([$origin, $destination, $distance, $classification]);
    return $conn->lastInsertId();
}

function AssignRouteRepo($conn, $aircraft_id, $route_id, $departure, $arrival, $passengers, $price) {
    $stmt = $conn->prepare("INSERT INTO aircraft_routes (aircraft_id, route_id, departure_time, arrival_time, passengers_count, ticket_price) VALUES (?, ?, ?, ?, ?, ?)");
    return $stmt->execute([$aircraft_id, $route_id, $departure, $arrival, $passengers, $price]);
}
?>