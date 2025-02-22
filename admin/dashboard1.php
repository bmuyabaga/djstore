<?php



function count_total_partially_sales($connect)
{
	$query = "
	SELECT * FROM sales WHERE payment_type='partially_paid' AND status='active'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}


function count_total_unpaid_sales($connect)
{
	$query = "
	SELECT * FROM sales WHERE payment_type='unpaid' AND status='active'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}


function count_total_paid_sales($connect)
{
	$query = "
	SELECT * FROM sales WHERE payment_type='paid' AND status='active'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

	









?>