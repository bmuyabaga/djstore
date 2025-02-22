<?php

//category_action.php
include('../../config/function.php');

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		

		$query = "
		INSERT INTO  employee (first_name,last_name,user_id,department_id,salary,email,join_date,dob,end_date,position_id,	tribe_id,region_id,	branch_id,image,sex,country_id,notes,status) 
		
		VALUES (:first_name,:last_name,:user_id,:department_id,:salary,:email,:join_date, :dob,:end_date,:position_id,:tribe_id,:region_id,:branch_id,:image,:sex,:country_id,:notes,:status)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':first_name'	=>	$_POST["first_name"],
                ':last_name'	=>	$_POST["last_name"],

				':user_id'	=>	$_SESSION["user_id"],
				':department_id'	=>	$_POST["department"],
				':salary'	=>	$_POST["salary"],
				':email'	=>	$_POST["email"],
				':join_date'	=>	$_POST["join_date"],
				':dob'	=>	$_POST["dob"],
				':end_date'    =>  $_POST["end_date"],
				':position_id'	=>	$_POST["position"],
                ':tribe_id'	=>	$_POST["tribe"],
                ':region_id'	=>	$_POST["region"],
                ':branch_id'	=>	1,
                ':image'	=>	'image',
                ':sex'	=>	$_POST["sex"],
                ':country_id'	=>	$_POST["country"],
                ':notes'	=>	$_POST["notes"],
				':status'	=>	'active'
				
				
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'New Employee Added';
		}
	}
	
	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "SELECT * FROM employee  WHERE emp_id = :emp_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(

          array(
				':emp_id'	=>	$_POST["employee_id"]
			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['first_name'] = $row["first_name"];
			$output['last_name'] = $row["last_name"];
			$output['department_id'] = $row["department_id"];
			$output['salary'] = $row["salary"];
			$output['email'] = $row["email"];
			$output['tribe_id'] = $row["tribe_id"];
			$output['join_date'] = $row["join_date"];
			$output['dob'] = $row["dob"];
			$output['end_date'] = $row["end_date"];
			$output['position_id'] = $row["position_id"];
			$output['region_id'] = $row["region_id"];
			$output['country_id'] = $row["country_id"];
			$output['sex'] = $row["sex"];
			$output['notes'] = $row["notes"];
		
		}
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'Edit')
	{
		$query = "
		UPDATE employee SET 
		    first_name = :first_name,
			last_name = :last_name,
			department_id = :department_id,
			salary = :salary,
			email = :email,
			tribe_id = :tribe_id,
			join_date = :join_date,
			dob = :dob,
			end_date = :end_date,
			position_id = :position_id,
			region_id = :region_id,
			country_id = :country_id,
			sex = :sex,
			notes = :notes
		               
		WHERE 	emp_id = :employee_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(

				':first_name'   => $_POST["first_name"],
                ':last_name'   => $_POST["last_name"],
                ':department_id'   => $_POST["department"],
                ':salary'   => $_POST["salary"],
                ':email'   => $_POST["email"],
                ':tribe_id'   => $_POST["tribe"],
                ':join_date'   => $_POST["join_date"],
                ':dob'   => $_POST["dob"],
                ':end_date'   => $_POST["end_date"],
                ':position_id'   => $_POST["position"],
                ':region_id'   => $_POST["region"],
                ':country_id'   => $_POST["country"],
                ':sex'   => $_POST["sex"],
                ':notes'   => $_POST["notes"], 
                ':employee_id'   => $_POST["employee_id"] 
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Employee Name Edited';
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
		UPDATE employee 
		SET status = :status 
		WHERE emp_id = :employee_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':status'	=>	$status,
				':employee_id'		=>	$_POST["employee_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Employee status change to ' . $status;
		}
	}
}


?>
