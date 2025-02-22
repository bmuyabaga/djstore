<?php

//category_action.php
include('../../config/function.php');

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		

		$query = "
		INSERT INTO vendor (user_id,vname,contactno,tin_no,	email,address,notes,status) 
		VALUES (:user_id,:vname,:contactno,:tin_no,:email,:address, :notes,:status)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':user_id'	=>	$_SESSION["user_id"],
				':vname'	=>	$_POST["supplier"],
				':contactno'	=>	$_POST["supplier_contact"],
				':tin_no'	=>	$_POST["supplier_tin"],
				':email'	=>	$_POST["supplier_email"],
				':address'	=>	$_POST["supplier_address"],
				':notes'    =>  $_POST["supplier_notes"],
				':status'	=>	'active'
				
				
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'New Supplier Added';
		}
	}
	
	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "SELECT * FROM vendor  WHERE vendor_id = :vendor_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(

          array(
				':vendor_id'	=>	$_POST["vendor_id"]
			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['vname'] = $row["vname"];
			$output['contactno'] = $row["contactno"];
			$output['tin_no'] = $row["tin_no"];
			$output['email'] = $row["email"];
			
			$output['address'] = $row["address"];
			$output['notes'] = $row["notes"];
		
		}
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'Edit')
	{
		$query = "
		UPDATE vendor SET 
		               vname = :vname, 
		               contactno = :contactno, 
		               tin_no = :tin_no, 
		               email = :email, 
		               address = :address, 
		               notes = :notes   
		               
		WHERE vendor_id = :vendor_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':vname'	=>	$_POST["supplier"],
				':contactno'	=>	$_POST["supplier_contact"],
				':tin_no'	=>	$_POST["supplier_tin"],
				':email'	=>	$_POST["supplier_email"],
				':address'	=>	$_POST["supplier_address"],
				':notes'	=>	$_POST["supplier_notes"],
				':vendor_id'=>	$_POST["vendor_id"]  
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Supplier Name Edited';
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
		UPDATE vendor 
		SET status = :status 
		WHERE vendor_id = :vendor_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':status'	=>	$status,
				':vendor_id'		=>	$_POST["vendor_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Supplier status change to ' . $status;
		}
	}
}


?>
