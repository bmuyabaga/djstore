<?php

//brand_fetch.php

include('../../config/function.php');

$query = '';

$output = array();
$query .= "
SELECT * FROM payments 
INNER JOIN client ON client.client_id = payments.client_id WHERE


";

if($_SESSION['type'] == 'user')
{
	$query .= 'payments.user_id = "'.$_SESSION["user_id"].'" AND  ';
}


if(isset($_POST["search"]["value"]))
{
	$query .= '(payments.payment_id LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR client.client_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR payments.sales_id LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR payments.payment_date LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR payments.payment_method LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR payments.paid LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR payments.status LIKE "%'.$_POST["search"]["value"].'%" )';
}

if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY payments.payment_id DESC ';
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
		//$status = '<span class="label label-success">Active</span>';
		$status ='<a href="#" class="btn btn-success btn-xs">Active</a>';
	}
	else
	{
		//$status = '<span class="label label-danger">Inactive</span>';
		$status = '<a href="#" class="btn btn-danger btn-xs">Active</a>';
	}
	$sub_array = array();
	$sub_array[] = $row['payment_id'];
	$sub_array[] = $row['sales_id'];
	$sub_array[] = $row['client_name'];
	$sub_array[] = $row['payment_date'];
	$sub_array[] = $row['payment_method'];
	$sub_array[] = $row['paid'];

	$sub_array[] = $status;
	$sub_array[] = '<button type="button" name="update" id="'.$row["payment_id"].'" class="btn btn-warning btn-xs update">Update</button>';
	//$sub_array[] = '<button type="button" name="update" id="'.$row["payment_id"].'" class="btn btn-primary btn-xs print">Print</button>';
	$sub_array[] = '<a href="payment_receipt.php?pdf=1&payment_id='.$row["payment_id"].'" target="_blank" class="btn btn-info btn-xs"><i class="fas fa-download"></i></a>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["payment_id"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["status"].'">Delete</button>';
	$data[] = $sub_array;
}

function get_total_all_records($connect)
{
	$statement = $connect->prepare('SELECT * FROM payments');
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