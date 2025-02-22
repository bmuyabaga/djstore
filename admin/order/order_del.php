
<?php

include('../../config/function.php');

    $id = $_POST['id'];
	//$qty =$_POST['qty'];
	$cid =$_POST['cid'];

	 $query = "DELETE FROM temp_order  WHERE  temp_order_id = $id ";
           
          $statement = $connect->prepare($query);

          $statement->execute();

          $result = $statement->fetchAll();

		 
		  echo "<script>document.location='../order.php?cid=$cid'</script>"; 

	

?>