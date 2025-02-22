<?php 

include('../../config/function.php');
date_default_timezone_set("Africa/Dar_es_Salaam"); 
// generate invoice number
$fulldate= date('Y-m-d');
$year = date('Y',strtotime($fulldate));
$query_inv = "SELECT * FROM sales ORDER BY sales_id DESC LIMIT 1 ";
$statement_inv = $connect->prepare($query_inv);
$statement_inv->execute();
$result_cr = $statement_inv ->fetchAll();
$count = $statement_inv -> rowCount();
if($count > 0)
{
		foreach($result_cr as $row_cr)
		{
			
				$last_cnr_id = $row_cr['sales_id'];
				$newinv = str_replace('INV'.$year,"",$last_cnr_id);
				$newinv = str_pad($newinv+1,4,0,STR_PAD_LEFT);
				$newinv = 'INV'.$year.$newinv;
		}
}
else
{
	           $newinv = 'INV'.$year.'0001';
}
// end generate invoice number

// get customer id
      $cid=$_REQUEST['cid'];
// end get customer id

// get discount
      $discount = $_POST['discount'];  
// end get discount

// get grandtotal
      $grandtotal = $_POST['amount_due'];
// end get grandtotal

// get total
      $total=$_POST['total'];
// end get total

// initiate array
$output = array();
// end initiate array

// enter data into sales table
$sales_query = "
INSERT INTO sales (client_id, user_id,invoice_number, date, total, discount, grandtotal, pay, balance, payment_type, status,branch_id)
VALUES (:client_id, :user_id,:invoice_number,  :date, :total, :discount, :grandtotal, :pay, :balance, :payment_type, :status,:branch_id)

";
$sales_statement = $connect->prepare($sales_query);
$sales_statement->execute(
	array(
		':client_id'	=>	$cid,
		':user_id'		=>	$_SESSION["user_id"],
		':invoice_number'		=>	$newinv,
		':date'		=>	date("Y-m-d"),
		':total'     => $_POST['total'],
		':discount'    =>  $_POST['discount'],
		':grandtotal'    =>  $_POST['amount_due'],
		':pay'      => 0,
		':balance'			=> $_POST['amount_due'],
		':payment_type'			=>	'unpaid',
		':status'		=>	'active',
		':branch_id'		=>	1
	)
);
$sales_result = $sales_statement->fetchAll();
// end enter data into sales table

//fetch last insert id from sales table
$last_sales_id = $connect->lastInsertId();
//end last insert id from sales table

//payment terms start
    //fetch data from credit_settings
	   $select_credit_settings_query = "SELECT * FROM credit_settings WHERE client_id = '".$cid."' ";
	   $credit_settings_statement = $connect->prepare($select_credit_settings_query);
	   $credit_settings_statement->execute();
	   $credit_settings_result = $credit_settings_statement->fetchAll();

	   // initialize variables
	    $due_days = '';
        $payterms = '';
	   // end initialize variables
	   foreach($credit_settings_result as $row_credit_settings)
	   {
	   		$due_days = $row_credit_settings['days'];
	   		$payterms = $row_credit_settings['payterms'];
	   }
	   // end fetch data from credit_settings
  // initialize variable due_date
    $due_date = '';
  // end initialize variable due_date

  // set conditions for payment terms
  if($payterms == 'eom')
  {
	  $purchaseDate = date('Y-m-d');
	  // Convert the purchase date to a DateTime object
	  $purchaseDate = new DateTime($purchaseDate); 
		 // Get the last day of the current month
		 $lastDayOfMonth = clone $purchaseDate;
		 $lastDayOfMonth->modify('last day of this month');
  
		  // Add 20 days to the last day of the month
		  $paymentDate = clone $lastDayOfMonth;
		  $paymentDate->modify("+{$due_days} days");
		  $due_date = $paymentDate->format('Y-m-d');
	  
  }
  elseif($payterms == 'invoice_date')
  {
	  $invoicedDate = date('Y-m-d');
	   // Convert the invoice date to a DateTime object
	   $invoiceDate = new DateTime($invoicedDate);
	   $paymentDate = clone $invoiceDate;
	   $paymentDate->modify("+{$due_days} days");
  
	  $due_date = $paymentDate->format('Y-m-d');
  }
  else
  {
	  $due_date = date('Y-m-d');
  }
  // end set conditions for payment terms
