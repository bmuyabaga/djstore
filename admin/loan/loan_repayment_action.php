<?php

include('../../config/function.php');
$yes = true;

$Paid = '';

$amount_paid1 = '';
$totalOutstanding1 = '';
$clientName = '';
$difference1 = '';

$totalOutstanding1 = $_POST['totaltotaloutstanding'];
//$clientName = $_POST[''];
$amount_paid1 = $_POST['amountamountpaid'];

$difference1 = $totalOutstanding1 - $amount_paid1;






$query = "
		INSERT INTO loan_payment (loan_id, user_id, emp_id, payment_date, payment_method, due,paid, balance, notes, status) 
		VALUES (:loan_id, :user_id, :emp_id,  :payment_date, :payment_method, :due, :paid, :balance, :notes, :status)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':loan_id'	=>	$_POST["loanloanID"],
				
				':user_id'	=>	$_SESSION['user_id'],
				':emp_id'	=>	$_POST['employeeIDID'],
				//':client_name'	=>	$_POST["client_Name"],
				':payment_date'	=>	$_POST["loanloanDate"],
				':payment_method'	=>	$_POST["paypaymethod"],
				':due'	=>	$_POST["totaltotaloutstanding"],
				':paid'	=>	$_POST["amountamountpaid"],
				':balance'	=>	$difference1,
				':notes'	=>	$_POST['paypaynotes'],
				':status'    => 'active'
				
			)
		);
		$result = $statement->fetchAll();
        
        

	if($amount_paid1==$totalOutstanding1)
	{
       $Paid='paid';
	}
	else
	{
		$Paid = 'partially_paid';
	}
	
	

$query1 = "
		UPDATE loan SET 
		returned_amount = returned_amount  + '".$_POST['amountamountpaid']."',
		balance = '$difference1',
		payment_type = '$Paid' 

	
		WHERE loan_id = '".$_POST['loanloanID']."'
		";
		$statement = $connect->prepare($query1);
		$statement->execute();
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Loan Payment Added';
		}
	





?>