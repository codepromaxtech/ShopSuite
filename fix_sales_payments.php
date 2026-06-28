<?php
$mysqli = new mysqli("localhost", "shopsuite", "shopsuite@2024", "shopsuite");

// Get all sales that don't have payments
$query = "SELECT s.sale_id, SUM(si.quantity_purchased * (si.item_unit_price - si.discount)) as total FROM shopsuite_sales s JOIN shopsuite_sales_items si ON s.sale_id = si.sale_id WHERE s.sale_id NOT IN (SELECT sale_id FROM shopsuite_sales_payments) GROUP BY s.sale_id";
$result = $mysqli->query($query);

while ($row = $result->fetch_assoc()) {
    $sale_id = $row['sale_id'];
    $total = $row['total'];
    $stmt = $mysqli->prepare("INSERT INTO shopsuite_sales_payments (sale_id, payment_type, payment_amount, cash_refund, cash_adjustment, employee_id) VALUES (?, 'Cash', ?, 0, 0, 1)");
    $stmt->bind_param("id", $sale_id, $total);
    if ($stmt->execute()) {
        echo "Fixed sale $sale_id\n";
    } else {
        echo "Error: " . $stmt->error . "\n";
    }
}
$mysqli->close();
