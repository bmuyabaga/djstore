
<?php

include('../../config/function.php');
    $id = $_POST['id'];
	//$qty =$_POST['qty'];
	$cid =$_POST['cid'];

	 $query = "DELETE FROM temp_purchase  WHERE  temp_purchase_id = $id ";
           
          $statement = $connect->prepare($query);

          $statement->execute();

          $result = $statement->fetchAll();

		 
		  echo "<script>document.location='../purchase_invoice_create.php?vid=$cid'</script>"; 

	

?>