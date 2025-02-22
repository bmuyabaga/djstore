<?php

//category_action.php
include('../../config/function.php');

    $cid = $_POST['cid'];
	$name = $_POST['product_name'];
	$qty = $_POST['qtyorder'];
	$product_code = '';
	$product_price = '';


	$query = "SELECT * FROM product WHERE product_id = '".$_POST['product_name']."'";

	    $statement = $connect->prepare($query);

        $statement->execute();

        $result = $statement->fetchAll();

        foreach ($result as $row) 
        {
        	$product_price = $row['product_base_price'];
        	$product_code = $row['product_code'];
        }




	$query1 = "SELECT * FROM temp_order WHERE product_id = '".$_POST['product_name']."'";

	    $statement = $connect->prepare($query1);

        $statement->execute();

		$filtered_rows = $statement->rowCount();


		$total = $product_price * $qty;

		if($filtered_rows>0)
		{
           $query2 = "UPDATE temp_order SET qty=qty+$qty, price=price WHERE product_id = '".$_POST['product_name']."' ";
           
          $statement = $connect->prepare($query2);

          $statement->execute();

          $result = $statement->fetchAll();
		}
		else
		{
			$query3 = "INSERT INTO temp_order (product_id,qty,price,product_code,branch_id)
            VALUES (:product_id,:qty,:price,:product_code,:branch_id)

			";

			$statement = $connect->prepare($query3);

			$statement->execute(
			array(
				':product_id'	=>	$name,
				':qty'		=>	$qty,
				':price'		=>	$product_price,
				':product_code'		=>	$product_code,	
				':branch_id'    =>  1
				
			)
				
		);

			$result = $statement->fetchAll();

		}

	

	
		 

		echo "<script>document.location='../order.php?cid=$cid'</script>"; 


?>
