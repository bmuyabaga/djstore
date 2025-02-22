<?php
include('../config/function.php');

  
  $output="";
  
    if(isset($_POST['client_action']))
    {
    	$photo = $_FILES['image']['name'];
	    $upload = "image_client/".$photo;





		$query = "
		INSERT INTO client (client_name,city,address1,address2,due_days,due_type,max_credit,tin_no,vrn,country,post_code,notes,user_id,photo) 
		VALUES (:client_name,:city,:address1,:address2,:due_days,:due_type,:max_credit,:tin_no,:vrn,:country,:post_code,:notes,:user_id,:photo)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':client_name'	=>	$_POST["client_name"],
				':city'	=>	$_POST["city"],
				':address1'	=>	$_POST["addressone"],
				':address2'	=>	$_POST["addresstwo"],
				':due_days'	=>	$_POST["duedays"],
				':due_type'	=>	$_POST["duetype"],
				':max_credit'	=>	$_POST["maxcredit"],
				':tin_no'	=>	$_POST["tin"],
				':vrn'	=>	$_POST["vrn"],
				':country'	=>	$_POST["country"],
				':post_code'	=>	$_POST["postcode"], 
				':notes'	=>	$_POST["notes"],
				':user_id'	=>	$_SESSION['user_id'],
				':photo'	=>	$upload
				
			
			)
		);
		$result = $statement->fetchAll();
		move_uploaded_file($_FILES['image']['tmp_name'], $upload);

	
header('location: client.php');

$_SESSION['response']='New Client Added';
$_SESSION['res_type']='success';



    }


   $response=array(

      'output'=>$output
   );

   echo json_encode($response);

















?>