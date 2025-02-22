<?php

//category_action.php
include('../../config/function.php');



   $id = $_POST['id'];
	$qty =$_POST['qty'];
	$cid =$_POST['cid'];
	//$cid =$_POST['cid'];

	 $query = "UPDATE temp_purchase SET qty='".$_POST['qty']."' WHERE  temp_purchase_id = '".$_POST['id']."' ";
           
          $statement = $connect->prepare($query);

          $statement->execute();

          $result = $statement->fetchAll();

		 echo "<script>document.location='../purchase_invoice_create.php?vid=$cid'</script>"; 

	

?>