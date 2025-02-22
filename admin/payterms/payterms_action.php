<?php

//contact_action.php

include('../../config/function.php');
date_default_timezone_set("Africa/Dar_es_Salaam");
if(isset($_POST['btn_action_credit']))
{
   
	if ($_POST['btn_action_credit'] == 'Add') {
      $check_client = "SELECT * FROM credit_settings WHERE client_id = :client_id";
      $statement = $connect->prepare($check_client);
      $statement->execute([':client_id' => $_POST['cid']]);
      $count = $statement->rowCount();
      if ($count > 0) {
          echo 'Client already exists in the database.';
      } 
      else 
      {
          // Continue with the insertion process
           // Debugging: Log the request to ensure 'Add' is received
        error_log("Button action received: " . $_POST['btn_action']);
        
        // SQL query
        $query = "
            INSERT INTO credit_settings (
                client_id, max_credit, payterms, days, user_id, credit_status, created_at
            ) 
            VALUES (
                :client_id, :max_credit, :payterms, :days, :user_id, :credit_status, :created_at
            )
        ";
    
        // Prepare statement
        $statement = $connect->prepare($query);
    
        // Execute statement with sanitized input
        $success = $statement->execute([
            ':client_id'     => htmlspecialchars($_POST["cid"]),
            ':max_credit'           => htmlspecialchars($_POST["max_credit"]),
            ':payterms'    => htmlspecialchars($_POST["payterms"]),
            ':days'    => htmlspecialchars($_POST["days"]),
            ':user_id'         => $_SESSION["user_id"], // Assuming session is properly started
            ':credit_status'  => 'Enable',
            ':created_at' => date('Y-m-d H:i:s')
        ]);
    
        // Check if the insertion was successful
        if ($success) {
            echo 'Payterms  Added';
        } else {
            echo 'Failed to add Payterms. Please try again.';
        }
      }

       
    }
    else
    {
        echo "Invalid action.";
    }
    
	
	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "SELECT * FROM contacts WHERE contact_id = :contact_id";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':contact_id'	=>	$_POST["contact_id"]
			)
		);
		$result = $statement->fetchAll();
        $output = '';
		foreach($result as $row)
		{
			//$output['category_name'] = $row['category_name'];
            $output["contact_id"] = $row["contact_id"];
            $output["title"] = $row["title"];
            $output["contacts_name"] = $row["contact_name"];
            $output["contacts_number"] = $row["phone_number"];
            $output["contacts_number2"] = $row["phone2"];
            $output["contacts_email"] = $row["email_address"];
            $output["contacts_email2"] = $row["email2"];
            $output["contacts_position"] = $row["position_id"];
            $output["contacts_notes"] = $row["comments"];
    
		}
		echo json_encode($output);
	}

    // if ($_POST['btn_action'] == 'fetch_single') {
    //     // Query to fetch single contact details
    //     $query = "SELECT * FROM contacts WHERE contact_id = :contact_id";
    //     $statement = $connect->prepare($query);
    
    //     $statement->execute(
    //         array(':contact_id' => $_POST["contact_id"])
    //     );
    
    //     $result = $statement->fetch(PDO::FETCH_ASSOC); // Fetch single row as an associative array
    
    //     if ($result) {
    //         // Return JSON response
    //         $output = array(
    //             "contact_id" => $result["contact_id"],
    //             "title" => $result["title"],
    //             "contacts_name" => $result["contact_name"],
    //             "contacts_number" => $result["phone_number"],
    //             "contacts_number2" => $result["phone2"],
    //             "contacts_email" => $result["email_address"],
    //             "contacts_email2" => $result["email2"],
    //             "contacts_position" => $result["position_id"],
    //             "contacts_notes" => $result["comments"]
    //         );
    //         echo json_encode($output);
    //     } else {
    //         echo json_encode([]);
    //     }
    // }
    

	if($_POST['btn_action'] == 'Edit')
	{
		$query = "
		UPDATE category set category_name = :category_name  
		WHERE category_id = :category_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':category_name'	=>	$_POST["category_name"],
				':category_id'		=>	$_POST["category_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Category Name Edited';
		}
	}
	if($_POST['btn_action'] == 'delete')
	{
		$status = 'active';
		if($_POST['status'] == 'active')
		{
			$status = 'inactive';	
		}
		$query = "
		UPDATE category 
		SET category_status = :category_status 
		WHERE category_id = :category_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':category_status'	=>	$status,
				':category_id'		=>	$_POST["category_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Category status change to ' . $status;
		}
	}
}
else
{
      // Debugging: Handle cases where btn_action is not set
      error_log("btn_action not set in POST request");
}

?>