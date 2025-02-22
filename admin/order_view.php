<?php
 ob_start();
//view_order.php

$getOrderId = '';

if(isset($_GET["pdf"]) && isset($_GET['order_id']))
{
  require_once 'pdf.php';
  include('../config/function.php');

$getOrderId = $_GET['order_id'];
echo $getOrderId;

$pdf = $_GET['pdf'];
echo $pdf;

  if(!isset($_SESSION['type']))
  {
    header('location:../login.php');
  }
  $output = '';


   $statement = $connect->prepare("
    SELECT * FROM customer_order INNER JOIN client ON client.client_id=customer_order.client_id INNER JOIN branch ON branch.branch_id=customer_order.branch_id
    WHERE customer_order.order_id = :order_id
    LIMIT 1
  ");
  $statement->execute(
    array(
      ':order_id'       =>  $_GET["order_id"]
    )
  );
  $result = $statement->fetchAll();
  foreach($result as $row)
  {

     $output .= '
    <table width="100%"  cellpadding="5" cellspacing="0">
      <tr>
        <td colspan="2" align="center" style="font-size:18px"><b>ORDER</b></td>
      </tr>
      <tr>
        <td colspan="2">
        <table width="100%" cellpadding="5">
          <tr>
            <td width="40%">
              <b>From,</b><br />
              '.$row['branch_name'].'<br />
              '.$row['branch_address'].'<br />
              '.$row['tin_noo'].'<br /> 
              '.$row['branch_contact'].'<br />
              Email: '.$row['branch_email'].'<br />
            </td>
              <td width="30%">
              <b>Billing To,</b><br />
              
              Name : '.$row['client_name'].'<br /> 
              '.$row['city'].','.$row['address1'].'<br />
              TIN: '.$row['tin_no'].'<br />
            </td>
            <td width="30%">
              <b>Order</b><br />
               Order No. : '.$row['order_id'].'<br />
              Order Date : '.$row['order_date'].'<br />
           
            
            </td>
          </tr>
        </table>

        <br />
        <table width="100%"  cellpadding="5" cellspacing="0">
        <thead>
          <tr style="background: #2e3e4e;color: #fff; color:white;">
            <th>Quantity</th>
            <th>Product</th>
            <th>Product Code</th>
            <th>Unit Price</th>
            <th>Amount.</th>
            
          </tr>
          </thead>
       <tbody style="background: #e6e9e7;">
          
    ';

 
//border-style: solid;
  //border-color: coral;

             //$x = 1;
                // $statement=$connect->prepare($query);
                //  $statement->execute();
                //  $result = $statement->fetchAll();

    
//foreach($result as $sub_row)
       // {
   $statement = $connect->prepare("
      SELECT * FROM customer_order_item INNER JOIN product ON product.product_code=customer_order_item.product_code INNER JOIN customer_order 
      ON customer_order.order_id=customer_order_item.order_id
      WHERE customer_order_item.order_id = :order_id
    ");
    $statement->execute(
      array(
        ':order_id'       =>  $_GET["order_id"]
      )
    );
    $product_result = $statement->fetchAll();
    $count = 1;
    $total = 0;
    $discount = '';
    $total_actual_amount = '';
    //$total_tax_amount = 0;
    foreach($product_result as $sub_row)
    {
      $count = $count + 1;
     // $product_data = fetch_product_details($sub_row['product_id'], $connect);
      $actual_amount = $sub_row["qty"] * $sub_row["selling_price"];
      //$tax_amount = ($actual_amount * $sub_row["tax"])/100;
      // $total_product_amount = $actual_amount + $tax_amount;
       
      // $total_tax_amount = $total_tax_amount + $tax_amount;
       $total = $total + $actual_amount;
     $discount = $sub_row['discount'];
     $total_actual_amount = $total - $discount;

            
      $output .= '
       
          <tr>
          
          <td><small>'.$sub_row['qty'].'</small></td>
          <td><small>'.$sub_row['product_name'].'</small></td>
          <td class="record"><small>'.$sub_row['product_code'].'</small></td>
          <td><small>'.$sub_row['selling_price'].'</small></td>
          <td style="text-align:right"><small>'.$actual_amount.'</small></td>
                                    
       </tr>

  
          
     
      ';
   // $x++; 
      $count++;

    }  

    $output .= '

 <tr>
 <td></td>
 <td></td>
 <td></td>
 <td class="text-right"><b>Subtotal</b></td>
 <td style="text-align:right"><b>'.$total.'</b></td>
 </tr>

     
    ';


        $output .= '

                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right"><b>Discount</b></td>
                        <td style="text-align:right"><b>'.$discount.'</b></td>
                      </tr>

    ';


    $output .= '

                       <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right"><b>Delivery Fee</b></td>
                        <td style="text-align:right"><b>0.00</b></td>
                      </tr>

    ';

    $output .= '

                       <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right"><b>TOTAL AMOUNT DUE</b></td>
                        <td style="text-align:right"><b>'.$total_actual_amount.'</b></td>
                      </tr>
    ';




      $output .= '

       
     

  </tbody>           

</table>
            </table>

              
                 

                

                 
     
    ';

    $output .= '
    <br />   <br />   <br />   <br />       
           
       <hr>
     <i>The payment for this invoice can be made on cash or direct to our bank account through the given bank details, <b>Bank:NMB, Account Name: Bethel Business, Account number: 23410017797.</b><br /></i>
       <hr>

  
                 <address align="left">
                  <p>_________________________</P>  
                   Customer Name
                  </address>
                  
                     <p>_________________________</P>                                                
                   Date, Signature/Stamp
                  </address>


    ';


  }

//$dompdf
  
  //$pdf = new Pdf();
  // $file_name = 'Invoice-'.$row["sales_id"].'.pdf';
  // $pdf->loadHtml($output);
  // $pdf->render();
  // $pdf->stream($file_name, array("Attachment" => false));

  //$pdf = new Pdf();
  $date=date("Y-m-d");

  $file_name = 'Invoice-'.$row["order_id"].'-'.$date.'.pdf';
  $dompdf->loadHtml($output);
  $dompdf->setPaper('A4', 'portrait');
  $dompdf->render();
  //$dompdf->stream("Invoice", array("Attachment"=>0));
  $dompdf->stream($file_name, array("Attachment"=>0));
 }


echo $output;

?>