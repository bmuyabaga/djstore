<?php

if(isset($_POST["from_date1"], $_POST["to_date1"]))
{
	include('../config/function.php');

	$output = '';
	$query = " SELECT * FROM payments NATURAL JOIN client WHERE payment_date BETWEEN '".$_POST["from_date1"]."' AND '".$_POST["to_date1"]."' 
";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();



$output .= '
<table class="table table-bordered">
<thead>
<tr>
        <th width="5%">ID</th>
        <th width="50%">Client Name</th>
       
        <th width="20%">Value</th>
        <th width="25%">Payment Date</th>

      </tr>
</thead>
';
if($statement->rowCount() > 0)
{
    $total=0; //$grandtotal=0;
	foreach($result as $row)
	{
  
    $total = $total + $row['paid'];
		$output .= '
    <tbody>
      <tr>
        <td>'. $row['payment_id'].'</td>
        <td>'.$row['client_name'].'</td>
      
        <td>'.$row['paid'].'</td>
        <td>'.$row['payment_date'].'</td>
      </tr>

      </tbody>
     

		';
	}

  $output .= '
  <table>
      <tr>
      <th colspan="2">Total</th>
           <td style="text-align:left;"><h4><b>'.$total.'</b></h4></td>
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