<?php
include('config/function.php');
if (isset($_POST['add_batch'])) {
    $received_quantity = intval($_POST['received_quantity']);
    $product_id = intval($_POST['product_id']);
    $purchase_id = intval($_POST['purchase_id']);
    $batch_number = $_POST['batch_number'];
    $expiry_date = $_POST['expiry_date'];
    $production_date = $_POST['production_date'];
    $sku = $_POST['sku'];

 
    // Update the warehouse_alerts table
    $stmt = $connect->prepare("UPDATE warehouse_alerts SET received_quantity =received_quantity +  :received_quantity WHERE product_id = :product_id AND purchase_id = :purchase_id");
    $stmt->bindParam(':received_quantity', $received_quantity);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->bindParam(':purchase_id', $purchase_id);
    $stmt->execute();

     // update purchase_item table
     $stmt_purchase_item = $connect->prepare("UPDATE purchase_item SET received_qty = received_qty + :received_qty WHERE product_id = :product_id AND purchase_id = :purchase_id");
     $stmt_purchase_item->bindParam(':received_qty', $received_quantity);
     $stmt_purchase_item->bindParam(':product_id', $product_id);
     $stmt_purchase_item->bindParam(':purchase_id', $purchase_id);
     $stmt_purchase_item->execute();

     //update status for warehouse_alerts table and purchase_item table
     // select quantity from warehouse_alerts to update status using condition
     $stmt = $connect->prepare("SELECT quantity, received_quantity FROM warehouse_alerts WHERE product_id = :product_id AND purchase_id = :purchase_id");
     $stmt->bindParam(':product_id', $product_id);
     $stmt->bindParam(':purchase_id', $purchase_id);
     $stmt->execute();
     $row = $stmt->fetch(PDO::FETCH_ASSOC);
     $quantity = $row['quantity'];
     $received_quantity_from_database = $row['received_quantity'];

     if ($received_quantity_from_database >= $quantity) {
         $statusdatabase = 'Received';
         
     } else {
         $statusdatabase = 'Partial';
     }

     // Update the warehouse_alerts table
     $stmt = $connect->prepare("UPDATE warehouse_alerts SET status = :status WHERE product_id = :product_id AND purchase_id = :purchase_id");
     $stmt->bindParam(':status', $statusdatabase);
     $stmt->bindParam(':product_id', $product_id);
     $stmt->bindParam(':purchase_id', $purchase_id);
     $result = $stmt->execute();

     //update status for purchase_item table
     $stmt_purchase_item = $connect->prepare("UPDATE purchase_item SET purchase_item_status = :purchase_item_status WHERE product_id = :product_id AND purchase_id = :purchase_id");
     $stmt_purchase_item->bindParam(':purchase_item_status', $statusdatabase);
     $stmt_purchase_item->bindParam(':product_id', $product_id);
     $stmt_purchase_item->bindParam(':purchase_id', $purchase_id);
     $stmt_purchase_item->execute();

     //update status for purchase table
     $stmt_purchase = $connect->prepare("UPDATE purchase SET receiving_status = :receiving_status WHERE purchase_id = :purchase_id");
     $stmt_purchase->bindParam(':receiving_status', $statusdatabase);
     $stmt_purchase->bindParam(':purchase_id', $purchase_id);
     $stmt_purchase->execute();

    // insert data into product_batches table

    // extract product_price from product table
    $stmt = $connect->prepare("SELECT product_base_price FROM product WHERE product_id = :product_id OR product_code = :product_code");
    $stmt->bindParam(':product_id', $product_id);
    $stmt->bindParam(':product_code', $sku);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $selling_price = $row['product_base_price'];

    //fetch product_purchase_price from purchase_item table
    $stmt = $connect->prepare("SELECT buying_price FROM purchase_item WHERE product_id = :product_id AND purchase_id = :purchase_id");
    $stmt->bindParam(':product_id', $product_id);
    $stmt->bindParam(':purchase_id', $purchase_id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $cost = $row['buying_price'];
   
    //calcualte total cost
    $total_cost = $cost * $received_quantity;

    //calcualte total selling price
    $total_revenue = $selling_price * $received_quantity;

    //calcualte profit
    $gross_profit = $total_revenue - $total_cost;

    //initialize today date variable
    $received_date = date('Y-m-d');

    $statusenable = 'Enable';
    $stmt = $connect->prepare("INSERT INTO product_batches (product_id, purchase_id,product_code,batch_number,production_date,expiry_date, stock,cost,selling_price,total_cost,total_revenue,gross_profit,received_date, batch_status) 
    VALUES (:product_id, :purchase_id,:product_code,:batch_number,:production_date,:expiry_date, :stock,:cost,:selling_price,:total_cost,:total_revenue,:gross_profit,:received_date, :batch_status)");
    $stmt->bindParam(':product_id', $product_id);
    $stmt->bindParam(':purchase_id', $purchase_id);
    $stmt->bindParam(':product_code', $sku);
    $stmt->bindParam(':batch_number', $batch_number);
    $stmt->bindParam(':production_date', $production_date);
    $stmt->bindParam(':expiry_date', $expiry_date);
    $stmt->bindParam(':stock', $received_quantity);
    $stmt->bindParam(':cost', $cost);
    $stmt->bindParam(':selling_price', $selling_price);
    $stmt->bindParam(':total_cost', $total_cost);
    $stmt->bindParam(':total_revenue', $total_revenue);
    $stmt->bindParam(':gross_profit', $gross_profit);
    $stmt->bindParam(':received_date', $received_date);
    $stmt->bindParam(':batch_status', $statusenable);
    $result = $stmt->execute();

    //update product table
    $stmt = $connect->prepare("UPDATE product SET product_quantity = product_quantity + :product_quantity WHERE product_id = :product_id OR product_code = :product_code");
    $stmt->bindParam(':product_quantity', $received_quantity);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->bindParam(':product_code', $sku);
    $result = $stmt->execute();

    if ($result) {
      
        $_SESSION['success'] = "Product received successfully!";
        header("Location: product_receiving.php?pid=" . $product_id . "&purchaseId=" . $purchase_id . "&sku=" . $sku);
        exit();
    } else {
      
        $_SESSION['error'] = "Failed to receive product!";
        header("Location: product_receiving.php?pid=" . $product_id . "&purchaseId=" . $purchase_id . "&sku=" . $sku);
        exit();
    }
    
    
}



?>