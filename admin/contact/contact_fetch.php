<?php

//category_fetch.php

include('../../config/function.php');

$query = '';

$output = array();

$query .= "SELECT * FROM contacts 
INNER JOIN client ON client.client_id = contacts.customer_id 
INNER JOIN position ON position.position_id = contacts.position_id
WHERE contacts.customer_id = '".$_POST['customer_id']."' AND client.client_status = 'active' ";

if(isset($_POST["search"]["value"]))
{
	$query .= 'AND (title LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR contacts.contact_name LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR contacts.email_address LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR contacts.phone_number LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR position.position_name LIKE "%'.$_POST["search"]["value"].'%") ';
	
}

if(isset($_POST['order']))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY contacts.contact_id DESC ';
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
	if($row['contact_status'] == 'active')
	{
		//$status = '<span class="label label-success">Active</span>';
		$status ='<a href="#" class="btn btn-success btn-xs">Active</a>';
	}
	else
	{
		//$status = '<span class="label label-danger">Inactive</span>';
		$status = '<a href="#" class="btn btn-danger btn-xs">Inactive</a>';
	}
	$sub_array = array();
	$sub_array[] = $row['title'];
	$sub_array[] = $row['contact_name'];
	$sub_array[] = $row['email_address'];
	$sub_array[] = $row['phone_number'];
	$sub_array[] = $row['position_name'];
	$sub_array[] = $status;
	//$sub_array[] = $status;
	$sub_array[] = '<button type="button" name="update" id="'.$row["contact_id"].'" class="btn btn-primary btn-xs update_contact"><span class="fa fa-edit"></span></button>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["contact_id"].'" class="btn btn-danger btn-xs delete_contact" data-status="'.$row["contact_status"].'"><i class="fas fa-trash"></i></button>';
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
	$statement = $connect->prepare("SELECT * FROM contacts");
	$statement->execute();
	return $statement->rowCount();
}

echo json_encode($output);

?>