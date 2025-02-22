	
<?php

include('../config/function.php');


	$queryDelete = "DELETE FROM temp_purchase WHERE branch_id=1

	";

	$statementR = $connect->prepare($queryDelete);
		$result = $statementR->execute();
		$result=$statementR->fetchAll();
 echo "<script>document.location='index.php'</script>";  

?>