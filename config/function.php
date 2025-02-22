<?php
//function.php
require 'database_connection.php';
session_start();
// Function to return json response
function jsonResponse($status,$status_type,$message)
{
   $response = [
    'status'  =>  $status,
    'status_type'  => $status_type,
    'message'    => $message
   ];

   echo json_encode($response);
   return;

}

function fill_category_list($connect)
{
	$query = "
	SELECT * FROM category 
	WHERE category_status = 'active' 
	ORDER BY category_name ASC
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["category_id"].'">'.$row["category_name"].'</option>';
	}
	return $output;
}

//Total revenue and percentage
function daily_sales($connect)
{
	$today = date('Y-m-d');
	$query = "
	SELECT sum(grandtotal) as total_revenue FROM sales
	WHERE status = 'active' and DATE(date)  = '".$today."'

	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$total_revenue = $row["total_revenue"];
		$total_revenue = $total_revenue ? $total_revenue : 0;
		return number_format($total_revenue);
		
	}
}

function weekly_sales($connect)
{
	
	$query = "
	SELECT sum(grandtotal) as total_sales FROM sales
	WHERE WEEK(date, 1) = WEEK(CURRENT_DATE(), 1) AND YEAR(date) = YEAR(CURRENT_DATE()) AND status = 'active'
	

	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$row_count = $statement->rowCount();
	if($row_count > 0)
	{
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$total_sales = $row["total_sales"];
			$total_sales = $total_sales ? $total_sales : 0;
			return number_format($total_sales);
		}
	}
}

function monthly_sales($connect)
{
	
	$query = "
	SELECT  sum(grandtotal) as total_sales FROM sales
	WHERE MONTH(date) = MONTH(CURRENT_DATE()) and status = 'active'
	

	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$row_count = $statement->rowCount();
	if($row_count > 0)
	{
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$total_sales = $row["total_sales"];
			$total_sales = $total_sales ? $total_sales : 0;
			return number_format($total_sales);
		}
	}
}

function yearly_sales($connect)
{
	
	$query = "
	SELECT  sum(grandtotal) as total_sales FROM sales
	WHERE YEAR(date) = YEAR(CURRENT_DATE()) and status = 'active'
	

	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$row_count = $statement->rowCount();
	if($row_count > 0)
	{
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$total_sales = $row["total_sales"];
			$total_sales = $total_sales ? $total_sales : 0;
			return number_format($total_sales);
		}
	}
}


function fill_expense_account_list($connect)
{
	$query = "
	SELECT * FROM expaccount 
	WHERE status = 'active' 
	ORDER BY expense_account ASC
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["expenseaccount_id"].'">'.$row["expense_account"].'</option>';
	}
	return $output;
}


function fill_brand_list($connect, $category_id)
{
	$query = "SELECT * FROM brand 
	WHERE brand_status = 'active' 
	AND category_id = '".$category_id."'
	ORDER BY brand_name ASC";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '<option value="">Select Brand</option>';
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["brand_id"].'">'.$row["brand_name"].'</option>';
	}
	return $output;
}

function fill_client_list($connect)
{
	$query = "SELECT * FROM client 
	WHERE client_status = 'active' 
	
	ORDER BY client_name ASC";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '<option value="">Select Client</option>';
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["client_id"].'">'.$row["client_name"].'</option>';
	}
	return $output;
}


function fill_supplier_list($connect)
{
	$query = "SELECT * FROM vendor
	WHERE status = 'active' 
	
	ORDER BY vname ASC";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	//$output = '<option value="">Select Supplier</option>';
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["vendor_id"].'">'.$row["vname"].'</option>';
	}
	return $output;
}


function fill_department_list($connect)
{
	$query = "SELECT * FROM department
	WHERE status = 'active' 
	
	ORDER BY department_name ASC";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	//$output = '<option value="">Select Supplier</option>';
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["department_id"].'">'.$row["department_name"].'</option>';
	}
	return $output;
}


function fill_position_list($connect)
{
	$query = "SELECT * FROM position
	WHERE status = 'active' 
	
	ORDER BY position_name ASC";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["position_id"].'">'.$row["position_name"].'</option>';
	}
	return $output;
}

function fill_tribe_list($connect)
{
	$query = "SELECT * FROM tribe
	WHERE tribe_status = 'active' 
	
	ORDER BY tribe_name ASC";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	//$output = '<option value="">Select Supplier</option>';
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["tribe_id"].'">'.$row["tribe_name"].'</option>';
	}
	return $output;
}

