<?php
function GetAllTransactionsRepo($conn) {
    $stmt = $conn->prepare("SELECT * FROM transactions");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function CreateFinancialTransactionRepo($conn, $type, $amount, $desc, $date, $airline_id) {
    $conn->beginTransaction();
    try {
        $stmt = $conn->prepare("SELECT current_balance FROM airlines WHERE id = ? FOR UPDATE");
        $stmt->execute([$airline_id]);
        $airline = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$airline) {
            $conn->rollBack();
            return false;
        }

        $current_balance = $airline['current_balance'];

        if ($type == 'Buy') {
            $new_balance = $current_balance - $amount;
        } else {
            $new_balance = $current_balance + $amount;
        }

        $update_stmt = $conn->prepare("UPDATE airlines SET current_balance = ? WHERE id = ?");
        $update_stmt->execute([$new_balance, $airline_id]);

        $insert_stmt = $conn->prepare("INSERT INTO transactions (transaction_type, amount, description, date, airline_id) VALUES (?, ?, ?, ?, ?)");
        $insert_stmt->execute([$type, $amount, $desc, $date, $airline_id]);

        $conn->commit();
        return true;
    } catch (Exception $e) {
        $conn->rollBack(); 
        return false;
    }
}

function GetTransactionsSummaryRepo($conn) {
    $stmt = $conn->prepare("SELECT transaction_type, SUM(amount) as total_amount, COUNT(*) as count FROM transactions GROUP BY transaction_type");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>