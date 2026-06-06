<?php
require_once __DIR__ . '/../repositories/AirlineRepository.php';

function HandleGetAllAirlines($conn) {
    $data = GetAllAirlinesRepo($conn);
    response(200, "Airlines retrieved successfully", $data);
}

function HandleGetAirlineById($conn, $id) {
    $data = GetAirlineByIdRepo($conn, $id);
    if (!$data) {
        response(404, "Airline not found");
    }
    response(200, "Airline retrieved successfully", $data);
}

function HandleGetAirlineByName($conn, $name) {
    $data = GetAirlineByNameRepo($conn, $name);
    response(200, "Airlines filtering completed", $data);
}

function HandleCreateAirline($conn) {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (empty($input['name']) || empty($input['address']) || empty($input['contact_person']) || empty($input['phone_number'])) {
        response(422, "Validation errors: Missing required fields");
    }

    $balance = $input['current_balance'] ?? 0.00;
    $id = CreateAirlineRepo($conn, $input['name'], $input['address'], $input['contact_person'], $input['phone_number'], $balance);
    
    response(201, "Airline created successfully", ["id" => $id]);
}

function HandleUpdateAirline($conn, $id) {
    $airline = GetAirlineByIdRepo($conn, $id);
    if (!$airline) {
        response(404, "Airline not found to update");
    }

    $input = json_decode(file_get_contents('php://input'), true);
    $name = $input['name'] ?? $airline['name'];
    $address = $input['address'] ?? $airline['address'];
    $contact = $input['contact_person'] ?? $airline['contact_person'];
    $phone = $input['phone_number'] ?? $airline['phone_number'];

    UpdateAirlineRepo($conn, $id, $name, $address, $contact, $phone);
    response(200, "Airline updated successfully");
}

function HandleDeleteAirline($conn, $id) {
    $airline = GetAirlineByIdRepo($conn, $id);
    if (!$airline) {
        response(404, "Airline not found to delete");
    }
    DeleteAirlineRepo($conn, $id);
    response(200, "Airline permanently deleted");
}
?>