function fill_region_list($connect)
{
	$query = "SELECT * FROM regions
	WHERE region_status = 'active' 
	
	ORDER BY region_name ASC";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	//$output = '<option value="">Select Supplier</option>';
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["region_id"].'">'.$row["region_name"].'</option>';
	}
	return $output;
}

function fill_country_list($connect)
{
	$query = "SELECT * FROM country
	WHERE country_status = 'active' 
	
	ORDER BY country_name ASC";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	//$output = '<option value="">Select Supplier</option>';
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["country_id"].'">'.$row["country_name"].'</option>';
	}
	return $output;
}


function fill_employee_list($connect)
{
	$query = "SELECT * FROM employee
	WHERE status = 'active' 
	
	ORDER BY first_name ASC";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	//$output = '<option value="">Select Supplier</option>';
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["emp_id"].'">'.$row["first_name"].'</option>';
	}
	return $output;
}







function get_user_name($connect, $user_id)
{
	$query = "
	SELECT user_name FROM user_details WHERE user_id = '".$user_id."'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return $row['user_name'];
	}
}

function fill_product_list($connect)
{
	$query = "
	SELECT * FROM product 
	WHERE product_quantity > 0 AND product_status = 'active' 
	ORDER BY product_name ASC
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["product_id"].'">'.$row["product_name"].'</option>';
	}
	return $output;
}


function fill_product_list2($connect)
{
	$query = "
	SELECT * FROM product 
	
	ORDER BY product_name ASC
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		//$output .= '<option value="'.$row["product_id"].'">'.$row["product_name"].'</option>';
		$output .= '<option value="'.$row["product_code"].'">'.$row["product_name"].'(Available  '.$row['product_quantity'].') || (code '.$row['product_code'].')</option>';
	}
	return $output;
}




function fill_product_listII($connect)
{
	$query = "
	SELECT * FROM product 
	WHERE product_status = 'active' 
	ORDER BY product_name ASC
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["product_code"].'">'.$row["product_name"].'</option>';
	}
	return $output;
}

// function fetch_product_details($product_id, $connect)
// {
// 	$query = "
// 	SELECT * FROM product 
// 	WHERE product_id = '".$product_id."'";
// 	$statement = $connect->prepare($query);
// 	$statement->execute();
// 	$result = $statement->fetchAll();
// 	foreach($result as $row)
// 	{
// 		$output['product_name'] = $row["product_name"];
// 		$output['quantity'] = $row["product_quantity"];
// 		$output['price'] = $row['product_base_price'];
// 		$output['tax'] = $row['product_tax'];
// 	}
// 	return $output;
// }

function fetch_product_details($product_id,$customer_id, $connect)
{
	$query = "SELECT * FROM custom_price WHERE client_id = '".$customer_id."' AND product_id = '".$product_id."' ";

	    $statement = $connect->prepare($query);

        $statement->execute();
		$count = $statement->rowCount();
		if($count > 0)
		{
			// fetch product_quantity from product table
			$query_product_qty = "SELECT product_quantity,product_name FROM product WHERE product_id = '".$product_id."' ";
			$statement_product_qty = $connect->prepare($query_product_qty);
			$statement_product_qty->execute();
			$result_product_qty = $statement_product_qty->fetchAll();
			$product_quantity = '';
			$product_name = '';
			foreach($result_product_qty as $row_product_qty)
			{
				$product_quantity = $row_product_qty['product_quantity'];
				$product_name = $row_product_qty['product_name'];
			}
			
			$result = $statement->fetchAll();
			foreach($result as $row)
			{
				$output['product_code'] = $row["product_code"];
				$output['price'] = $row['price'];
				$output['product_quantity'] = $product_quantity;
				$output['product_name'] = $product_name;
				
			}
			return $output;	
		}
		else
		{
			$query = "
			SELECT * FROM product 
			WHERE product_id = '".$product_id."'
			";
			$statement = $connect->prepare($query);
			$statement->execute();
			$result = $statement->fetchAll();
			foreach($result as $row)
			{
		
				$output['product_code'] = $row["product_code"];
				$output['price'] = $row['product_base_price'];
				$output['product_quantity'] = $row['product_quantity'];
				$output['product_name'] = $row['product_name'];
			
			}
			return $output;	    
		}


}

