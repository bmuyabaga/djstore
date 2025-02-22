<?php

//category_action.php

include('../../config/function.php');

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		$query = "
		INSERT INTO product_input (user_id,input_name,price,barcode,branch_id,status,description) 
		VALUES (:user_id, :input_name, :price, :barcode, :branch_id, :status,:description)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':user_id'	=>	$_SESSION["user_id"],
				':input_name'   =>  $_POST['input_name'],
				':price'   =>  $_POST['input_price'],
				':barcode'   =>  $_POST['input_code'],
				':branch_id'   =>  1,
				':status'   =>  'active',
				':description'   =>  $_POST['input_notes']

			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Input Added';
		}
	}
	
	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "SELECT * FROM product_input WHERE input_id = :input_id";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':input_id'	=>	$_POST["input_id"]

			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['input_name'] = $row['input_name'];
			$output['price'] = $row['price'];
			$output['barcode'] = $row['barcode'];
			$output['description'] = $row['description'];
		}
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'Edit')
	{
		$query = "
		UPDATE product_input SET 
		   input_name = :input_name, 
		   price = :price, 
		   barcode = :barcode, 
		   description = :description  
		   WHERE input_id = :input_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':input_name'	=>	$_POST["input_name"],
				':price'	=>	$_POST["input_price"],
				':barcode'	=>	$_POST["input_code"],
				':description'	=>	$_POST["input_notes"],
				':input_id'	=>	$_POST["input_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Input Edited';
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
		UPDATE product_input 
		SET status = :status 
		WHERE input_id = :input_id
		";
		
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':status'	=>	$status,
				':input_id'		=>	$_POST["input_id"]
					)
		);
		$result = $statement->fetchAll();
		
		if(isset($result))
		{
			echo 'Input status change to ' . $status;
		}
	}
}

?>