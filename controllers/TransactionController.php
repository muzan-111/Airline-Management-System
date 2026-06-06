<?php
require_once __DIR__ . '/../repositories/TransactionRepository.php';

function HandleGetAllTransactions($conn) {
    $data = GetAllTransactionsRepo($conn);
    response(200, "Transactions retrieved successfully", $data);
}

function HandleCreateTransaction($conn) {
    $input = json_decode(file_get_contents('php://input'), true);

    if (empty($input['transaction_type']) || empty($input['amount']) || empty($input['airline_id'])) {
        response(422, "Validation errors: Missing transaction type, amount, or airline_id");
    }

    $desc = $input['description'] ?? '';
    $date = date('Y-m-d H:i:s');

    $success = CreateFinancialTransactionRepo($conn, $input['transaction_type'], $input['amount'], $desc, $date, $input['airline_id']);
    
    if ($success) {
        response(201, "Transaction completed and balance updated successfully");
    } else {
        response(400, "Transaction failed: Check airline ID or parameters");
    }
}

function HandleGetTransactionsSummary($conn) {
    $data = GetTransactionsSummaryRepo($conn);
    response(200, "Transactions summary report generated", $data);
}
?>