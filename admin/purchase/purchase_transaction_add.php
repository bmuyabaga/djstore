<?php

//category_action.php
include('../../config/function.php');

    $cid = $_POST['cid'];
	$product_id = $_POST['productId'];
	$qty = $_POST['qty'];
	$barcode = '';
	$product_price = $_POST['price'];


	$queryinput = "SELECT * FROM product WHERE product_id = '".$_POST['productId']."' ";

	    $statement = $connect->prepare($queryinput);

        $statement->execute();

        $result = $statement->fetchAll();

        foreach ($result as $row) 
        {
        	//$product_price = $row['price'];
        	$product_code = $row['product_code'];
        }




	$query1 = "SELECT * FROM  temp_purchase WHERE product_id = '".$_POST['productId']."'";

	    $statement = $connect->prepare($query1);

        $statement->execute();

		$filtered_rows = $statement->rowCount();


		$total = $product_price * $qty;

		if($filtered_rows>0)
		{
           $query2 = "UPDATE  temp_purchase SET qty=qty+$qty, price=price WHERE product_id = '".$_POST['productId']."' ";
           
          $statement = $connect->prepare($query2);

          $statement->execute();

          $result = $statement->fetchAll();
		}
		else
		{
			$query3 = "INSERT INTO  temp_purchase (product_id,qty,price,product_code,branch_id)
            VALUES (:product_id,:qty,:price,:product_code,:branch_id)

			";

			$statement = $connect->prepare($query3);

			$statement->execute(
			array(
				':product_id'	=>	$product_id,
				':qty'		=>	$qty,
				':price'		=>	$product_price,
				':product_code'		=>	$product_code,	
				':branch_id'    =>  1
				
			)
				
		);

			$result = $statement->fetchAll();

		}

		echo "<script>document.location='../purchase_invoice_create.php?vid=$cid'</script>"; 





?>
