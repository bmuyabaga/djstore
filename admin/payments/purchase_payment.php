<?php

include('../../config/function.php');
$yes = true;

$Paid = '';

$amount_paid = '';
$totalOutstanding = '';
$clientName = '';
$difference = '';

$totalOutstanding = $_POST['totalamount'];
//$clientName = $_POST[''];
$amount_paid = $_POST['paidvalue'];

$difference = $totalOutstanding - $amount_paid;






$query = "
		INSERT INTO purchase_payment (purchase_id, user_id, vendor_id, payment_date, payment_method, due,paid, balance, notes, status, branch_id) 
		VALUES (:purchase_id, :user_id, :vendor_id,  :payment_date, :payment_method, :due, :paid, :balance, :notes, :status, :branch_id)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':purchase_id'	=>	$_POST["PurchaseIDD"],
				
				':user_id'	=>	$_SESSION['user_id'],
				':vendor_id'	=>	$_POST['vendorID'],
				//':client_name'	=>	$_POST["client_Name"],
				':payment_date'	=>	$_POST["Receiveddate"],
				':payment_method'	=>	$_POST["paymentMethod1"],
				':due'	=>	$_POST["totalamount"],
				':paid'	=>	$_POST["paidvalue"],
				':balance'	=>	$difference,
				':notes'	=>	$_POST['paymentNotes1'],
				':status'    => 'active',
				':branch_id'    => 1
			)
		);
		$result = $statement->fetchAll();
        
        

	if($amount_paid==$totalOutstanding)
	{
       $Paid='paid';
	}
	else
	{
		$Paid = 'partially_paid';
	}
	
	

$query = "
		UPDATE purchase SET 
		pay = pay + '".$_POST['paidvalue']."',
		balance = '$difference',
		payment_type = '$Paid' 

	
		WHERE purchase_id = '".$_POST['PurchaseIDD']."'
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Payment Added';
		}



		$query = "
 UPDATE vendor SET total_outstanding = total_outstanding - '".$_POST['paidvalue']."'
 WHERE vendor_id = '".$_POST['vendorID']."'

";
 $statement3 = $connect->prepare($query);
		$result = $statement3->execute();
		$result=$statement3->fetchAll();
	


header('location:../purchase.php');


?>