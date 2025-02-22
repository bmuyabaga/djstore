<?php
include('../config/function.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cart = $_POST['cart']; // Expecting an array of products

    $connect->beginTransaction();

    try {
        // Insert into sales table
        $stmt = $connect->prepare("INSERT INTO sales (total_amount) VALUES (0)");
        $stmt->execute();
        $sale_id = $connect->lastInsertId();

        $total = 0;

        // Insert into sales_items
        foreach ($cart as $item) {
            $stmt = $connect->prepare("INSERT INTO sales_items (sale_id, product_id, quantity, price, subtotal) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$sale_id, $item['id'], $item['qty'], $item['price'], $item['subtotal']]);
            
            $total += $item['subtotal'];

            // Deduct from stock
            $stmt = $connect->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
            $stmt->execute([$item['qty'], $item['id']]);
        }

        // Update total in sales table
        $stmt = $connect->prepare("UPDATE sales SET total_amount = ? WHERE id = ?");
        $stmt->execute([$total, $sale_id]);

        $connect->commit();
        echo json_encode(["success" => "Sale completed"]);
    } catch (Exception $e) {
        $connect->rollBack();
        echo json_encode(["error" => "Transaction failed: " . $e->getMessage()]);
    }
}
?>