function available_product_quantity($connect, $product_id)
{
	$product_data = fetch_product_details($product_id, $connect);
	$query = "
	SELECT 	inventory_order_product.quantity FROM inventory_order_product 
	INNER JOIN inventory_order ON inventory_order.inventory_order_id = inventory_order_product.inventory_order_id
	WHERE inventory_order_product.product_id = '".$product_id."' AND
	inventory_order.inventory_order_status = 'active'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total = 0;
	foreach($result as $row)
	{
		$total = $total + $row['quantity'];
	}
	$available_quantity = intval($product_data['quantity']) - intval($total);
	if($available_quantity == 0)
	{
		$update_query = "
		UPDATE product SET 
		product_status = 'inactive' 
		WHERE product_id = '".$product_id."'
		";
		$statement = $connect->prepare($update_query);
		$statement->execute();
	}
	return $available_quantity;
}

function count_total_user($connect)
{
	$query = "
	SELECT * FROM user_details WHERE user_status='active'";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

function count_total_category($connect)
{
	$query = "
	SELECT * FROM category WHERE category_status='active'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

function count_total_brand($connect)
{
	$query = "
	SELECT * FROM brand WHERE brand_status='active'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

function count_total_product($connect)
{
	$query = "
	SELECT * FROM product WHERE product_status='active'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

function count_total_order_value($connect)
{
	$query = "
	SELECT sum(grandtotal) as total_order_value FROM sales 
	WHERE status='active'
	";
	if($_SESSION['type'] == 'user')
	{
		$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	}
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return number_format($row['total_order_value'], 2);
	}
}

//NMB BANK
function count_total_nmb_value($connect)
{

  $deposit='';
  $withdraw='';

  $netnmbtotal='';

	$query = "
	SELECT sum(amount) as total_nmb_deposit FROM nmb 
	WHERE transaction = 'deposit' AND bank_type='nmb' AND status='active'
	";
	if($_SESSION['type'] == 'user')
	{
		$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	}
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$deposit=$row['total_nmb_deposit'];
	}


		$query = "
	SELECT sum(amount) as total_nmb_withdraw FROM nmb 
	WHERE transaction = 'withdraw' AND bank_type='nmb' AND status='active'
	";
	if($_SESSION['type'] == 'user')
	{
		$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	}
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$withdraw=$row['total_nmb_withdraw'];
	}

	$netnmbtotal = $deposit-$withdraw;
	return number_format($netnmbtotal, 2);
}


//CRDB BANK
function count_total_crdb_value($connect)
{

  $deposit='';
  $withdraw='';
  $netnmbtotal='';

	$query = "
	SELECT sum(amount) as total_crdb_deposit FROM nmb 
	WHERE transaction = 'deposit' AND bank_type='crdb' AND status='active'
	";
	if($_SESSION['type'] == 'user')
	{
		$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	}
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$deposit=$row['total_crdb_deposit'];
	}


		$query = "
	SELECT sum(amount) as total_crdb_withdraw FROM nmb 
	WHERE transaction = 'withdraw' AND bank_type='crdb' AND status='active'
	";
	if($_SESSION['type'] == 'user')
	{
		$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	}
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$withdraw=$row['total_crdb_withdraw'];
	}

	$netnmbtotal = $deposit-$withdraw;
	return number_format($netnmbtotal, 2);
}



function count_totalnmbvalue($connect)
{

  $deposit='';
  $withdraw='';
  
  $netnmbtotal='';

	$query = "
	SELECT sum(amount) as totalnmbdeposit FROM nmb 
	WHERE transaction = 'deposit' AND bank_type='nmb' AND status='active'
	";
	if($_SESSION['type'] == 'user')
	{
		$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	}
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return number_format($row['totalnmbdeposit'],2);
	}


	
}


function count_totalnmbwithvalue($connect)
{

  $deposit='';
  $withdraw='';
  
  $netnmbtotal='';

		$query = "
	SELECT sum(amount) as totalnmbwithdraw FROM nmb 
	WHERE transaction = 'withdraw' AND bank_type='nmb' AND status='active'
	";
	if($_SESSION['type'] == 'user')
	{
		$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	}
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return number_format($row['totalnmbwithdraw'],2);
	}



	
}




function count_totalcrdbvalue($connect)
{

  	$query = "
	SELECT sum(amount) as totalcrdbdeposit FROM nmb 
	WHERE transaction = 'deposit' AND bank_type='crdb' AND status='active'
	";
	if($_SESSION['type'] == 'user')
	{
		$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	}
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		
		return number_format($row['totalcrdbdeposit'],2);
	}


	
}


