<?php
function GetAllAirlinesRepo($conn) {
    $stmt = $conn->prepare("SELECT * FROM airlines");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function GetAirlineByIdRepo($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM airlines WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function GetAirlineByNameRepo($conn, $name) {
    $stmt = $conn->prepare("SELECT * FROM airlines WHERE name LIKE ?");
    $stmt->execute(["%$name%"]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function CreateAirlineRepo($conn, $name, $address, $contact, $phone, $balance) {
    $stmt = $conn->prepare("INSERT INTO airlines (name, address, contact_person, phone_number, current_balance) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $address, $contact, $phone, $balance]);
    return $conn->lastInsertId();
}

function UpdateAirlineRepo($conn, $id, $name, $address, $contact, $phone) {
    $stmt = $conn->prepare("UPDATE airlines SET name = ?, address = ?, contact_person = ?, phone_number = ? WHERE id = ?");
    return $stmt->execute([$name, $address, $contact, $phone, $id]);
}

function DeleteAirlineRepo($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM airlines WHERE id = ?");
    return $stmt->execute([$id]);
}
?>