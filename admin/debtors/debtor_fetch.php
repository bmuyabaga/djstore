<?php

//category_fetch.php

include('../../config/function.php');

$query = '';

$output = array();

$query .= "SELECT * FROM client WHERE 	total_outstanding>0; ";

if(isset($_POST["search"]["value"]))
{
	$query .= 'OR client_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR total_outstanding LIKE "%'.$_POST["search"]["value"].'%" ';
}

if(isset($_POST['order']))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY client_id DESC ';
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
	// $status = '';
	// if($row['category_status'] == 'active')
	// {
	// 	$status = '<span class="label label-success">Active</span>';
	// }
	// else
	// {
	// 	$status = '<span class="label label-danger">Inactive</span>';
	// }
	$sub_array = array();
	$sub_array[] = $row['client_id'];
	$sub_array[] = $row['client_name'];
	$sub_array[] = $row['total_outstanding'];
	//$sub_array[] = $status;
	$sub_array[] = '<button type="button" name="update" id="'.$row["client_id"].'" class="btn btn-primary btn-xs enter"><span class="fa fa-edit"></span></button>';
	//$sub_array[] = '<button type="button" name="delete" id="'.$row["category_id"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["category_status"].'"><i class="fas fa-trash"></i></button>';
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
	$statement = $connect->prepare("SELECT * FROM client");
	$statement->execute();
	return $statement->rowCount();
}

echo json_encode($output);

?>