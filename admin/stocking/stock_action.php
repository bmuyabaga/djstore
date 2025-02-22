<?php

//order_action.php

include('../../config/function.php');

if(isset($_POST['btn_action']))
{


	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "
		SELECT * FROM purchase 
		INNER JOIN vendor ON vendor.vendor_id = purchase.vendor_id

		WHERE purchase.purchase_id = :purchase_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':purchase_id'	=>	$_POST["purchase_id"]
			)
		);
		$result = $statement->fetchAll();
		$purchase_id='';
		$output = array();
		foreach($result as $row)
		{
			
			$output['vname'] = $row['vname'];
			$output['date'] = $row['date'];
			$output['total'] = $row['total'];
			$output['discount'] = $row['discount'];
			$output['grandtotal'] = $row['grandtotal'];
			$output['pay'] = $row['pay'];
			$output['balance'] = $row['balance'];
			$output['payment_type'] = $row['payment_type'];
			$output['status'] = $row['status'];
			$output['purchase_id'] = $row['purchase_id'];
			$output['vendor_id'] = $row['vendor_id'];
			$purchase_id .= '<option value="'.$row["purchase_id"].'">'.$row["purchase_id"].'(Bal  '.$row['balance'].') || '.$row['vname'].'</option>';

		}
$output['purchaseID']=$purchase_id;

		echo json_encode($output);
	}




	

	

}

?>