function count_totalcrdbwithvalue($connect)
{


		$query = "
	SELECT sum(amount) as totalcrdbwithdraw FROM nmb 
	WHERE transaction = 'withdraw' AND bank_type='crdb' AND status='active'
	";
	if($_SESSION['type'] == 'user')
	{
		$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	}
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		
		return number_format($row['totalcrdbwithdraw'],2);
	}



	
}






function count_total_cash_order_value($connect)
{
	$query = "
	SELECT sum(inventory_order_total) as total_order_value FROM inventory_order 
	WHERE payment_status = 'cash' 
	AND inventory_order_status='active'
	";
	if($_SESSION['type'] == 'user')
	{
		$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	}
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return number_format($row['total_order_value'], 2);
	}
}

function count_total_credit_order_value($connect)
{
	$query = "
	SELECT sum(inventory_order_total) as total_order_value FROM inventory_order WHERE payment_status = 'credit' AND inventory_order_status='active'
	";
	if($_SESSION['type'] == 'user')
	{
		$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	}
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return number_format($row['total_order_value'], 2);
	}
}

function get_user_wise_total_order($connect)
{
	$query = '
	SELECT sum(sales.grandtotal) as order_total, 
	SUM(CASE WHEN sales.payment_type = "paid" THEN sales.grandtotal ELSE 0 END) AS cash_order_total, 
	SUM(CASE WHEN sales.payment_type = "unpaid" THEN sales.grandtotal ELSE 0 END) AS credit_order_total, 
	user_details.user_name 
	FROM sales 
	INNER JOIN user_details ON user_details.user_id = sales.user_id 
	WHERE sales.status = "active" GROUP BY sales.user_id
	';
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '
	<div class="table-responsive">
		<table class="table table-bordered table-striped">
			<tr>
				<th>User Name</th>
				<th>Total Order Value</th>
				<th>Total Paid Order</th>
				<th>Total Unpaid Order</th>
				
			</tr>
	';

	$total_order = 0;
	$total_cash_order = 0;
	$total_credit_order = 0;
	foreach($result as $row)
	{
		$output .= '
		<tr>
			<td>'.$row['user_name'].'</td>
			<td align="right">TZS '.$row["order_total"].'</td>
			<td align="right">TZS '.$row["cash_order_total"].'</td>
			<td align="right">TZS '.$row["credit_order_total"].'</td>
		</tr>
		';

		$total_order = $total_order + $row["order_total"];
		$total_cash_order = $total_cash_order + $row["cash_order_total"];
		$total_credit_order = $total_credit_order + $row["credit_order_total"];
	}
	$output .= '
	<tr>
		<td align="right"><b>Total</b></td>
		<td align="right"><b>TZS '.$total_order.'</b></td>
		<td align="right"><b>TZS '.$total_cash_order.'</b></td>
		<td align="right"><b>TZS '.$total_credit_order.'</b></td>
	</tr></table></div>
	';
	return $output;
}



// ALL CASH

function count_total_cash_value($connect)
{
	$query = "
	SELECT sum(paid) as total_cash_value FROM payments 
	WHERE payment_method = 'cash' AND status='active'
	";
	if($_SESSION['type'] == 'user')
	{
		$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	}
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return number_format($row['total_cash_value'], 2);
	}
}


function count_total_cash_tigo_value($connect)
{
	$query = "
	SELECT sum(paid) as total_tigo_value FROM payments 
	WHERE payment_method = 'tigo_pesa' AND status='active'
	";
	// if($_SESSION['type'] == 'user')
	// {
	// 	$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	// }
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return number_format($row['total_tigo_value'], 2);
	}
}

function count_total_cash_bank_value($connect)
{
	$query = "
	SELECT sum(paid) as total_bank_value FROM payments 
	WHERE payment_method = 'transfer' AND status='active'
	";
	if($_SESSION['type'] == 'user')
	{
		$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	}
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return number_format($row['total_bank_value'], 2);
	}
}


// ALL EXPENSES
function count_total_cash_expenses_value($connect)
{
	$query = "
	SELECT sum(	expense_total_cost	) as total_cashExp_value FROM expense 
	WHERE payment_method = 'cash' AND status='active'
	";
	if($_SESSION['type'] == 'user')
	{
		$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	}
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return number_format($row['total_cashExp_value'], 2);
	}
}


function count_total_cash_tigo_expenses_value($connect)
{
	$query = "
	SELECT sum(expense_total_cost) as total_tigoExp_value FROM expense 
	WHERE payment_method = 'tigo_pesa' AND status='active'
	";
	// if($_SESSION['type'] == 'user')
	// {
	// 	$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	// }
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return number_format($row['total_tigoExp_value'], 2);
	}
}

