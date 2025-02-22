<?php

//order_fetch.php

include('../../config/function.php');

$query = '';

$output = array();

$query .= "
	SELECT * FROM purchase
    
    INNER JOIN vendor ON vendor.vendor_id = purchase.vendor_id WHERE
	
";

if($_SESSION['type'] == 'user')
{
	$query .= 'purchase.user_id = "'.$_SESSION["user_id"].'" AND  ';
}

if(isset($_POST["search"]["value"]))
{
	$query .= '(purchase.purchase_id LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR vendor.vname LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR purchase.grandtotal LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR purchase.pay LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR purchase.balance LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR purchase.status LIKE "%'.$_POST["search"]["value"].'%" ';
	
	
	$query .= 'OR purchase.date LIKE "%'.$_POST["search"]["value"].'%") ';
	
	
	
}

if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY purchase.purchase_id DESC ';
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
	$sub_array[] = $row['purchase_id'];
	$sub_array[] = $row['vname'];
	$sub_array[] = $row['grandtotal'];
	$sub_array[] = $row['pay'];
	$sub_array[] = $row['balance'];
	$sub_array[] = $payment_status;
	$sub_array[] = $status;
	$sub_array[] = $row['date'];
	if($_SESSION['type'] == 'master')
	{
		$sub_array[] = get_user_name($connect, $row['user_id']);
	}
	$sub_array[] = '<a href="purchase_invoice_view.php?view='.$row["purchase_id"].'" class="btn btn-info btn-xs"><i class="fas fa-print"></i></a>';
	$sub_array[] = '<button type="button" name="update" id="'.$row["purchase_id"].'" class="btn btn-block btn-warning btn-xs payment"><i class="fas fa-dollar-sign"></button>';
	$sub_array[] = '<button type="button" name="stock" id="'.$row["purchase_id"].'" class="btn btn-block btn-primary btn-xs addstock"><i class="fas fa-plus"></i></button>';

	$sub_array[] = '<button type="button" name="delete" id="'.$row["purchase_id"].'" class="btn btn-danger btn-xs delete" 
	data-status="'.$row["status"].'"><i class="fas fa-trash-alt"></i></button>';
	$data[] = $sub_array;
}

function get_total_all_records($connect)
{
	$statement = $connect->prepare("SELECT * FROM purchase");
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