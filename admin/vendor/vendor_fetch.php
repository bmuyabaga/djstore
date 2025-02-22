<?php

//category_fetch.php

include('../../config/function.php');

$query = '';

$output = array();

$query .= "SELECT * FROM vendor ";

if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE vname LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR contactno LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR email LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR tin_no LIKE "%'.$_POST["search"]["value"].'%" ';
	
	$query .= 'OR address LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR status LIKE "%'.$_POST["search"]["value"].'%" ';
}

if(isset($_POST['order']))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY vendor_id DESC ';
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
		//$status = '<span class="label label-success">Active</span>';
		$status ='<a href="#" class="btn btn-success btn-xs">Active</a>';
	}
	else
	{
		//$status = '<span class="label label-danger">Inactive</span>';
		$status = '<a href="#" class="btn btn-danger btn-xs">Active</a>';
	}
	$sub_array = array();
	$sub_array[] = $row['vendor_id'];
	$sub_array[] = $row['vname'];
	$sub_array[] = $row['contactno'];
	$sub_array[] = $row['email'];
	$sub_array[] = $row['tin_no'];
	
	$sub_array[] = $row['address'];
	$sub_array[] = $status;
	$sub_array[] = '<button type="button" name="update" id="'.$row["vendor_id"].'" class="btn btn-primary btn-xs update"><span class="fa fa-edit"></span></button>';
	$sub_array[]= '<a href="vendor_details.php?view='.$row["vendor_id"].'" class="btn btn-info btn-xs">Details</a>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["vendor_id"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["status"].'"><i class="fas fa-trash"></i></button>';

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
	$statement = $connect->prepare("SELECT * FROM vendor");
	$statement->execute();
	return $statement->rowCount();
}

echo json_encode($output);

?>