//payment terms end	

// insert data into due invoices table
$due_invoices_query =  "
INSERT INTO due_invoices (client_id, sales_id, invoice_number, sales_date, sales_due_date, due_status)
VALUES (:client_id, :sales_id, :invoice_number, :sales_date, :sales_due_date, :due_status)";
$due_invoices_statement = $connect->prepare($due_invoices_query);
$due_invoices_statement->execute(
	array(
		':client_id'	=>	$cid,
		':sales_id'		=>	$last_sales_id,
		':invoice_number'		=>	$newinv,
		':sales_date'		=>	date("Y-m-d"),
		':sales_due_date'		=>	$due_date,
		':due_status'		=>	'pending'
	)
);
$due_invoices_result = $due_invoices_statement->fetchAll();
// end insert data into due invoices table

// update total outstanding in client table
$total_outstandint_in_client_table =    "
UPDATE client SET total_outstanding = total_outstanding + '".$_POST['amount_due']."'
WHERE client_id = '".$_POST['cid']."'

";
$total_outstandint_in_client_table_statement = $connect->prepare($total_outstandint_in_client_table);
$total_outstandint_in_client_table_result = $total_outstandint_in_client_table_statement->fetchAll();
// end update total outstanding in client table

// initialize variables
// $pid= '';	
// $qty= '';
// $price= '';
// $product_code= '';
//$total_from_temp_trans = '';
// end initialize variables

// fetch data from temp_trans table
 $temp_trans_query = "SELECT * FROM temp_trans WHERE branch_id = 1 ";
 $temp_trans_statement = $connect->prepare($temp_trans_query);
 $temp_trans_statement->execute();
 $temp_trans_result = $temp_trans_statement->fetchAll(PDO::FETCH_ASSOC);
 foreach($temp_trans_result as $row_temp_trans)
 {
 	$pid = $row_temp_trans['product_id'];
 	$qty = $row_temp_trans['qty'];
 	$price = $row_temp_trans['price'];
 	$product_code = $row_temp_trans['product_code'];
	$total_from_temp_trans = $row_temp_trans['total'];


	// insert data into sales_item table
	$sales_item_query =  "
    INSERT INTO sales_item (sales_id,product_id, product_code, selling_price, qty, total)
    VALUES (:sales_id,:product_id, :product_code, :selling_price, :qty, :total)";
	$sales_item_statement = $connect->prepare($sales_item_query);
	$sales_item_statement->execute(
		array(
			':sales_id'	=>	$last_sales_id,
			':product_id' => $pid,
			':product_code'		=>	$product_code,
			':selling_price'		=>	$price,
			':qty'     => $qty,
			':total'    =>  $total_from_temp_trans
				
		)
	);
	$sales_item_result = $sales_item_statement->fetchAll();
	// end insert data into sales_item table

	// update product quantity in product table
	$update_product_quantity_query = "UPDATE product SET product_quantity=product_quantity-'".$row_temp_trans['qty']."' WHERE product_code = '".$row_temp_trans['product_code']."'";
	$update_product_statement = $connect->prepare($update_product_quantity_query);
	$update_product_result = $update_product_statement->execute();
	// end update product quantity in product table
		
 }

// end fetch data from temp_trans table


