<?php
function GetAllTransactionsRepo($conn) {
    $stmt = $conn->prepare("SELECT * FROM transactions");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function CreateFinancialTransactionRepo($conn, $type, $amount, $desc, $date, $airline_id) {
    $conn->beginTransaction(); // 1. بدء المعاملة الأمنية
    try {
        // التحقق من وجود شركة الطيران أولاً وجلب رصيدها الحالي
        $stmt = $conn->prepare("SELECT current_balance FROM airlines WHERE id = ? FOR UPDATE");
        $stmt->execute([$airline_id]);
        $airline = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$airline) {
            $conn->rollBack();
            return false;
        }

        $current_balance = $airline['current_balance'];

        // حساب الرصيد الجديد بناءً على نوع العملية (Buy خصم / Sell إضافة)
        if ($type == 'Buy') {
            $new_balance = $current_balance - $amount;
        } else {
            $new_balance = $current_balance + $amount;
        }

        // تحديث رصيد الشركة في جدول الـ airlines
        $update_stmt = $conn->prepare("UPDATE airlines SET current_balance = ? WHERE id = ?");
        $update_stmt->execute([$new_balance, $airline_id]);

        // تسجيل العملية في جدول الـ transactions
        $insert_stmt = $conn->prepare("INSERT INTO transactions (transaction_type, amount, description, date, airline_id) VALUES (?, ?, ?, ?, ?)");
        $insert_stmt->execute([$type, $amount, $desc, $date, $airline_id]);

        $conn->commit(); // 2. نجاح جميع الخطوات بالتوازي
        return true;
    } catch (Exception $e) {
        $conn->rollBack(); // 3. إلغاء التغييرات فوراً في حال حدوث خطأ
        return false;
    }
}

function GetTransactionsSummaryRepo($conn) {
    $stmt = $conn->prepare("SELECT transaction_type, SUM(amount) as total_amount, COUNT(*) as count FROM transactions GROUP BY transaction_type");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>