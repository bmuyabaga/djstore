<?php
include('../config/function.php');

if (isset($_POST['barcode'])) {
    $barcode = $_POST['barcode'];

    $stmt = $connect->prepare("SELECT p.product_id, p.product_name, 
        COALESCE(cp.price, p.product_base_price) AS price, p.product_quantity 
        FROM product p 
        LEFT JOIN custom_price cp ON p.product_id = cp.product_id 
        WHERE p.barcode = ?");
    $stmt->execute([$barcode]);

    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        echo json_encode($product);
    } else {
        echo json_encode(["error" => "Product not found"]);
    }
}


?>
