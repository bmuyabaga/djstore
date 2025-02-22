<?php

include('../../config/function.php');

//if(isset($_POST['addstockdata']))
//{


$purchasedate = $_POST['pdate'];

$purchaseID = $_POST['ppid'];
$totalPurchase = $_POST['tvalue'];
$product_id = $_POST['pname'];
$qtyproduced = $_POST['pqty'];
//$product_code = $_POST['pcode'];
$product_estimated_price = '';
$product_name = '';




  
  $query1 = "
  SELECT * FROM product 
  WHERE product_code = ".$_POST['pname']." 
  ORDER BY product_name ASC
  ";
  $statement = $connect->prepare($query1);
  $statement->execute();
  $result = $statement->fetchAll();
  $output = '';
  foreach($result as $row)
  {
     $product_estimated_price = $row['product_base_price'];
     $product_name = $row['product_name'];
  }





$query2 = "
		INSERT INTO stockin (purchase_id, product_code, product_name, qty,stockin_date, user_id, branch_id,	product_status) 
		VALUES (:purchase_id, :product_code, :product_name, :qty, :stockin_date, :user_id, :branch_id, :product_status)
		";
		$statement = $connect->prepare($query2);
		$statement->execute(
			array(
				':purchase_id'	=>	$_POST['ppid'],
				
				':product_code'	=>	$_POST['pname'],
				':product_name'	=>	$product_name,
				':qty'	=>	$_POST["pqty"],
				':stockin_date'	=>	date("Y-m-d"),
				':user_id'	=> $_SESSION["user_id"],
				':branch_id'	=>	1,
				':product_status'    => 'active'
			)
		);
		$result = $statement->fetchAll();




		$query3 = "
		INSERT INTO statistics (purchase_id, product_code, user_id,purchase_date, qty_produced,buying_price_per_each, selling_price_per_each, total_cost,	total_revenue,	Gross_profit) 
		VALUES (:purchase_id, :product_code, :user_id, :purchase_date, :qty_produced, :buying_price_per_each, :selling_price_per_each, :total_cost, :total_revenue, :Gross_profit)
		";

       
$buying_price_per_each = $totalPurchase / $qtyproduced;
$total_revenue = $product_estimated_price * $qtyproduced;
$Gross_profit = ($total_revenue-$totalPurchase);

		$statement = $connect->prepare($query3);
		$statement->execute(
			array(
				':purchase_id'	=>	$_POST['ppid'],
				
				':product_code'	=>	$_POST['pname'],
				':user_id'	=>	$_SESSION["user_id"],
				':purchase_date'	=>	$_POST['pdate'],
				':qty_produced'	=>	$_POST["pqty"],
				':buying_price_per_each'	=>	$buying_price_per_each,
				':selling_price_per_each'	=> $product_estimated_price,
				':total_cost'	=>	$_POST['tvalue'],
				':total_revenue'	=>	$total_revenue,
				':Gross_profit'    => $Gross_profit
			)
		);
		$result = $statement->fetchAll();
	

$query4 = "
		UPDATE product SET 
		product_quantity = product_quantity + '".$_POST['pqty']."'
	
		WHERE product_code = '".$_POST['pname']."'
		";
		$statement = $connect->prepare($query4);
		$statement->execute();
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Stock Added';
		}
	

	//header('location:../purchase.php');

//}



?>