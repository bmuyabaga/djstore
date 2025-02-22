<?php

//brand_fetch.php

include('../../config/function.php');

$query = '';

$output = array();
$query .= "
SELECT * FROM expense 
INNER JOIN expaccount ON expaccount.expenseaccount_id = expense.expenseaccount_id
";

if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE expense.expense_date LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR expaccount.expense_account LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR expense.expense_total_cost LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR expense.payment_method LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR expense.description LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR expense.status LIKE "%'.$_POST["search"]["value"].'%" ';
}

if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY expense.expense_id DESC ';
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
	$sub_array[] = $row['expense_id'];
	$sub_array[] = $row['expense_date'];
	$sub_array[] = $row['expense_account'];
	$sub_array[] = $row['expense_total_cost'];
	$sub_array[] = $row['payment_method'];
	
	$sub_array[] = $row['description'];
	$sub_array[] = $status;
	$sub_array[] = '<button type="button" name="update" id="'.$row["expense_id"].'" class="btn btn-warning btn-xs update">Update</button>';
	$sub_array[]= '<button type="button" name="view" id="'.$row["expense_id"].'" class="btn btn-warning btn-xs view">View</button>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["expense_id"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["status"].'">Delete</button>';
	$data[] = $sub_array;
}

function get_total_all_records($connect)
{
	$statement = $connect->prepare('SELECT * FROM expense');
	$statement->execute();
	return $statement->rowCount();
}

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=>	$filtered_rows,
	"recordsFiltered"	=>	get_total_all_records($connect),
	"data"				=>	$data
);

echo json_encode($output);




?>