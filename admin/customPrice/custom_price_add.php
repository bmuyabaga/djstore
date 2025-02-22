<?php

include('../../config/function.php');

$cid = $_POST["clientid_custom"];

if(isset($_POST['addcustom']))
{
  $productID = '';
  $query ="SELECT * FROM product WHERE product_code='".$_POST['product_codecustom']."'  "; 
  $statement = $connect->prepare($query);
  $statement->execute();
  $result1 = $statement->fetchAll();

foreach($result1 as $row)
{
	$productID = $row['product_id'];
}

$querycustom = " INSERT INTO custom_price (client_id,user_id,product_id,product_code,price,description,status,branch_id)
                 VALUES (:client_id,:user_id,:product_id,:product_code,:price,:description,:status,:branch_id)

";

		$statement = $connect->prepare($querycustom);
		$statement->execute(
			array(
				':client_id'	=>	$_POST["clientid_custom"],
				
				':user_id'	=>	$_SESSION['user_id'],
				':product_id'	=>	$productID,
				':product_code'	=>	$_POST["product_codecustom"],
				':price'	=>	$_POST["pricecustom"],
				':description'	=>	$_POST["paymentNotescustom"],
				':status'    => 'active',
				':branch_id'    => 1
			)
		);
		$result = $statement->fetchAll();

}








	


echo "<script>document.location='../client_details.php?view=$cid'</script>"; 


?>