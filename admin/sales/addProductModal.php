<?php

//order_action.php

include('../../config/function.php');

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
	
		
			$total_amount = 0;
			for($count = 0; $count<count($_POST["product_id"]); $count++)
			{
				$product_details = fetch_product_details($_POST["product_id"][$count],$_POST["customer_id"], $connect);
                $qty = $_POST["quantity"][$count];
                $price = $product_details['price'];
				$product_quantity = $product_details['product_quantity'];
				$product_name = $product_details['product_name'];
				$available_quantity = $product_quantity - $qty;
				if($available_quantity >= 0)
				{
					$total = $price * $qty; //echo $total;
					//select from temp_trans table
					$temp_trans_query = "SELECT * FROM temp_trans WHERE product_id = '".$_POST['product_id'][$count]."'";
					$statement = $connect->prepare($temp_trans_query);
					$statement->execute();
					$temp_trans = $statement->fetchAll();
					$temp_trans_count = $statement->rowCount();
					if($temp_trans_count > 0)
					{
						$update_temp_trans_query = "UPDATE temp_trans SET qty=qty+$qty, price=$price, total=total+$total WHERE product_id = '".$_POST['product_id'][$count]."' ";
						$statement = $connect->prepare($update_temp_trans_query);
						$statement->execute();
						$_SESSION['success'] = "Quantity Updated Successfully";
					}
					else
					{
					    $insert_temp_trans_query = "INSERT INTO temp_trans (product_id,qty,price,product_code,total,branch_id)
                    VALUES (:product_id,:qty,:price,:product_code,:total,:branch_id)
                    ";
					$statement = $connect->prepare($insert_temp_trans_query);
					$statement->execute(
						array(
							':product_code'	=>	$product_details['product_code'],
							':qty'		=>	$qty,
							':price'		=>	$price,
							':product_id'		=>	$_POST["product_id"][$count],	
							':total'		=>	$total,
							':branch_id'    =>  1
							
						)
							
					);
					$result = $statement->fetchAll();
					$_SESSION['success'] = "Product Added Successfully";


					}

				}
				else
				{
					
					$_SESSION['error'] = "Only  ".$product_quantity." quantity of ".$product_details['product_name']." Available";
					
				}
                
			

			} // end of for loop
		
		}
	

	

	
}

?>