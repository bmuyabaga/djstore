<?php

//order_action.php

include('../../config/function.php');
    // Get POST data
$product_id = $_POST['product_id'];
$purchase_id = $_POST['purchase_id'];
$quantity = $_POST['quantity'];
$date = $_POST['date'];
$user_id = $_POST['user_id'];

// Insert into stocking table
$sql = "INSERT INTO stocking (product_code,product_id, purchase_id, qty, stockin_date, user_id) 
        VALUES (:product_code, :product_id, :purchase_id, :qty, :stockin_date, :user_id, :branch_id, :stocking_status)";
$statement = $connect->prepare($sql);
$statement->execute(
    array(
        ':product_code'	=>	$_POST['product_code'],
        ':product_id'	=>	$_POST['product_id'],
        ':purchase_id'	=>	$_POST['purchase_id'],
        ':qty'	=>	$_POST['quantity'],
        ':stockin_date'	=>	$_POST['date'],
        ':user_id'	=>	$_SESSION["user_id"],
        ':branch_id'	=>	1,
        ':stocking_status'    => 'active'
    )
);
$result = $statement->fetchAll();
if(isset($result))
{
    echo 'Stocking Added Successfully';
}

?>