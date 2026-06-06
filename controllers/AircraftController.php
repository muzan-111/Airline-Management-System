<?php
require_once __DIR__ . '/../repositories/AircraftRepository.php';

function HandleGetAllAircraft($conn) {
    $data = GetAllAircraftRepo($conn);
    response(200, "Aircraft list retrieved successfully", $data);
}

function HandleCreateAircraft($conn) {
    $input = json_decode(file_get_contents('php://input'), true);

    if (empty($input['model']) || empty($input['capacity']) || empty($input['airline_id'])) {
        response(422, "Validation errors: Missing aircraft model, capacity, or airline_id");
    }

    $id = CreateAircraftRepo($conn, $input['model'], $input['capacity'], $input['airline_id']);
    response(201, "Aircraft registered successfully", ["id" => $id]);
}
?>