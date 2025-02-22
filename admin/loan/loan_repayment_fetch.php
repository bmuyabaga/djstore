<?php

include('../../config/function.php');
	
		$query = "
		SELECT * FROM loan 
		INNER JOIN employee ON employee.emp_id = loan.emp_id

		WHERE loan.loan_id = :loanID
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':loanID'	=>	$_POST["loanID"]
			)
		);
		$result = $statement->fetchAll();
		$output = array();
		foreach($result as $row)
		{
			$output['first_name'] = $row['first_name'];
			$output['loan_date'] = $row['loan_date'];
			$output['amount'] = $row['amount'];
			$output['return_date'] = $row['return_date'];
			$output['returned_amount'] = $row['returned_amount'];
			$output['balance'] = $row['balance'];
			$output['user_id'] = $row['user_id'];
			$output['notes'] = $row['notes'];
			$output['payment_method'] = $row['payment_method'];
			$output['loan_id'] = $row['loan_id'];
			$output['emp_id'] = $row['emp_id'];

		}
		
		echo json_encode($output);
	
	
	?>