<?php

//loan_action.php

include('../../config/function.php');

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		$query = "
		INSERT INTO loan (loan_date,emp_id,amount,return_date,notes	,user_id,payment_method,balance,status) 
		VALUES (:loan_date, :emp_id, :amount, :return_date,:notes,:user_id,:payment_method,:balance, :status)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':loan_date'   =>  $_POST['loandate'],
				':emp_id'   =>  $_POST['employeeId'],
				':amount'   =>  $_POST['loanamount'],
				':return_date'   =>  $_POST['returndate'],
				':notes'   =>  $_POST['loannotes'],
				':user_id'	=>	$_SESSION["user_id"],
				':payment_method'   =>  $_POST['paymentmethod'],
			    ':balance'   =>  $_POST['loanamount'],
				':status'   =>  'active'

			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'New loan Added';
		}
	}
	
	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "SELECT * FROM loan 
        INNER JOIN employee ON employee.emp_id = loan.emp_id
		WHERE loan_id = :loan_id ";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':loan_id'	=>	$_POST["loan_id"]

			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['loan_date'] = $row['loan_date'];
			$output['first_name'] = $row['first_name'];
			$output['amount'] = $row['amount'];
			$output['return_date'] = $row['return_date'];
			$output['payment_method'] = $row['payment_method'];
			$output['notes'] = $row['notes'];
			$output['loan_id'] = $row['loan_id'];
		}
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'Edit')
	{
		$query = "
		UPDATE loan SET 
		   	loan_date =:loan_date, 
		   emp_id =:emp_id, 
		   amount =:amount,
		   return_date =:return_date,
		   payment_method =:payment_method,
		    	notes =:notes,      
		   WHERE loan_id =:loan_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':loan_date'	=>	$_POST["loandate"],
				':emp_id'	=>	$_POST["employeeId"],
				':amount'	=>	$_POST["loanamount"],
				':return_date'	=>	$_POST["returndate"],
				':payment_method'		=>	$_POST["paymentmethod"],
				':notes'   => $_POST["loannotes"],
				':loan_id' =>	$_POST["loan_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Loan Edited';
		}
	}
	if($_POST['btn_action'] == 'delete')
	{
		$status = 'active';
		if($_POST['status'] == 'active')
		{
			$status = 'inactive';	
		}
		$query = "
		UPDATE nmb 
		SET status = :status 
		WHERE nmb_id = :nmb_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':status'	=>	$status,
				':nmb_id'		=>	$_POST["nmb_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Category status change to ' . $status;
		}
	}
}

?>