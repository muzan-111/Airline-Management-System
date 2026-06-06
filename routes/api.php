<?php
require_once __DIR__ . '/../helper/utility.php';
require_once __DIR__ . '/../controllers/AirlineController.php';
require_once __DIR__ . '/../controllers/EmployeeController.php';
require_once __DIR__ . '/../controllers/AircraftController.php';
require_once __DIR__ . '/../controllers/RouteController.php';
require_once __DIR__ . '/../controllers/TransactionController.php';

$method = $_SERVER["REQUEST_METHOD"];
$path = $_SERVER["PATH_INFO"] ?? '/';

if ($path == '/airlines') {
    if ($method == 'GET') {
        if (isset($_GET['name'])) {
            HandleGetAirlineByName($connection, $_GET['name']);
        } elseif (isset($_GET['id'])) {
            HandleGetAirlineById($connection, $_GET['id']);
        } else {
            HandleGetAllAirlines($connection);
        }
    } elseif ($method == 'POST') {
        HandleCreateAirline($connection);
    } elseif ($method == 'PATCH' && isset($_GET['id'])) {
        HandleUpdateAirline($connection, $_GET['id']);
    } elseif ($method == 'DELETE' && isset($_GET['id'])) {
        HandleDeleteAirline($connection, $_GET['id']);
    }
}
elseif ($path == '/employees') {
    if ($method == 'GET' && isset($_GET['name'])) {
        HandleGetEmployeesByName($connection, $_GET['name']);
    } elseif ($method == 'POST') {
        HandleCreateEmployee($connection);
    }
}
elseif ($path == '/aircraft') {
    if ($method == 'GET') {
        HandleGetAllAircraft($connection);
    } elseif ($method == 'POST') {
        HandleCreateAircraft($connection);
    }
}
elseif ($path == '/routes') {
    if ($method == 'GET') {
        HandleGetAllRoutes($connection);
    } elseif ($method == 'POST') {
        HandleCreateRoute($connection);
    }
} 
elseif ($path == '/assign-route') {
    if ($method == 'POST') {
        HandleAssignRoute($connection);
    } else {
        response(405, "Method Not Allowed");
    }
}
elseif ($path == '/transactions') {
    if ($method == 'GET') {
        HandleGetAllTransactions($connection);
    } elseif ($method == 'POST') {
        HandleCreateTransaction($connection);
    }
} 
elseif ($path == '/transactions/summary' && $method == 'GET') {
    HandleGetTransactionsSummary($connection);
}
else {
    response(404, "Endpoint not found");
}
?>