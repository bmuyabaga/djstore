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
    SELECT * FROM sales INNER JOIN client ON client.client_id=sales.client_id INNER JOIN branch ON branch.branch_id=sales.branch_id
    WHERE sales.sales_id = :sales_id
    LIMIT 1
  ");
  $statement->execute(
    array(
      ':sales_id'       =>  $_GET["order_id"]
    )
  );
  $result = $statement->fetchAll();
  foreach($result as $row)
  {

     $output .= '
    <table width="100%"  cellpadding="5" cellspacing="0">
      <tr>
        <td colspan="2" align="center" style="font-size:18px"><b>INVOICE</b></td>
      </tr>
      <tr>
        <td colspan="2">
        <table width="100%" cellpadding="5">
          <tr>
            <td width="33%">
              <b>From,</b><br />
              '.$row['branch_name'].'<br />
              '.$row['branch_address'].'<br />
              '.$row['tin_noo'].'<br /> 
              '.$row['branch_contact'].'<br />
              Email: '.$row['branch_email'].'<br />
            </td>
              <td width="40%">
              <b>Billing To,</b><br />
              
              Name : '.$row['client_name'].'<br />
              From :2024-12-01 To 2024-12-31<br />  
              '.$row['city'].','.$row['address1'].'<br />
              TIN: '.$row['tin_no'].'<br />
            </td>
            <td width="27%">
              <b>Invoice</b><br />
               Invoice No. : '.$row['sales_id'].'<br />
              Invoice Date : '.$row['date'].'<br />
              
             
            </td>
          </tr>
        </table>

        <br />
        <table width="100%" cellpadding="5" cellspacing="0">
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
  







             //$x = 1;
                // $statement=$connect->prepare($query);
                //  $statement->execute();
                //  $result = $statement->fetchAll();

    
//foreach($result as $sub_row)
       // {
   $statement = $connect->prepare("
      SELECT * FROM sales_item INNER JOIN product ON product.product_code=sales_item.product_code INNER JOIN sales ON sales.sales_id=sales_item.sales_id
      WHERE sales_item.sales_id = :sales_id
    ");
    $statement->execute(
      array(
        ':sales_id'       =>  $_GET["order_id"]
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
          
          <td style="text-align:center;"><small>'.$sub_row['qty'].'</small></td>
          <td><small style="font-size:16px; font-family: Arial, Helvetica, sans-serif;">'.$sub_row['product_name'].'</small><br><i><small style="font-size:12px; font-family: Arial, Helvetica, sans-serif;">'.$sub_row['product_description'].'</small></i></td>
          <td class="record"><small style="font-size:16px; font-family: Arial, Helvetica, sans-serif;">'.$sub_row['product_code'].'</small></td>
          <td><small style="font-size:16px; font-family: Arial, Helvetica, sans-serif;">'.number_format($sub_row['selling_price'],0).'</small></td>
          <td style="text-align:right"><small style="font-size:16px; font-family: Arial, Helvetica, sans-serif;">'.number_format($actual_amount,0).'</small></td>
                                    
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
 <td style="text-align:right"><b style="font-size:16px; font-family: Arial, Helvetica, sans-serif;">'.number_format($total,0).'</b></td>
 </tr>

     
    ';


        $output .= '

                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right"><b>Discount</b></td>
                        <td style="text-align:right"><b style="font-size:16px; font-family: Arial, Helvetica, sans-serif;">'.number_format($discount,0).'</b></td>
                      </tr>

    ';


    $output .= '

                       <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right"><b>Other Fees</b></td>
                        <td style="text-align:right"><b style="font-size:16px; font-family: Arial, Helvetica, sans-serif;">0.00</b></td>
                      </tr>

    ';

    $output .= '

                       <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right"><b>TOTAL AMOUNT DUE</b></td>
                        <td style="text-align:right"><b style="font-size:16px; font-family: Arial, Helvetica, sans-serif;">'.number_format($total_actual_amount,0).'</b></td>
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
     <i>Please send the total amount to my, <b>M-PESA, Network: Vodacom, Phone Number: +255 753 875 251.</b><br /></i>
       <hr><br>Thank you

  
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

  $file_name = 'Invoice-'.$row["sales_id"].'-'.$date.'.pdf';
  $dompdf->loadHtml($output);
  $dompdf->setPaper('A4', 'portrait');
  $dompdf->render();
  $dompdf->stream($file_name, array("Attachment"=>0));
 }


echo $output;

