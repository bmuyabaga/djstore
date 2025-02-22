<?php

//category_fetch.php

include('../../config/function.php');


$query = '';

$output = array();
//$query .= "SELECT c.client_id, c.client_name,c.address1,c.due_type,c.client_status,c.created_on MIN(s.date) AS first_sale_date, MAX(s.date) AS last_sale_date FROM client c JOIN sales s ON c.client_id = s.client_id GROUP BY c.client_id, c.client_name";
//$query .= "SELECT * FROM client";
$query .= "SELECT c.client_id, c.client_name, c.address1, c.due_type, c.client_status, c.created_on, 
            MIN(s.date) AS first_sale_date, MAX(s.date) AS last_sale_date 
            FROM client c 
            LEFT JOIN sales s ON c.client_id = s.client_id 
            GROUP BY c.client_id, c.client_name, c.address1, c.due_type, c.client_status, c.created_on";


// if(isset($_POST["search"]["value"]))
// {
// 	$query .= 'WHERE c.client_name LIKE "%'.$_POST["search"]["value"].'%" ';
// 	$query .= 'OR c.address1 LIKE "%'.$_POST["search"]["value"].'%" ';
// 	$query .= 'OR c.due_type LIKE "%'.$_POST["search"]["value"].'%" ';
// 	$query .= 'OR c.client_status LIKE "%'.$_POST["search"]["value"].'%" ';
// 	$query .= 'OR c.created_on LIKE "%'.$_POST["search"]["value"].'%" ';
// }

// if(isset($_POST['order']))
// {
// 	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
// }
// else
// {
// 	$query .= 'ORDER BY c.client_id DESC ';
// }

// if($_POST['length'] != -1)
// {
// 	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
// }

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$data = array();

$filtered_rows = $statement->rowCount();

foreach($result as $row)
{
	$status = '';
	if($row['client_status'] == 'active')
	{
		//$status = '<span class="label label-success">Active</span>';
		$status ='<a href="#" class="btn btn-info btn-xs">Active</a>';
	}
	else
	{
		//$status = '<span class="label label-danger">Inactive</span>';
		$status = '<a href="#" class="btn btn-danger btn-xs">Inactive</a>';
	}
	$sub_array = array();
	$sub_array[] = $row['client_id'];
	$sub_array[] = $row['client_name'];
	$sub_array[] = $row['address1'];
	$sub_array[] = $row['created_on'];
	$sub_array[] = $row['first_sale_date'];
	$sub_array[] = $row['last_sale_date'];
	$sub_array[] = $row['due_type'];
	$sub_array[] = $status;
	$sub_array[]= '<button type="button" name="update" id="'.$row["client_id"].'" class="btn btn-primary btn-xs no"><span class="fa fa-edit"></span></button>';
	$sub_array[]= '<a href="client_details.php?view='.$row["client_id"].'" class="btn btn-info btn-xs" >Details</a>';
   
	$sub_array[]= '<button type="button" name="delete" id="'.$row["client_id"].'" class="btn btn-danger btn-xs delete" 
	data-status="'.$row["client_status"].'">Delete</button>';

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