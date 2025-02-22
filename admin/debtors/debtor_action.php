<?php

//order_action.php

include('../../config/function.php');

if(isset($_POST['btn_action']))
{
	

	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "
		SELECT * FROM sales 
		INNER JOIN client ON client.client_id = sales.client_id

		WHERE sales.client_id = :client_id AND sales.pay != sales.grandtotal
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':client_id'	=>	$_POST["client_id"]
			)
		);
		$result = $statement->fetchAll();
		//$sales_id='';
		$deni='';
		$output = array();
		foreach($result as $row)
		{
			
			$output['client_name'] = $row['client_name'];
			$output['date'] = $row['date'];
			$output['total'] = $row['total'];
			$output['discount'] = $row['discount'];
			$output['grandtotal'] = $row['grandtotal'];
			$output['pay'] = $row['pay'];
			$output['balance'] = $row['balance'];
			$output['payment_type'] = $row['payment_type'];
			$output['status'] = $row['status'];
			$output['sales_id'] = $row['sales_id'];
			$output['client_id'] = $row['client_id'];
			//$sales_id .= '<option value="'.$row["sales_id"].'">'.$row["sales_id"].'(Bal  '.$row['balance'].') || '.$row['client_name'].'</option>';
			//$deni .= '<option value="">Please Select Invoice</option>';
			$deni .= '<option value="'.$row["sales_id"].'">'.$row["sales_id"].'(Bal  '.$row['balance'].') || '.$row['client_name'].'</option>';

		}

	// $query = "
	// SELECT * FROM sales 
	// WHERE product_status = 'active' 
	// ORDER BY product_name ASC
	// ";
	// $statement = $connect->prepare($query);
	// $statement->execute();
	// $result = $statement->fetchAll();
	// $output = '';
	// foreach($result as $row)
	// {
	// 	$output .= '<option value="'.$row["product_code"].'">'.$row["product_name"].'</option>';
	// }
	// return $output;

$output['deni']=$deni;


		echo json_encode($output);
	}






}

?>