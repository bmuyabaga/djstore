<?php

//category_action.php

include('../../config/function.php');
date_default_timezone_set("Africa/Dar_es_Salaam"); 
if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
        $date_time = date("Y-m-d H:i:s");
        $querySelect = "SELECT * FROM tax WHERE tax_name = :tax_name";
        $statement = $connect->prepare($querySelect);
        $statement->execute(
            array(
                ':tax_name'	=>	$_POST["tax_name"]
            )
        );
        $count = $statement->rowCount();
        if($count > 0)
        {
            echo 'Tax Name Already Exists';
        }
        else
        {
            $query = "
            INSERT INTO tax (tax_name, tax_percentage, tax_status, tax_added_on, tax_updated_on) 
            VALUES (:tax_name, :tax_percentage, :tax_status, :tax_added_on, :tax_updated_on)
            ";
            $statement = $connect->prepare($query);
            $statement->execute(
                array(
                    ':tax_name'	=>	$_POST["tax_name"],
                    ':tax_percentage'	=>	$_POST["tax_percentage"],
                    ':tax_status'	=>	'Enable',
                    ':tax_added_on'	=>	$date_time,
                    ':tax_updated_on'	=>	$date_time
                )
            );
            $result = $statement->fetchAll();
            if(isset($result))
            {
                echo 'Tax Name Added';
            }
        }

	}
	
	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "SELECT * FROM tax WHERE tax_id = :tax_id";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':tax_id'	=>	$_POST["tax_id"]
			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['tax_name'] = $row['tax_name'];
			$output['tax_percentage'] = $row['tax_percentage'];
		}
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'Edit')
	{
		$query = "
		UPDATE tax set tax_name = :tax_name, 
        tax_percentage = :tax_percentage
		WHERE tax_id = :tax_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':tax_name'	=>	$_POST["tax_name"],
				':tax_percentage'	=>	$_POST["tax_percentage"],
				':tax_id'	=>	$_POST["tax_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Tax Name Edited';
		}
	}
	if($_POST['btn_action'] == 'delete')
	{
		$status = 'Enable';
		if($_POST['status'] == 'Enable')
		{
			$status = 'Disable';	
		}
		$query = "
		UPDATE tax 
		SET tax_status = :tax_status 
		WHERE tax_id = :tax_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':tax_status'	=>	$status,
				':tax_id'		=>	$_POST["tax_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Tax status change to ' . $status;
		}
	}
}

?>