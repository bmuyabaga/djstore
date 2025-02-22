<?php

//brand_fetch.php

include('../../config/function.php');
$query = '';

$output = array();
$query .= "
SELECT * FROM employee 
INNER JOIN department ON department.department_id = employee.department_id
INNER JOIN position ON position.position_id = employee.position_id
INNER JOIN tribe ON tribe.tribe_id = employee.tribe_id
INNER JOIN regions ON regions.region_id = employee.region_id
INNER JOIN branch ON branch.branch_id = employee.branch_id
INNER JOIN country ON country.country_id = employee.country_id

";

if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE employee.emp_id LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR employee.first_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR employee.last_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR department.department_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR employee.salary LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR employee.join_date LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR employee.dob LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR employee.end_date LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR employee.sex LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR position.position_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR employee.status LIKE "%'.$_POST["search"]["value"].'%" ';
}

if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY emp_id DESC ';
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
	$sub_array[] = $row['emp_id'];
	$sub_array[] = $row['first_name'];
	$sub_array[] = $row['last_name'];
	$sub_array[] = $row['department_name'];
	$sub_array[] = $row['salary'];
	$sub_array[] = $row['join_date'];
	$sub_array[] = $row['dob'];
	$sub_array[] = $row['end_date'];
	$sub_array[] = $row['position_name'];
	$sub_array[] = $row['sex'];
	$sub_array[] = $status;
	$sub_array[] = '<button type="button" name="update" id="'.$row["emp_id"].'" class="btn btn-primary btn-xs update">Update</button>';
	
	$sub_array[] = '<button type="button" name="delete" id="'.$row["emp_id"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["status"].'">Delete</button>';
	$data[] = $sub_array;
}

function get_total_all_records($connect)
{
	$statement = $connect->prepare('SELECT * FROM employee');
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