<?php

//brand_fetch.php

include('../../config/function.php');

$query = '';

$output = array();
$query .= "
SELECT * FROM loan_payment 
INNER JOIN employee ON employee.emp_id = loan_payment.emp_id


";

if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE loan_payment.loan_payment_id LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR employee.first_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR loan_payment.loan_id LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR loan_payment.payment_date LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR loan_payment.payment_method LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR loan_payment.paid LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR loan_payment.status LIKE "%'.$_POST["search"]["value"].'%" ';
}

if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY loan_payment.loan_payment_id DESC ';
}

if($_POST["length"] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$data = array();

$filtered_rows = $statement->rowCount();

foreach($result as $row)
{
	$status = '';
	if($row['status'] == 'active')
	{
		$status = '<span class="label label-success">Active</span>';
	}
	else
	{
		$status = '<span class="label label-danger">Inactive</span>';
	}
	$sub_array = array();
	$sub_array[] = $row['loan_payment_id'];
	$sub_array[] = $row['loan_id'];
	$sub_array[] = $row['first_name'];
	$sub_array[] = $row['payment_date'];
	$sub_array[] = $row['payment_method'];
	$sub_array[] = $row['paid'];

	$sub_array[] = $status;
	$sub_array[] = '<button type="button" name="update" id="'.$row["loan_payment_id"].'" class="btn btn-warning btn-xs update">Update</button>';
	$sub_array[] = '<button type="button" name="update" id="'.$row["loan_payment_id"].'" class="btn btn-primary btn-xs print">Print</button>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["loan_payment_id"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["status"].'">Delete</button>';
	$data[] = $sub_array;
}

function get_total_all_records1($connect)
{
	$statement = $connect->prepare('SELECT * FROM loan_payment');
	$statement->execute();
	return $statement->rowCount();
}

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=>	$filtered_rows,
	"recordsFiltered"	=>	get_total_all_records1($connect),
	"data"				=>	$data
);

echo json_encode($output);

?>