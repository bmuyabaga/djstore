<?php
include('../config/function.php');

if (isset($_POST['query'])) {
    $query = "%" . $_POST['query'] . "%";

    $stmt = $connect->prepare("SELECT p.product_id, p.product_name, COALESCE(cp.price, p.product_base_price) AS price, p.product_quantity 
        FROM product p 
        LEFT JOIN custom_price cp ON p.product_id = cp.product_id 
        WHERE p.product_name LIKE ?");
    $stmt->execute([$query]);

    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($products);
}
?>
