<?php

//order_fetch.php

include('../../config/function.php');

$query = '';

$output = array();

$query .= "
	SELECT * FROM debit_note
    
    INNER JOIN client ON client.client_id=debit_note.client_id INNER JOIN user_details ON user_details.user_id=debit_note.user_id WHERE
	
";

if($_SESSION['type'] == 'user')
{
	$query .= 'debit_note.user_id = "'.$_SESSION["user_id"].'" AND  ';
}

if(isset($_POST["search"]["value"]))
{
	$query .= '(debit_note.debitnote_id LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR debit_note.sales_id LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR debit_note.zfda_invoice_number LIKE "%'.$_POST["search"]["value"].'%" ';
	//$query .= 'OR debit_note.invoice_pdf LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR debit_note.createdate LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR client.client_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR debit_note.amount LIKE "%'.$_POST["search"]["value"].'%") ';
	$query .= 'OR debit_note.debitnote_status LIKE "%'.$_POST["search"]["value"].'%" ';
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
	$query .= 'ORDER BY debit_note.debitnote_id DESC ';
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
	if($row['debitnote_status'] == 'active')
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
	$sub_array[] = $row['debitnote_id'];
	$sub_array[] = $row['sales_id'];
	$sub_array[] = $row['zfda_invoice_number'];
	//$sub_array[] = $row['invoice_pdf'];
	$sub_array[] = '<a href="'.$row['invoice_pdf'].'" class="btn btn-danger btn-xs">Download</a>';
	$sub_array[] = $row['createdate'];
	$sub_array[] = $row['client_name'];
	$sub_array[] = $row['amount'];
	$sub_array[] = $status;
		
	if($_SESSION['type'] == 'master')
	{
		$sub_array[] =  $row['user_name'];
	}
	//$sub_array[] = '<a href="invoice.php?view='.$row["sales_id"].'" class="btn btn-info btn-xs"><i class="fas fa-file-invoice"></i></a>';
	$sub_array[] = '<a href="debitnote_print.php?pdf=1&debitnoteid='.$row["debitnote_id"].'" class="btn btn-info btn-xs"><i class="fas fa-download"></i></a>';
	$sub_array[] = '<button type="button" name="update" id="'.$row["debitnote_id"].'" class="btn btn-warning btn-xs update"><i class="fas fa-dollar-sign"></i></button>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["debitnote_id"].'" class="btn btn-danger btn-xs delete" 
	data-status="'.$row["debitnote_status"].'"><i class="fas fa-trash"></i></button>';
	$data[] = $sub_array;
}

function get_total_all_records($connect)
{
	$statement = $connect->prepare("SELECT * FROM debit_note");
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