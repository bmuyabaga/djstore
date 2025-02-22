<?php 

include('../../config/function.php');


 	$discount = $_POST['discount'];

 	$grandtotal = $_POST['amount_due'];

	
	date_default_timezone_set("Africa/Dar_es_Salaam"); 
 	
 	$cid=$_REQUEST['cid'];

	
 	$total=$_POST['total'];
 	






$output = array();

 $query = "
    INSERT INTO customer_order (client_id, user_id, order_date, total, discount, grandtotal, pay, balance, payment_type, status,branch_id)
    VALUES (:client_id, :user_id, :order_date, :total, :discount, :grandtotal, :pay, :balance, :payment_type, :status,:branch_id)

 ";


      $statement = $connect->prepare($query);
		$statement->execute(
			array(
				':client_id'	=>	$cid,
				':user_id'		=>	$_SESSION["user_id"],
				':order_date'		=>	date("Y-m-d"),
					':total'     => $_POST['total'],
						':discount'    =>  $_POST['discount'],
						':grandtotal'    =>  $_POST['amount_due'],
						':pay'      => 0,
				':balance'			=> $_POST['amount_due'],
				':payment_type'			=>	'Not Delivered',
				':status'		=>	'active',
				':branch_id'		=>	1
			)
				
		);

	$result = $statement->fetchAll();

// 	$queryclient = "
//  UPDATE client SET total_outstanding = total_outstanding + '".$_POST['amount_due']."'
//  WHERE client_id = '".$_POST['cid']."'

// ";

// $statementD = $connect->prepare($queryclient);
// 		$result = $statementD->execute();
// 		$result=$statementD->fetchAll();

	$statement = $connect->query("SELECT LAST_INSERT_ID()");
		$last_id = $statement->fetchColumn();






$query_order = "SELECT * FROM temp_order WHERE branch_id = 1 ";


		$statement = $connect->prepare($query_order);

        $statement->execute();

        $resulttrans = $statement->fetchAll();

  //   $pid='';
  // 	$qty='';
 	// $price='';

foreach ($resulttrans as $row) 
{
	$pid=$row['product_id'];	
  	$qty=$row['qty'];
 	$price=$row['price'];
 	$product_code=$row['product_code'];

 	$queryorderItem = "
    INSERT INTO customer_order_item (order_id, product_code, selling_price, qty, total)
    VALUES (:order_id, :product_code, :selling_price, :qty, :total)";


      $statement = $connect->prepare($queryorderItem);
		$statement->execute(
			array(
				':order_id'	=>	$last_id,
				':product_code'		=>	$product_code,
				':selling_price'		=>	$price,
					':qty'     => $qty,
						':total'    =>  $total
					
			)
				
		);

	$result = $statement->fetchAll();


// 	$queryupdatestock = "UPDATE product SET product_quantity=product_quantity-'".$row['qty']."' 
// 	WHERE product_code = '".$row['product_code']."'
 

// ";

//         $statementS = $connect->prepare($queryupdatestock);
// 		$result = $statementS->execute();
// 		$result=$statementS->fetchAll();


			
}



        


// PAY TERMS

//$due_days = '';
// $due_date = '';
// $date_diff = '';

//  $tarehe = date("Y-m-d");
// // $siku = 40;

// // $date=date_create($tar);
// // date_add($date,date_interval_create_from_date_string("$siku days"));
// // echo date_format($date, "Y-m-d");

//  $date1=date_create($tarehe);
// // $date2=date_create("2013-12-12");
// // $diff=date_diff($date1,$date2);
// // echo $diff->format("%R%a ");



// 		$queryterm = "SELECT * FROM client WHERE client_id = '".$_POST['cid']."'";

// 		$statement = $connect->prepare($queryterm);

//         $statement->execute();

//         $resultterm = $statement->fetchAll();

//         foreach ($resultterm as $row ) 
//         {
//         	$due_days = $row['due_days'];
//         	$date=date_create($tarehe);
//         	date_add($date,date_interval_create_from_date_string("$due_days days"));
//         	$due_date = date_format($date, "Y-m-d");

//         	$date2=date_create($due_date);
//         	$diff=date_diff($date1,$date2);

//         	$date_diff = $diff->format("%R%a ");
//         }


//         $querytm = "
//     INSERT INTO overdue_invoice (sales_id,client_id, user_id, invoice_date, due_date,due_days, delay_days, status)
//     VALUES (:sales_id, :client_id, :user_id, :invoice_date, :due_date,:due_days, :delay_days, :status)

//  ";


//       $statement = $connect->prepare($querytm);
// 		$statement->execute(
// 			array(
// 				':sales_id'	=>	$last_id,
// 				':client_id'	=>	$_POST['cid'],
// 				':user_id'		=>	$_SESSION["user_id"],
// 				':invoice_date'		=>	date("Y-m-d"),
// 					':due_date'     => $due_date,
// 					':due_days'     => $date_diff,
// 						':delay_days'    =>  0,
				
// 				':status'		=>	'overdue'
// 			)
				
// 		);

// 	$result = $statement->fetchAll();



	$queryDelete = "DELETE FROM temp_order WHERE branch_id=1

	";

	$statementR = $connect->prepare($queryDelete);
		$result = $statementR->execute();
		$result=$statementR->fetchAll();



//echo json_encode(array("last_id"=>$last_id));

// print_r($relation_list[$x]);	

echo "<script>document.location='../order.php?cid=$cid'</script>"; 		
	
?>