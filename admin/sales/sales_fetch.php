<?php

//order_fetch.php

include('../../config/function.php');

$query = '';

$output = array();

$query .= "
	SELECT * FROM sales
    
    INNER JOIN client ON client.client_id=sales.client_id INNER JOIN user_details ON user_details.user_id=sales.user_id WHERE
	
";

if($_SESSION['type'] == 'user')
{
	$query .= 'sales.user_id = "'.$_SESSION["user_id"].'" AND  ';
}

if(isset($_POST["search"]["value"]))
{
	$query .= '(sales.sales_id LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR client.client_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR sales.grandtotal LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR sales.pay LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR sales.balance LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR sales.status LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR sales.date LIKE "%'.$_POST["search"]["value"].'%") ';
	//$query .= 'OR sales.total LIKE "%'.$_POST["search"]["value"].'%" ';
	//$query .= 'OR sales.discount LIKE "%'.$_POST["search"]["value"].'%") ';
	
	//$query .= 'OR sales.pay LIKE "%'.$_POST["search"]["value"].'%") ';
	//$query .= 'OR sales.balance LIKE "%'.$_POST["search"]["value"].'%") ';
	
	
}

if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY sales.sales_id DESC ';
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
	$payment_status = '';

	if($row['payment_type'] == 'paid')
	{
		//$payment_status = '<span class="label label-info">Paid</span>';
		$payment_status = '<a href="#" class="btn btn-info btn-xs">Paid</a>';
	}
	elseif($row['payment_type'] == 'unpaid')
	{
		//$payment_status = '<span class="label label-warning">Unpaid</span>';
		$payment_status = '<a href="#" class="btn btn-warning btn-xs">Unpaid</a>';
	}
	elseif($row['payment_type'] == 'partially_paid')
	{
     //$payment_status = '<span class="label label-primary">Partially Paid</span>';
      $payment_status = '<a href="#" class="btn btn-primary btn-xs">Partially Paid</a>';
	}
	

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
	$sub_array[] = $row['sales_id'];
	$sub_array[] = $row['client_name'];
	$sub_array[] = $row['grandtotal'];
	$sub_array[] = $row['pay'];
	$sub_array[] = $row['balance'];
	$sub_array[] = $payment_status;
	$sub_array[] = $status;
	$sub_array[] = $row['date'];
	if($_SESSION['type'] == 'master')
	{
		$sub_array[] =  $row['user_name'];
	}
	//$sub_array[] = '<a href="invoice.php?view='.$row["sales_id"].'" class="btn btn-info btn-xs"><i class="fas fa-file-invoice"></i></a>';
	$sub_array[] = '<a href="invoice.php?pdf=1&order_id='.$row["sales_id"].'" class="btn btn-info btn-xs"><i class="fas fa-download"></i></a>';
	$sub_array[] = '<button type="button" name="update" id="'.$row["sales_id"].'" class="btn btn-warning btn-xs update"><i class="fas fa-dollar-sign"></i></button>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["sales_id"].'" class="btn btn-danger btn-xs delete" 
	data-status="'.$row["status"].'"><i class="fas fa-trash"></i></button>';
	$data[] = $sub_array;
}

function get_total_all_records($connect)
{
	$statement = $connect->prepare("SELECT * FROM sales");
	$statement->execute();
	return $statement->rowCount();
}

$output = array(
	"draw"    			=> 	intval($_POST["draw"]),
	"recordsTotal"  	=>  $filtered_rows,
	"recordsFiltered" 	=> 	get_total_all_records($connect),
	"data"    			=> 	$data
);	





echo json_encode($output);

?>