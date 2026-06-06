<?php
require_once __DIR__ . '/../repositories/RouteRepository.php';

function HandleGetAllRoutes($conn) {
    $data = GetAllRoutesRepo($conn);
    response(200, "Routes retrieved successfully", $data);
}

function HandleCreateRoute($conn) {
    $input = json_decode(file_get_contents('php://input'), true);

    if (empty($input['origin']) || empty($input['destination']) || empty($input['distance']) || empty($input['classification'])) {
        response(422, "Validation errors: Missing required route fields");
    }

    $id = CreateRouteRepo($conn, $input['origin'], $input['destination'], $input['distance'], $input['classification']);
    response(201, "Route created successfully", ["id" => $id]);
}

function HandleAssignRoute($conn) {
    $input = json_decode(file_get_contents('php://input'), true);

    if (empty($input['aircraft_id']) || empty($input['route_id']) || empty($input['departure_time']) || empty($input['arrival_time']) || empty($input['ticket_price'])) {
        response(422, "Validation errors: Missing required fields for assignment");
    }

    $passengers = $input['passengers_count'] ?? 0;

    $success = AssignRouteRepo($conn, $input['aircraft_id'], $input['route_id'], $input['departure_time'], $input['arrival_time'], $passengers, $input['ticket_price']);
    
    if ($success) {
        response(201, "Aircraft assigned to route successfully");
    } else {
        response(400, "Failed to assign aircraft to route");
    }
}
?>