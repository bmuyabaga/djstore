<?php

if(isset($_POST["fromDate"], $_POST["toDate"]))
{
	include('../config/function.php');

	$output = '';
	$query = " SELECT * FROM expense NATURAL JOIN expaccount  WHERE  expense_date BETWEEN '".$_POST["fromDate"]."' AND '".$_POST["toDate"]."' 
";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();



$output .= '
<table class="table table-bordered">
<thead>
<tr>
        <th width="5%">ID</th>
        <th width="30%">Account</th>
        <th width="43%">Expense Cost</th>
        <th width="10%">Payment Method</th>
        <th width="12%"> Date</th>

      </tr>
</thead>
';
if($statement->rowCount() > 0)
{
    $total=0; //$grandtotal=0;
	foreach($result as $row)
	{
  
    $total = $total + $row['expense_total_cost'];
		$output .= '
    <tbody>
      <tr>
        <td>'. $row['expense_id'].'</td>
        <td>'.$row['expense_account'].'</td>
        <td>'. $row['expense_total_cost'].'</td>
        <td>'.$row['payment_method'].'</td>
        <td>'.$row['expense_date'].'</td>
      </tr>

      </tbody>
     

		';
	}

  $output .= '
  <table>
      <tr>
      <th colspan="3">Total</th>
           <td style="text-align:right;"><h4><b>'.$total.'</b></h4></td>
      </tr>
      </table>

  ';
}
else
{
	$output .= '
	<tr>
      <td colspan="5"> No order Found</td>
	</tr>

	';
}

$output .= '</table>';

echo $output;


}



?>