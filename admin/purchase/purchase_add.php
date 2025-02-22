<?php 

include('../../config/function.php');

// session_start();
 //$id=$_SESSION['id'];	
// include('../dist/includes/dbcon.php');

 	$discount = $_POST['discount'];
// 	//$payment = $_POST['payment'];
 	$grandtotal = $_POST['amount_due'];
// 	$paymethod = $_POST['paymethod'];
	
	date_default_timezone_set("Africa/Dar_es_Salaam"); 
 	//$date = date("Y-m-d");
 	$cid=$_REQUEST['cid'];
// 	$branch=$_SESSION['branch'];
	
 	$total=$_POST['total'];
 	



$output = array();

 $query = "
    INSERT INTO purchase (vendor_id, user_id, date, total, discount, grandtotal, pay, balance, payment_type,receiving_status, status)
    VALUES (:vendor_id, :user_id, :date, :total, :discount, :grandtotal, :pay, :balance, :payment_type,:receiving_status, :status)

 ";


      $statement = $connect->prepare($query);
		$statement->execute(
			array(
				':vendor_id'	=>	$cid,
				':user_id'		=>	$_SESSION["user_id"],
				':date'		=>	date("Y-m-d"),
					':total'     => $_POST['total'],
						':discount'    =>  $_POST['discount'],
						':grandtotal'    =>  $_POST['amount_due'],
						':pay'      => 0,
				':balance'			=> $_POST['amount_due'],
				':payment_type'			=>	'unpaid',
				':receiving_status'			=>	'pending',
				':status'		=>	'active'
			)
				
		);

	$result = $statement->fetchAll();

	$queryvendor = "
 UPDATE vendor SET total_outstanding = total_outstanding + '".$_POST['amount_due']."'
 WHERE vendor_id = '".$_POST['cid']."'

";

$statementD = $connect->prepare($queryvendor);
		$result = $statementD->execute();
		$result=$statementD->fetchAll();

	$statement = $connect->query("SELECT LAST_INSERT_ID()");
		$last_id = $statement->fetchColumn();






$query_trans = "SELECT * FROM  temp_purchase WHERE branch_id = 1 ";


		$statement = $connect->prepare($query_trans);

        $statement->execute();

        $resulttrans = $statement->fetchAll();

  //   $pid='';
  // 	$qty='';
 	// $price='';

foreach ($resulttrans as $row) 
{
	//$total1 = '';
	$pid=$row['product_id'];	
  	$qty=$row['qty'];
 	$price=$row['price'];
 	$productCode=$row['product_code'];
    $total1 = $price * $qty;
 	$querysalesItem = "
    INSERT INTO purchase_item (purchase_id,product_id, product_code, buying_price, qty, total)
    VALUES (:purchase_id,:product_id, :product_code, :buying_price, :qty, :total)";


      $statement = $connect->prepare($querysalesItem);
		$statement->execute(
			array(
				':purchase_id'	=>	$last_id,
				':product_id'	=>	$pid,
				':product_code'		=>	$productCode,
				':buying_price'		=>	$price,
				':qty'     => $qty,
				':total'    =>  $total1
					
			)
				
		);

	$result = $statement->fetchAll();


	    // Insert warehouse alert
        $stmt = $connect->prepare("INSERT INTO warehouse_alerts (purchase_id, product_id,product_code, quantity) 
                                   VALUES (:purchase_id, :product_id,:product_code, :quantity)");
        $stmt->execute([
            ':purchase_id' => $last_id,
            ':product_id' => $pid,
			':product_code' => $productCode,
            ':quantity' => $qty
        ]);


// 	$queryupdatestock = "UPDATE product SET product_quantity=product_quantity-'".$row['qty']."' 
// 	WHERE product_code = '".$row['product_code']."'
 

// ";

//         $statementS = $connect->prepare($queryupdatestock);
// 		$result = $statementS->execute();
// 		$result=$statementS->fetchAll();


			
}



  
    


// PAY TERMS

// $due_days = '';
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



	$queryDelete = "DELETE FROM temp_purchase WHERE branch_id=1

	";

	$statementR = $connect->prepare($queryDelete);
		$result = $statementR->execute();
		$result=$statementR->fetchAll();



//echo json_encode(array("last_id"=>$last_id));

// print_r($relation_list[$x]);	

echo "<script>document.location='../purchase_invoice_create.php?vid=$cid'</script>"; 		
	
?>