function count_total_cash_bank_expenses_value($connect)
{
	$query = "
	SELECT sum(expense_total_cost) as total_bankExp_value FROM expense 
	WHERE payment_method = 'transfer' OR payment_method = 'cheque'  AND status='active'
	";
	if($_SESSION['type'] == 'user')
	{
		$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	}
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return number_format($row['total_bankExp_value'], 2);
	}
}


// ALL PURCHASES

function count_total_cash_purchase_value($connect)
{
	$query = "
	SELECT sum(paid) as total_cashPurch_value FROM purchase_payment 
	WHERE payment_method = 'cash' AND status='active'
	";
	if($_SESSION['type'] == 'user')
	{
		$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	}
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return number_format($row['total_cashPurch_value'], 2);
	}
}


function count_total_tigo_purchase_value($connect)
{
	$query = "
	SELECT sum(paid) as total_tigoPurch_value FROM purchase_payment 
	WHERE payment_method = 'tigo_pesa' AND status='active'
	";
	if($_SESSION['type'] == 'user')
	{
		$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	}
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return number_format($row['total_tigoPurch_value'], 2);
	}
}

function count_total_cash_bank_purchase_value($connect)
{
	$query = "
	SELECT sum(paid) as total_bankPurch_value FROM purchase_payment 
	WHERE payment_method = 'transfer' OR payment_method = 'cheque'  AND status='active'
	";
	if($_SESSION['type'] == 'user')
	{
		$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	}
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$netcash = $row['total_bankPurch_value'];
		return number_format($row['total_bankPurch_value'], 2);
	}
}



function count_total_net_cash_hand_value($connect)
{

$totaCash='';
$totalCashExp='';
$totatPurchaseCash='';
$totalCashloan = '';
$netcash='';
$nmbbank= '';
$nmbbank1='';
$loanpayment='';

	$query = "
	SELECT sum(paid) as total_cash_value FROM payments 
	WHERE payment_method = 'cash' AND status='active'
	";
	// if($_SESSION['type'] == 'user')
	// {
	// 	$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	// }
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$totaCash =$row['total_cash_value'];

	}



	$query = "
	SELECT sum(paid) as total_cashPurch_value FROM purchase_payment 
	WHERE payment_method = 'cash' AND status='active'
	";
	// if($_SESSION['type'] == 'user')
	// {
	// 	$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	// }
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$totatPurchaseCash = $row['total_cashPurch_value'];
	}


	$query = "
	SELECT sum(	expense_total_cost	) as total_cashExp_value FROM expense 
	WHERE payment_method = 'cash' AND status='active'
	";
	// if($_SESSION['type'] == 'user')
	// {
	// 	$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	// }
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$totalCashExp =$row['total_cashExp_value'];
	}
	
	$query = "
	SELECT sum(	balance	) as total_cashloan_value FROM loan 
	WHERE payment_method = 'cash' AND status='active'
	";
	// if($_SESSION['type'] == 'user')
	// {
	// 	$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	// }
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$totalCashloan =$row['total_cashloan_value'];
	}



	$query = "
	SELECT sum(	amount	) as nmbbanktotal FROM nmb 
	WHERE method = 'cash'  AND  transaction='deposit' AND status='active'
	";
	// if($_SESSION['type'] == 'user')
	// {
	// 	$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	// }
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$nmbbank =$row['nmbbanktotal'];
	}


	$query = "
	SELECT sum(	amount	) as nmbbanktotal FROM nmb 
	WHERE method = 'cash'  AND  transaction='withdraw' AND status='active'
	";
	// if($_SESSION['type'] == 'user')
	// {
	// 	$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	// }
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$nmbbank1 =$row['nmbbanktotal'];
	}

  	$query = "
	SELECT sum(paid) as loanrepayment FROM  loan_payment 
	WHERE payment_method = 'cash'  AND status='active'
	";
	// if($_SESSION['type'] == 'user')
	// {
	// 	$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	// }
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$loanpayment =$row['loanrepayment'];
	}



$netcash=($totaCash-$totalCashExp-$totatPurchaseCash-$nmbbank+$nmbbank1-$totalCashloan);
return number_format($netcash,2);

	
}


