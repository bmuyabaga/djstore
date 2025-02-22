<?php
include('../config/function.php');


if(isset($_POST['update_client']))
{
  $clientId=$_POST['client_idd'];
  $oldimage=$_POST['oldimage'];
 

  if(isset($_FILES['image1']['name']) && ($_FILES['image1']['name']!=""))
  {
       $newimage="image_client/".$_FILES['image1']['name'];
       unlink($oldimage);
       move_uploaded_file($_FILES['image1']['tmp_name'], $newimage);
  }
  else
  {
    $newimage=$oldimage;
  }


  $query = "
   UPDATE client SET 
                  
                
                       
                       client_name = :client_name,
                       city = :city,
                       address1 = :address1,
                       address2 = :address2,
                       due_days = :due_days,
                       due_type = :due_type,
                       max_credit = :max_credit,
                       tin_no = :tin_no,
                       vrn = :vrn,
                       country = :country,
                       post_code = :post_code,
                       
                       photo = :photo,
                       notes = :notes
                   
   WHERE client_id = :client_id
   ";

$statement = $connect->prepare($query);
   $statement->execute(
     array(
        

       ':client_name' => $_POST['client_name1'],
                ':city' => $_POST['city1'],
                ':address1' => $_POST['address1'],
                ':address2' => $_POST['address2'],
                ':due_days' => $_POST['due_days'],
                ':due_type' => $_POST['due_type'],
                ':max_credit' => $_POST['max_credit'],
                ':tin_no' => $_POST['tin1'],
                ':vrn' => $_POST['vrn1'],
                ':country' => $_POST['country1'],
                ':post_code' => $_POST['post_code'],
                ':photo' => $newimage,
                ':notes' => $_POST['notes1'], 
                ':client_id'=> $_POST["client_idd"]
     )
   );
$result = $statement->fetchAll();


$_SESSION['response']='Client is successfully updated';
$_SESSION['res_type']='primary';

header('location: client.php');

}
 
  



















?>