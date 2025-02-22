<?php

include('../../config/function.php');

$query = '';

$output = array();

$query .= "SELECT * FROM loan
INNER JOIN user_details ON user_details.user_id = loan.user_id
INNER JOIN employee ON employee.emp_id = loan.emp_id

 ";

if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE amount LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR employee.first_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR loan.status LIKE "%'.$_POST["search"]["value"].'%" ';
}

if(isset($_POST['order']))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY loan_id DESC ';
}

if($_POST['length'] != -1)
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
	$sub_array[] = $row['loan_id'];
	$sub_array[] = $row['loan_date'];
	$sub_array[] = $row['first_name'];
	$sub_array[] = $row['amount'];
	$sub_array[] = $row['return_date'];
	$sub_array[] = $row['returned_amount'];
	$sub_array[] = $row['balance'];
	$sub_array[] = $status;
	$sub_array[] = '<button type="button" name="update" id="'.$row["loan_id"].'" class="btn btn-primary btn-xs update"><span class="fa fa-edit"></span></button>';
	$sub_array[] = '<button type="button" name="pay" id="'.$row["loan_id"].'" class="btn btn-warning btn-xs malipo"><i class="fas fa-dollar-sign"></i></button>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["loan_id"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["status"].'"><i class="fas fa-trash"></i></button>';
	
	$data[] = $sub_array;
}

$output = array(
	"draw"			=>	intval($_POST["draw"]),
	"recordsTotal"  	=>  $filtered_rows,
	"recordsFiltered" 	=> 	get_total_all_records($connect),
	"data"				=>	$data
);

function get_total_all_records($connect)
{
	$statement = $connect->prepare("SELECT * FROM nmb");
	$statement->execute();
	return $statement->rowCount();
}

echo json_encode($output);

?>