<?php


include('../../config/function.php');


	$yes = true;

$Paid = '';

$amount_paid = '';
$totalOutstanding = '';
$clientName = '';
$difference = '';
$cid = $_POST['clientIDD'];

$totalOutstanding = $_POST['totalOutstandingclientaccount'];
$clientName = $_POST['customeridclientaccount'];
$amount_paid = $_POST['amountPaidclientaccount'];

$difference = $totalOutstanding - $amount_paid;






$query = "
		INSERT INTO payments (sales_id, user_id, client_id, payment_date, payment_method, due,paid, balance, notes, status, branch_id) 
		VALUES (:sales_id, :user_id, :client_id,  :payment_date, :payment_method, :due, :paid, :balance, :notes, :status, :branch_id)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':sales_id'	=>	$_POST["invoicenoclientaccount"],
				
				':user_id'	=>	$_SESSION['user_id'],
				':client_id'	=>	$_POST['customeridclientaccount'],
				//':client_name'	=>	$_POST["client_Name"],
				':payment_date'	=>	$_POST["Receivedclientaccount"],
				':payment_method'	=>	$_POST["paymentMethodclientaccount"],
				':due'	=>	$_POST["totalOutstandingclientaccount"],
				':paid'	=>	$_POST["amountPaidclientaccount"],
				':balance'	=>	$difference,
				':notes'	=>	$_POST['paymentNotesclientaccount'],
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
		pay = pay + '".$_POST['amountPaidclientaccount']."',
		balance = '$difference',
		payment_type = '$Paid' 

	
		WHERE sales_id = '".$_POST['invoicenoclientaccount']."'
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		// if(isset($result))
		// {
		// 	echo 'Payment Added';
		// }
	

	$query = "
 UPDATE client SET total_outstanding = total_outstanding - '".$_POST['amountPaidclientaccount']."'
 WHERE client_id = '".$_POST['customeridclientaccount']."'

";
 $statement3 = $connect->prepare($query);
		$result = $statement3->execute();
		$result=$statement3->fetchAll();

//echo "<script>document.location='http://localhost/bethelbd_new/admin/client_details.php?view=$cid
//'</script>"; 
//header('location:sales.php');
 
//echo "<script>document.location='../client_details.php?view=$cid'</script>"; 
 //http://localhost/bethelbd_new/admin/client_details.php?view=$cid
  echo "<script>document.location='../client_details.php?view=$cid'</script>"; 




?>