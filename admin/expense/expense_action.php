<?php

//category_action.php
include('../../config/function.php');

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		

		$query = "
		INSERT INTO expense (user_id,expenseaccount_id,expense_date,expense_unit_cost,	quantity,units,expense_total_cost,payment_method,description,status,branch_id) 
		VALUES (:user_id,:expenseaccount_id,:expense_date,:expense_unit_cost,:quantity,:units,:expense_total_cost,:payment_method,:description,
		:status, :branch_id)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':user_id'	=>	$_SESSION["user_id"],
				':expenseaccount_id'	=>	$_POST["expenseaccount_id"],
				':expense_date'	=>	$_POST["expense_date"],
				':expense_unit_cost'	=>	$_POST["units_cost"],
				':quantity'	=>	$_POST["quantity"],
				':units'	=>	$_POST["units"],
				':expense_total_cost'	=>	$_POST["total_cost"],
				':payment_method'	=>	$_POST["pay_method"],
				':description'	=>	$_POST["notes"],
				':status'	=>	'active',
				':branch_id'  =>  1
				
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'New Expense Added';
		}
	}
	
	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "SELECT * FROM expense INNER JOIN expaccount ON expaccount.expenseaccount_id = expense.expenseaccount_id WHERE expense.expense_id = '".$_POST["expense_id"]."'
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			//$output['expense_account'] = fill_expense_account_list($connect, $row["expense_account"]);
			$output['expenseaccount_id'] =  $row["expenseaccount_id"];
			$output['expense_date'] = $row["expense_date"];
			$output['expense_unit_cost'] = $row["expense_unit_cost"];
			$output['quantity'] = $row["quantity"];
			$output['units'] = $row["units"];
			$output['expense_total_cost'] = $row["expense_total_cost"];
			$output['payment_method'] = $row["payment_method"];
			$output['description'] = $row["description"];
			//$output['status'] = $row["status"];
			//$output['expense_unit_cost'] = $row["expense_unit_cost"];
		}
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'Edit')
	{
		$query = "
		UPDATE expense SET 	expenseaccount_id = :expenseaccount_id, expense_date = :expense_date, expense_unit_cost = :expense_unit_cost, quantity = :quantity, units = :units, expense_total_cost = :expense_total_cost,   payment_method = :payment_method, description = :description            
		WHERE expense_id = :expense_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':expenseaccount_id'	=>	$_POST["expenseaccount_id"],
				':expense_date'	=>	$_POST["expense_date"],
				':expense_unit_cost'	=>	$_POST["units_cost"],
				':quantity'	=>	$_POST["quantity"],
				':units'	=>	$_POST["units"],
				':expense_total_cost'	=>	$_POST["total_cost"],
				':payment_method'	=>	$_POST["pay_method"],
				':description'	=>	$_POST["notes"],
				 ':expense_id'	=>	$_POST["expense_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Expense Edited';
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
		UPDATE category 
		SET category_status = :category_status 
		WHERE category_id = :category_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':category_status'	=>	$status,
				':category_id'		=>	$_POST["category_id"]
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
