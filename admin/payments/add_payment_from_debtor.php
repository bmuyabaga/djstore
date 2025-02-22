<?php

include('../../config/function.php');
$yes = true;

$Paid = '';

$amount_paid = '';
$totalOutstanding = '';
$clientName = '';
$difference = '';

//$totalOutstanding = $_POST['totalOutstanding'];
$clientName = $_POST['customeriddebtor'];
$amount_paid = $_POST['amountPaiddebtor'];



$query="SELECT * FROM sales 

WHERE sales_id=:sales_id
";

     $statement = $connect->prepare($query);
	 $statement->execute(
			array(
				':sales_id'	=>	$_POST["invoicenodebtor"]
			)
		);
		$result = $statement->fetchAll();
		
		foreach($result as $row)
		{
			
			$totalOutstanding= $row['balance'];
		}


$difference = $totalOutstanding - $amount_paid;



$query = "
		INSERT INTO payments (sales_id, user_id, client_id, payment_date, payment_method, due,paid, balance, notes, status, branch_id) 
		VALUES (:sales_id, :user_id, :client_id,  :payment_date, :payment_method, :due, :paid, :balance, :notes, :status, :branch_id)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':sales_id'	=>	$_POST["invoicenodebtor"],
				
				':user_id'	=>	$_SESSION['user_id'],
				':client_id'	=>	$_POST['customeriddebtor'],
				//':client_name'	=>	$_POST["client_Name"],
				':payment_date'	=>	$_POST["Receiveddebtor"],
				':payment_method'	=>	$_POST["paymentMethoddebtor"],
				':due'	=>	$totalOutstanding,
				':paid'	=>	$_POST["amountPaiddebtor"],
				':balance'	=>	$difference,
				':notes'	=>	$_POST['paymentNotesdebtor'],
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
		pay = pay + '".$_POST['amountPaiddebtor']."',
		balance = '$difference',
		payment_type = '$Paid' 

	
		WHERE sales_id = '".$_POST['invoicenodebtor']."'
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Payment Added';
		}
	

	$query = "
 UPDATE client SET total_outstanding = total_outstanding - '".$_POST['amountPaiddebtor']."'
 WHERE client_id = '".$_POST['customeriddebtor']."'

";
 $statement3 = $connect->prepare($query);
		$result = $statement3->execute();
		$result=$statement3->fetchAll();

echo "<script>document.location='./debtor.php'</script>"; 
//header('location:../debtor.php');



?>