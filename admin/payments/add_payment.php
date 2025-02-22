<?php

include('../../config/function.php');
$yes = true;

$Paid = '';

$amount_paid = '';
$totalOutstanding = '';
$clientName = '';
$difference = '';

$totalOutstanding = $_POST['totalOutstanding'];
$clientName = $_POST['customerid'];
$amount_paid = $_POST['amountPaid'];

$difference = $totalOutstanding - $amount_paid;



if($amount_paid > $totalOutstanding)
{
	$yes = false;
	echo 'Amount Paid cannot be greater than Total Outstanding';
}
else if($amount_paid == 0)
{
	$yes = false;
	echo 'Amount Paid cannot be zero';
}
else if($amount_paid < 0)
{
	$yes = false;
	echo 'Amount Paid cannot be negative';
}
else if($difference < 0)
{
	$yes = false;
	echo 'Amount Paid cannot be greater than Total Outstanding';
}
else if($difference == 0)
{
	$Paid = 'paid';
}
else
{
	$Paid = 'partially_paid';
}

if($yes == true)
{

	//PAYMENT RECEIPT NUMBER STARTS
	$fulldate= date('Y-m-d');
	$year = date('Y',strtotime($fulldate));
	$query_inv = "SELECT * FROM payments ORDER BY payment_id DESC LIMIT 1 ";
	$statement_inv = $connect->prepare($query_inv);
	$statement_inv->execute();
	$result_cr = $statement_inv ->fetchAll();
	$count = $statement_inv -> rowCount();
	if($count > 0)
	{
		foreach($result_cr as $row_cr)
		{
		   $last_cnr_id = $row_cr['payment_id'];
		  
			  $newinv = str_replace('RCPT'.$year,"",$last_cnr_id);
			  $newinv = str_pad($newinv+1,4,0,STR_PAD_LEFT);
			  $newinv = 'RCPT'.$year.$newinv;
			
	
		}
	}
	else
	{
		$newinv = 'RCPT'.$year.'0001';
		
	}

	//PAYMENT RECEIPT NUMBER ENDS
	//FETCH INVOICE NUMBER STARTS
      $invoceNumber = "SELECT * FROM sales WHERE sales_id = '".$_POST['invoiceno']."' ORDER BY sales_id DESC LIMIT 1";
      $statement = $connect->prepare($invoceNumber);
      $statement->execute();
      $result = $statement->fetchAll();
	  $invoice_number = '';
      foreach($result as $row)
      {
      	$invoice_number = $row['invoice_number'];
      }
	//FETCH INVOICE NUMBER ENDS
	$query = "
	INSERT INTO payments (sales_id,receipt_number,invoice_number, user_id, client_id, payment_date, payment_method, due,paid, balance, notes, status, branch_id) 
	VALUES (:sales_id,:receipt_number,:invoice_number,  :user_id, :client_id,  :payment_date, :payment_method, :due, :paid, :balance, :notes, :status, :branch_id)
	";
	$statement = $connect->prepare($query);
	$statement->execute(
		array(
			':sales_id'	=>	$_POST["invoiceno"],
			':receipt_number'	=>	$newinv,
			':invoice_number'	=>	$invoice_number,
			':user_id'	=>	$_SESSION['user_id'],
			':client_id'	=>	$_POST['customerid'],
			//':client_name'	=>	$_POST["client_Name"],
			':payment_date'	=>	$_POST["Received"],
			':payment_method'	=>	$_POST["paymentMethod"],
			':due'	=>	$_POST["totalOutstanding"],
			':paid'	=>	$_POST["amountPaid"],
			':balance'	=>	$difference,
			':notes'	=>	$_POST['paymentNotes'],
			':status'    => 'active',
			':branch_id'    => 1
		)
	);
	$result = $statement->fetchAll();
	
	//$statement = $connect->query("SELECT LAST_INSERT_ID()");
	//$last_id = $statement->fetchColumn();

if($amount_paid==$totalOutstanding)
{
   $Paid='paid';
}
else
{
	$Paid = 'partially_paid';
}



$query = "
	UPDATE sales SET 
	pay = pay + '".$_POST['amountPaid']."',
	balance = '$difference',
	payment_type = '$Paid' 


	WHERE sales_id = '".$_POST['invoiceno']."'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	//if(isset($result))
	//{
	//	echo 'Payment Added';
	//}


$query = "
UPDATE client SET total_outstanding = total_outstanding - '".$_POST['amountPaid']."'
WHERE client_id = '".$_POST['customerid']."'

";
$statement3 = $connect->prepare($query);
	$result = $statement3->execute();
	$result=$statement3->fetchAll();
}
//header('location:../sales.php');


echo "<script>document.location='../sales.php'</script>"; 

//header('location:../sales.php');


?>