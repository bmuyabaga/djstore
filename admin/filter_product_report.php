<?php

if(isset($_POST["fromdate"], $_POST["todate"],$_POST["productcode"]))
{
  include('../config/function.php');

	$output = '';
	$query = " SELECT * FROM sales NATURAL JOIN sales_item NATURAL JOIN product  WHERE product_code='".$_POST["productcode"]."' AND   date BETWEEN '".$_POST["fromdate"]."' AND '".$_POST["todate"]."' 
";


$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();



$output .= '
<table class="table table-bordered">
<thead>
<tr>
        
        <th width="30%">Product Name</th>
        <th width="5%">qty</th>
        <th width="43%">Price</th>
        <th width="10%">Total</th>
        <th width="12%"> Date</th>

      </tr>
</thead>
';
if($statement->rowCount() > 0)
{
    $total=0; $qty=0;$grand=0;$discount=0;
	foreach($result as $row)
	{
    $total=$row['qty']*$row['product_base_price'];
     $grand=$grand+$total-$row['discount'];
     $qty=$qty+$row['qty'];
		$output .= '
    <tbody>
      <tr>
        
        <td>'.$row['product_name'].'</td>
        <td>'. $row['qty'].'</td>
        <td>'. $row['product_base_price'].'</td>
        <td>'.$total.'</td>
        <td>'.$row['date'].'</td>
      </tr>

      </tbody>
     

		';
	}

  $output .= '
  <table>
      <tr>
      <th colspan="1">Total</th>
           <td style="text-align:right;"><h4><b>'.$qty.'</b></h4></td>
           <td colspan="2" style="text-align:right;"><h4><b>'.$grand.'</b></h4></td>
           
      </tr>
    

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