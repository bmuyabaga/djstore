<?php

//category_action.php

include('../../config/function.php');

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		$query = "
		INSERT INTO nmb (user_id,amount,method,	transaction,bank_type, notes,status) 
		VALUES (:user_id, :amount, :method, :transaction, :bank_type, :notes, :status)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':user_id'	=>	$_SESSION["user_id"],
				':amount'   =>  $_POST['amount'],
				':method'   =>  $_POST['transactStatus'],
				':transaction'   =>  $_POST['transact'],
				':bank_type'   =>  $_POST['bank'],
				':notes'   =>  $_POST['nmbnotes'],
				':status'   =>  'active'

			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Transaction Added';
		}
	}
	
	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "SELECT * FROM nmb WHERE nmb_id = :nmb_id";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':nmb_id'	=>	$_POST["nmb_id"]

			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['transaction'] = $row['transaction'];
			$output['bank_type'] = $row['bank_type'];
			$output['amount'] = $row['amount'];
			$output['method'] = $row['method'];
			$output['notes'] = $row['notes'];
		}
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'Edit')
	{
		$query = "
		UPDATE nmb SET 
		   amount = :amount, 
		   method = :method, 
		   transaction = :transaction, 
		   bank_type = :bank_type, 
		   notes = :notes 
		   WHERE nmb_id = :nmb_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':amount'	=>	$_POST["amount"],
				':method'	=>	$_POST["transactStatus"],
				':transaction'	=>	$_POST["transact"],
				':bank_type'	=>	$_POST["bank"],
				':notes'	=>	$_POST["nmbnotes"],
				':nmb_id'		=>	$_POST["nmb_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Nmb Transaction Edited';
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