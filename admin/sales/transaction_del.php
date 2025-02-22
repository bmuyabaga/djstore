
<?php

include('../../config/function.php');

    $id = $_POST['id'];
	//$qty =$_POST['qty'];
	$cid =$_POST['cid'];

	 $query = "DELETE FROM temp_trans  WHERE  temp_trans_id = $id ";
           
          $statement = $connect->prepare($query);

          $statement->execute();

          $result = $statement->fetchAll();

          if(isset($result))
          {
            $_SESSION['success'] = 'Transaction Deleted Successfully';
            echo "<script>document.location='../new_invoice.php?cid=$cid'</script>"; 
          }
          else
          {
            $_SESSION['error'] = 'Transaction Deleted Failed';
            echo "<script>document.location='../new_invoice.php?cid=$cid'</script>"; 
          }

		 
		 

	

?>