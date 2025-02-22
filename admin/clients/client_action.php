<?php

//category_action.php
include('../../config/function.php');

if(isset($_POST['btn_action']))
{
	// if($_POST['btn_action'] == 'Add')
	// {
		

	// 	$query = "
	// 	INSERT INTO vendor (user_id,vname,contactno,tin_no,	email,address,notes,status) 
	// 	VALUES (:user_id,:vname,:contactno,:tin_no,:email,:address, :notes,:status)
	// 	";
	// 	$statement = $connect->prepare($query);
	// 	$statement->execute(
	// 		array(
	// 			':user_id'	=>	$_SESSION["user_id"],
	// 			':vname'	=>	$_POST["supplier"],
	// 			':contactno'	=>	$_POST["supplier_contact"],
	// 			':tin_no'	=>	$_POST["supplier_tin"],
	// 			':email'	=>	$_POST["supplier_email"],
	// 			':address'	=>	$_POST["supplier_address"],
	// 			':notes'    =>  $_POST["supplier_notes"],
	// 			':status'	=>	'active'
				
				
	// 		)
	// 	);
	// 	$result = $statement->fetchAll();
	// 	if(isset($result))
	// 	{
	// 		echo 'New Supplier Added';
	// 	}
	// }
	
	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "SELECT * FROM client  WHERE client_id = :client_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(

          array(
				':client_id'	=>	$_POST["client_id"]
			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['client_name'] = $row["client_name"];
			$output['city'] = $row["city"];
			$output['address1'] = $row["address1"];
			$output['address2'] = $row["address2"];
			
			$output['due_days'] = $row["due_days"];
			$output['due_type'] = $row["due_type"];
			$output['max_credit'] = $row["max_credit"];
			$output['tin_no'] = $row["tin_no"];
			$output['vrn'] = $row["vrn"];
			$output['country'] = $row["country"];
			$output['post_code'] = $row["post_code"];
			$output['notes'] = $row["notes"];
			$output['photo'] = $row["photo"];
			$output['client_id'] = $row["client_id"];
		
		}
		echo json_encode($output);
	}

	// if($_POST['btn_action'] == 'Edit')
	// {
	// 	$query = "
	// 	UPDATE vendor SET 
	// 	               vname = :vname, 
	// 	               contactno = :contactno, 
	// 	               tin_no = :tin_no, 
	// 	               email = :email, 
	// 	               address = :address, 
	// 	               notes = :notes   
		               
	// 	WHERE vendor_id = :vendor_id
	// 	";
	// 	$statement = $connect->prepare($query);
	// 	$statement->execute(
	// 		array(
	// 			':vname'	=>	$_POST["supplier"],
	// 			':contactno'	=>	$_POST["supplier_contact"],
	// 			':tin_no'	=>	$_POST["supplier_tin"],
	// 			':email'	=>	$_POST["supplier_email"],
	// 			':address'	=>	$_POST["supplier_address"],
	// 			':notes'	=>	$_POST["supplier_notes"],
	// 			':vendor_id'=>	$_POST["vendor_id"]  
	// 		)
	// 	);
	// 	$result = $statement->fetchAll();
	// 	if(isset($result))
	// 	{
	// 		echo 'Supplier Name Edited';
	// 	}
	// }

	

}


?>
