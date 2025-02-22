<?php

//category_fetch.php

include('../../config/function.php');

$query = '';

$output = array();

$query .= "SELECT * FROM tax ";

if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE tax_name LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR tax_percentage LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR tax_status LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR tax_added_on LIKE "%'.$_POST["search"]["value"].'%" ';
}

if(isset($_POST['order']))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY tax_id DESC ';
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
	if($row['tax_status'] == 'Enable')
	{
		$status = '<div class="badge bg-success">Enable</div>';
		$delete_button = '<button type="button" name="delete" id="'.$row["tax_id"].'" class="btn btn-danger btn-xs delete_tax" data-status="'.$row["tax_status"].'"><i class="fa fa-toggle-off" aria-hidden="true"></i> Disable</button>';
	}
	else
	{
	
		$status = '<div class="badge bg-danger">Disable</div>';
		$delete_button = '<button type="button" name="delete" id="'.$row["tax_id"].'" class="btn btn-success btn-xs delete_tax" data-status="'.$row["tax_status"].'"><i class="fa fa-toggle-on" aria-hidden="true"></i> Enable</button>';
	}
	$sub_array = array();
	$sub_array[] = $row['tax_name'];
	$sub_array[] = $row['tax_percentage'];
	$sub_array[] = $status;
    $sub_array[] = $row['tax_added_on'];
	$sub_array[] = '<button type="button" name="update" id="'.$row["tax_id"].'" class="btn btn-primary btn-xs update_tax"><span class="fa fa-edit"></span></button>';
	$sub_array[] = $delete_button;
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
	$statement = $connect->prepare("SELECT * FROM tax");
	$statement->execute();
	return $statement->rowCount();
}

echo json_encode($output);

?>