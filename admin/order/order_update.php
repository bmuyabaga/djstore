<?php

//category_action.php
include('../../config/function.php');

   $id = $_POST['id'];
	$qty =$_POST['qtyorder'];
	$cid =$_POST['cid'];

	 $query = "UPDATE temp_order SET qty='".$_POST['qtyorder']."' WHERE  temp_order_id = '".$_POST['id']."' ";
           
          $statement = $connect->prepare($query);

          $statement->execute();

          $result = $statement->fetchAll();

		 echo "<script>document.location='../order.php?cid=$cid'</script>"; 

	

?>
