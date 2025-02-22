<?php

//order_action.php

include('../config/function.php');;

if(isset($_POST['btn_action']))
{
	

	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "
		SELECT * FROM sales 
		INNER JOIN client ON client.client_id = sales.client_id

		WHERE sales.sales_id = :sales_id AND client.client_id = :client_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':sales_id'	=>	$_POST["sales_id"],
				':client_id' => $_POST["client_id"]
			)
		);
		$result = $statement->fetchAll();
		$sales_id='';
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
			$sales_id .= '<option value="'.$row["sales_id"].'">'.$row["sales_id"].'(Bal  '.$row['balance'].') || '.$row['client_name'].'</option>';

		}
$output['sales_iddeni']=$sales_id;

		echo json_encode($output);
	}






	

	
	
}

?>