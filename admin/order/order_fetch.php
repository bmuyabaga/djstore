<?php

//brand_fetch.php

include('../../config/function.php');

$query = '';

$output = array();
$query .= "
SELECT * FROM customer_order NATURAL JOIN  customer_order_item NATURAL JOIN product NATURAL JOIN client

";

if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE customer_order.order_date LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR customer_order_item.qty LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR product.product_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR client.client_name LIKE "%'.$_POST["search"]["value"].'%" ';
	//$query .= 'OR expense.description LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR customer_order.status LIKE "%'.$_POST["search"]["value"].'%" ';
}

if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY customer_order.order_id DESC ';
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
	$order_status = '';

	if($row['payment_type'] == 'Fully Delivered')
	{
		//$payment_status = '<span class="label label-info">Paid</span>';
		$order_status = '<a href="#" class="btn btn-success btn-xs">Fully Delivered</a>';
	}
	elseif($row['payment_type'] == 'Partially Delivered')
	{
		//$payment_status = '<span class="label label-warning">Unpaid</span>';
		$order_status = '<a href="#" class="btn btn-warning btn-xs">Partially Delivered</a>';
	}
	elseif($row['payment_type'] == 'Not Delivered')
	{
     //$payment_status = '<span class="label label-primary">Partially Paid</span>';
      $order_status = '<a href="#" class="btn btn-danger btn-xs">Not Delivered</a>';
	}

	$sub_array = array();
	$sub_array[] = $row['qty'];
	$sub_array[] = $row['product_base_price'];
	$sub_array[] = $row['product_name'];
	$sub_array[] = $row['order_date'];
	$sub_array[] = $row['order_id'];
	
	$sub_array[] = $row['client_name'];
	$sub_array[] = $order_status;
	//$sub_array[] = '<button type="button" name="update" id="'.$row["order_id"].'" class="btn btn-warning btn-xs update">Update</button>';
	$sub_array[] = '<a href="order_view.php?pdf=1&order_id='.$row["order_id"].'" class="btn btn-info btn-xs"><i class="fas fa-download"></i></a>';
	//$sub_array[]= '<button type="button" name="view" id="'.$row["order_id"].'" class="btn btn-warning btn-xs view">View</button>';
	//$sub_array[] = '<button type="button" name="delete" id="'.$row["order_id"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["status"].'">Delete</button>';
	$data[] = $sub_array;
}

function get_total_all_records($connect)
{
	$statement = $connect->prepare('SELECT * FROM customer_order');
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