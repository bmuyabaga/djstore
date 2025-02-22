<?php

//brand_action.php

include('../../config/function.php');

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		$query = "
		INSERT INTO debit_note (sales_id, client_id, branch_id, zfda_invoice_number, invoice_pdf, user_id, amount, note, organization, createdate, debitnote_status) 
		VALUES (:sales_id, :client_id, :branch_id, :zfda_invoice_number, :invoice_pdf, :user_id, :amount, :note, :organization, :createdate, :debitnote_status)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':sales_id'	=>	$_POST["salesinvpoce"],
				':client_id'	=>	$_POST["client_idd"],
				':branch_id'	=>	1,
				':zfda_invoice_number'	=>	$_POST["zfdainvoice"],
				':invoice_pdf'	=>	$_POST["invoice_pdf"],
				':user_id'	=>	$_SESSION["user_id"],
				':amount'	=>	$_POST["invoice_amount"],
				':note'	=>	$_POST["debit_notes"],
				':organization'	=>	$_POST["organization"],
				':createdate'	=>	$_POST["debit_date"],
				':debitnote_status'	=>	'active'
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Details Added';
		}
	}

	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "
		SELECT * FROM debit_note WHERE debitnote_id = :debitnote_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':debitnote_id'	=>	$_POST["debitnote_id"]
			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['sales_id'] = $row['sales_id'];
			$output['client_id'] = $row['client_id'];
			$output['zfda_invoice_number'] = $row['zfda_invoice_number'];
			$output['invoice_pdf'] = $row['invoice_pdf'];
			$output['amount'] = $row['amount'];
			$output['note'] = $row['note'];
			$output['organization'] = $row['organization'];
			$output['createdate'] = $row['createdate'];
	
		}
		echo json_encode($output);
	}
	if($_POST['btn_action'] == 'Edit')
	{
		$query = "
		UPDATE brand set 
		category_id = :category_id, 
		brand_name = :brand_name 
		WHERE brand_id = :brand_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':category_id'	=>	$_POST["category_id"],
				':brand_name'	=>	$_POST["brand_name"],
				':brand_id'		=>	$_POST["brand_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Brand Name Edited';
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
		UPDATE brand 
		SET brand_status = :brand_status 
		WHERE brand_id = :brand_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':brand_status'	=>	$status,
				':brand_id'		=>	$_POST["brand_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Brand status change to ' . $status;
		}
	}
}

?>