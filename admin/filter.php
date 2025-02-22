<?php

if(isset($_POST["from_date"], $_POST["to_date"], $_POST["cidr"]))
{
  include('../config/function.php');

	$output = '';
	$query = " SELECT * FROM sales NATURAL JOIN sales_item NATURAL JOIN product NATURAL JOIN client WHERE  client_id='".$_POST["cidr"]."' OR date BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."' 
";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();



$output .= '
<table class="table table-bordered">
<thead>
<tr>
        <th width="5%">ID</th>
        <th width="30%">Client Name</th>
        <th width="43%">Product</th>
        <th width="10%">Value</th>
        <th width="12%">Order Date</th>

      </tr>
</thead>
';
if($statement->rowCount() > 0)
{
    $total=0; //$grandtotal=0;
	foreach($result as $row)
	{
  
    $total = $total + $row['grandtotal'];
		$output .= '
    <tbody>
      <tr>
        <td>'. $row['sales_id'].'</td>
        <td>'.$row['client_name'].'</td>
        <td>'. $row['product_name'].'</td>
        <td>'.$row['grandtotal'].'</td>
        <td>'.$row['date'].'</td>
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