function count_total_net_cash_tigo_value($connect)
{

$totaCashTigo='';
$totalCashExpTigo='';
$totatPurchaseTigo='';
$netcash1='';
$nmbbank= '';
$nmbbank1='';
$totaloanTigo='';

	$query = "
	SELECT sum(paid) as total_cash_value FROM payments 
	WHERE payment_method = 'tigo_pesa' AND status='active'
	";
	// if($_SESSION['type'] == 'user')
	// {
	// 	$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	// }
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$totaCashTigo =$row['total_cash_value'];
	}
	
	
		$query = "
	SELECT sum(balance) as total_loantigo_value FROM loan 
	WHERE payment_method = 'tigo_pesa' AND status='active'
	";
	// if($_SESSION['type'] == 'user')
	// {
	// 	$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	// }
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$totaloanTigo =$row['total_loantigo_value'];
	}



	$query = "
	SELECT sum(paid) as total_cashPurch_value FROM purchase_payment 
	WHERE payment_method = 'tigo_pesa' AND status='active'
	";
	// if($_SESSION['type'] == 'user')
	// {
	// 	$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	// }
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$totatPurchaseTigo = $row['total_cashPurch_value'];
	}


	$query = "
	SELECT sum(	expense_total_cost	) as total_cashExp_value FROM expense 
	WHERE payment_method = 'tigo_pesa' AND status='active'
	";
	// if($_SESSION['type'] == 'user')
	// {
	// 	$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	// }
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$totalCashExpTigo =$row['total_cashExp_value'];
	}



	$query = "
	SELECT sum(	amount	) as nmbbanktotal FROM nmb 
	WHERE method = 'tigo_pesa'  AND  transaction='deposit' AND status='active'
	";
	// if($_SESSION['type'] == 'user')
	// {
	// 	$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	// }
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$nmbbank =$row['nmbbanktotal'];
	}



	$query = "
	SELECT sum(	amount	) as nmbbanktotal FROM nmb 
	WHERE method = 'tigo_pesa'  AND  transaction='withdraw' AND status='active'
	";
	// if($_SESSION['type'] == 'user')
	// {
	// 	$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	// }
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$nmbbank1 =$row['nmbbanktotal'];
	}



$netcash1=($totaCashTigo-$totatPurchaseTigo-$totalCashExpTigo-$nmbbank+$nmbbank1-$totaloanTigo);
return number_format($netcash1,2);

	
}



function count_total_net_cash_bank_value($connect)
{

$totalcashbank='';
$totalcashexpbank='';
$totalpurchasebank='';
$netcash2='';
$nmbbank = '';
$nmbbank1='';
$totalloanbank='';

	$query = "
	SELECT sum(paid) as total_cash_value FROM payments 
	WHERE payment_method = 'transfer'  AND status='active'
	";
	// if($_SESSION['type'] == 'user')
	// {
	// 	$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	// }
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$totalcashbank =$row['total_cash_value'];
	}



	$query = "
	SELECT sum(paid) as total_cashPurch_value FROM purchase_payment 
	WHERE payment_method = 'transfer'  AND status='active'
	";
	// if($_SESSION['type'] == 'user')
	// {
	// 	$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	// }
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$totalpurchasebank = $row['total_cashPurch_value'];
	}
	
		$query = "
	SELECT sum(balance) as total_loanbank_value FROM loan 
	WHERE payment_method = 'transfer'  AND status='active'
	";
	// if($_SESSION['type'] == 'user')
	// {
	// 	$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	// }
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$totalloanbank = $row['total_loanbank_value'];
	}



	$query = "
	SELECT sum(	expense_total_cost	) as total_cashExp_value FROM expense 
	WHERE payment_method = 'transfer'  AND status='active'
	";
	// if($_SESSION['type'] == 'user')
	// {
	// 	$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	// }
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$totalcashexpbank =$row['total_cashExp_value'];
	}


	$query = "
	SELECT sum(	amount	) as nmbbanktotal1 FROM nmb 
	WHERE method = 'transfer'  AND 	transaction='deposit' AND status='active'
	";
	// if($_SESSION['type'] == 'user')
	// {
	// 	$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	// }
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$nmbbank =$row['nmbbanktotal1'];
	}


		$query = "
	SELECT sum(	amount	) as nmbbanktotal2 FROM nmb 
	WHERE method = 'transfer' AND 	transaction='withdraw' AND status='active'
	";
	// if($_SESSION['type'] == 'user')
	// {
	// 	$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	// }
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$nmbbank1 =$row['nmbbanktotal2'];
	}


$netcash2=($totalcashbank-$totalpurchasebank-$totalcashexpbank-$nmbbank+$nmbbank1-$totalloanbank );
return number_format($netcash2,2);

	
}








?>