// checking batches
	// loop items from temp_trans
	foreach($temp_trans_result as $rowNew)
	{
	 $pid = $rowNew['product_id'];
	 $qty = $rowNew['qty'];
	 $price = $rowNew['price'];
	 $product_code = $rowNew['product_code'];
	 $total_from_temp_trans = $rowNew['total'];
	 // checking batches
	 // Fetch batches for the product sorted by expiry_date (earliest first)
	 // Fetch batches for the product sorted by expiry_date (earliest first)
$stmt = $connect->prepare("SELECT * FROM product_batches WHERE product_id = :product_id AND stock > 0 ORDER BY expiry_date ASC");
$stmt->execute([':product_id' => $pid]);
$batches = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($batches as $batch) {
	if ($qty <= 0) break; // Stop if all quantity is deducted

	$batch_id = $batch['product_batches_id'];
	$batch_number = $batch['batch_number'];
	$batch_stock = $batch['stock'];

	if ($batch_stock >= $qty) {
		// Deduct required quantity from the current batch
		$stmt = $connect->prepare("UPDATE product_batches SET stock = stock - :quantity WHERE product_batches_id = :batch_id");
		$stmt->execute([':quantity' => $qty, ':batch_id' => $batch_id]);

		// Insert into sales_details with batch information
		$stmt = $connect->prepare("INSERT INTO sales_details_batches (sale_id, product_id,product_code, batch_number, quantity, cost_price,selling_price,total_cost,total_revenue,gross_profit) 
								   VALUES (:sale_id, :product_id,:product_code, :batch_number, :quantity, :cost_price,:selling_price,:total_cost,:total_revenue,:gross_profit)");
		$stmt->execute([
			':sale_id' => $last_sales_id,
			':product_id' => $pid,
			':product_code' => $product_code,
			':batch_number' => $batch_number,
			':quantity' => $qty,
			':cost_price' => $batch['cost'],
			':selling_price' => $price,
			':total_cost' => ($batch['cost'] * $qty),
			':total_revenue' => ($price * $qty),
			':gross_profit' => (($price - $batch['cost']) * $qty),
			
			
			
		]);

		$qty = 0; // Fully deducted
	} else {
		// Use the full stock of the current batch and move to the next batch
		$stmt = $connect->prepare("UPDATE product_batches SET stock = 0 WHERE product_batches_id = :batch_id");
		$stmt->execute([':batch_id' => $batch_id]);

		// Insert into sales_details_batches with the used batch quantity
		$stmt = $connect->prepare("INSERT INTO sales_details_batches (sale_id, product_id,product_code, batch_number, quantity, cost_price,selling_price,total_cost,total_revenue,gross_profit) 
								   VALUES (:sale_id, :product_id,:product_code, :batch_number, :quantity, :cost_price,:selling_price,:total_cost,:total_revenue,:gross_profit)");
		$stmt->execute([
			':sale_id' => $last_sales_id,
			':product_id' => $pid,
			':product_code' => $product_code,
			':batch_number' => $batch_number,
			':quantity' => $batch_stock,
			':cost_price' => $batch['cost'],
			':selling_price' => $price,
			':total_cost' => ($batch['cost'] * $batch_stock),
			':total_revenue' => ($price * $batch_stock),
			':gross_profit' => (($price - $batch['cost']) * $batch_stock)
			

			
		]);

		$qty -= $batch_stock; // Deduct what was used from this batch
	}


}
	}
	 // end checking batches

// end checking batches

// delete data from temp_trans table
$delete_temp_trans_query = "DELETE FROM temp_trans WHERE branch_id=1 
	";
$delete_temp_trans_statement = $connect->prepare($delete_temp_trans_query);
$delete_temp_trans_result = $delete_temp_trans_statement->execute();
if(isset($delete_temp_trans_result))
{
	$_SESSION['success'] ="Order has been created successfully";
	echo "<script>document.location='../new_invoice.php?cid=$cid'</script>"; 
}
else
{
	$_SESSION['error'] ="Order creation failed";
	echo "<script>document.location='../new_invoice.php?cid=$cid'</script>"; 
}


		
	
?>