<?php
//function.php

function count_total_sales($connect)
{
	$query = "
	SELECT * FROM sales WHERE status='active'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}



function count_total_sales_value($connect)
{
	$query = "
	SELECT sum(grandtotal) as total_sales_value FROM sales 
	WHERE  status='active'
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
		$totalsales=$row['total_sales_value'];
	}

	
	return number_format($totalsales, 2);
}


function count_total_partially_sales($connect)
{
	$query = "
	SELECT * FROM sales WHERE payment_type='partially_paid' AND status='active'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

	









?>