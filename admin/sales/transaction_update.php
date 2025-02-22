<?php

//category_action.php
include('../../config/function.php');

   $id = $_POST['id'];
	$qty =$_POST['qty'];
	$cid =$_POST['cid'];

	 $query = "UPDATE temp_trans SET qty='".$_POST['qty']."' WHERE  temp_trans_id = '".$_POST['id']."' ";
           
          $statement = $connect->prepare($query);

          $statement->execute();

          $result = $statement->fetchAll();
          if(isset($result))
          {
             $_SESSION['success'] = "Transaction Updated";
          	 echo "<script>document.location='../new_invoice.php?cid=$cid'</script>"; 
          }
          else
          {  
            $_SESSION['error'] = "Transaction Not Updated";
          	 echo "<script>document.location='../new_invoice.php?cid=$cid'</script>"; 
          }

		 

	

?>
