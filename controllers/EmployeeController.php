<?php
require_once __DIR__ . '/../repositories/EmployeeRepository.php';

function HandleGetEmployeesByName($conn, $name) {
    $data = GetEmployeesByNameRepo($conn, $name);
    response(200, "Employees retrieved successfully", $data);
}

function HandleCreateEmployee($conn) {
    $input = json_decode(file_get_contents('php://input'), true);

    if (empty($input['name']) || empty($input['birth_date']) || empty($input['gender']) || empty($input['position']) || empty($input['airline_id'])) {
        response(422, "Validation errors: Missing required fields");
    }

    $stmt = $conn->prepare("INSERT INTO employees (name, birth_date, gender, position, airline_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$input['name'], $input['birth_date'], $input['gender'], $input['position'], $input['airline_id']]);
    $id = $conn->lastInsertId();

    response(201, "Employee created successfully", ["id" => $id]);
}
?>