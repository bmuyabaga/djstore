<?php
 ob_start();
//view_order.php

$getOrderId = '';


if(isset($_GET["pdf"]) && isset($_GET['debitnoteid']))
{
   
  require_once 'pdf.php';
  include('../config/function.php');

$getOrderId = $_GET['debitnoteid'];
echo $getOrderId;

$pdf = $_GET['pdf'];
echo $pdf;

  if(!isset($_SESSION['type']))
  {
    header('location:login.php');
  }
  $output = '';

  //$last_id=$_GET["order_id"];


// $query= "SELECT sales_item.sales_id,sales_item.product_code,sales_item.selling_price,sales_item.qty,sales_item.total,sales.date,sales.total,sales.discount,sales.grandtotal,sales.pay,sales.balance,sales.payment_type,user_details.user_name,
// product.product_name,product.product_description,client.client_name,client.address1,client.address2,client.city,client.country,client.tin_no,client.vrn, branch.branch_name, branch.branch_address, branch.branch_contact,branch.branch_email,branch.tin_noo, client.due_days, client.due_type, client.max_credit FROM sales, 
// sales_item,product, client, user_details, branch WHERE 
// sales.sales_id = sales_item.sales_id AND product.product_code = sales_item.product_code AND client.client_id = sales.client_id AND user_details.user_id = sales.user_id AND branch.branch_id = branch.branch_id AND
// sales_item.sales_id = $last_id AND sales.sales_id = $last_id";




  // $statement = $connect->prepare($query);
  //   $statement->execute();
  //   $result = $statement->fetchAll();
  // foreach($result as $row)
  //   {
   $statement = $connect->prepare("
    SELECT * FROM debit_note INNER JOIN client ON client.client_id=debit_note.client_id INNER JOIN branch ON branch.branch_id=debit_note.branch_id
    WHERE debit_note.debitnote_id = :debitnote_id
    LIMIT 1
  ");
  $statement->execute(
    array(
      ':debitnote_id'       =>  $_GET["debitnoteid"]
    )
  );
  $result = $statement->fetchAll();
  foreach($result as $row)
  {

     $output .= '
    <table width="100%"  cellpadding="5" cellspacing="0">
      <tr>
        <td colspan="2" align="center" style="font-size:18px"><b>DEBIT NOTE</b></td>
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
              <b>Debit Note To,</b><br />
              
              Name : '.$row['client_name'].'<br /> 
              '.$row['city'].','.$row['address1'].'<br />
              TIN: '.$row['tin_no'].'<br />
            </td>
            <td width="30%">
              <b>Debit Note</b><br />
               Debit Note No. : '.$row['debitnote_id'].'<br />
              Debit Note Date : '.$row['createdate'].'<br />
              
             
            </td>
          </tr>
        </table>

        <br />
        <table width="100%" cellpadding="5" cellspacing="0">
        <thead>
          <tr style="background: #e6e9e7;color: #2e3e4e; color:#2e3e4e;">
            
            <th aline="center">Details</th>
           
            
          </tr>
          </thead>
       <tbody>
          
    ';
  







             //$x = 1;
                // $statement=$connect->prepare($query);
                //  $statement->execute();
                //  $result = $statement->fetchAll();

    
//foreach($result as $sub_row)
       // {
   $statement = $connect->prepare("
      SELECT * FROM debit_note  INNER JOIN sales ON sales.sales_id=debit_note.sales_id
      WHERE debit_note.debitnote_id = :sales_id
    ");
    $statement->execute(
      array(
        ':sales_id'       =>  $_GET["debitnoteid"]
      )
    );
    $product_result = $statement->fetchAll();
    //$count = 1;
   // $total = 0;
    //$discount = '';
    //$total_actual_amount = '';
    //$total_tax_amount = 0;
    foreach($product_result as $sub_row)
    {
      //$count = $count + 1;
     // $product_data = fetch_product_details($sub_row['product_id'], $connect);
      // $actual_amount = $sub_row["qty"] * $sub_row["selling_price"];
      //$tax_amount = ($actual_amount * $sub_row["tax"])/100;
      // $total_product_amount = $actual_amount + $tax_amount;
       
      // $total_tax_amount = $total_tax_amount + $tax_amount;
     //   $total = $total + $actual_amount;
     // $discount = $sub_row['discount'];
     // $total_actual_amount = $total - $discount;

            
      $output .= '
       
          <tr>
          
          
          <td><small></small>With the reference of attached INVOICE # '.$sub_row['zfda_invoice_number'].'  amounting '.$sub_row['amount'].' TZS from '.$sub_row['organization'].'<p> Please send the funds to M-PESA account: Number +255 753 875 251 to settle the mentioned invoice on your behalf</p></td>
         
                                    
       </tr>

  
          
      
      ';
   // $x++; 
      //$count++;

    }  




      $output .= '

       
     

            
</tbody>
</table>
            </table>

              
                 

                

                 
     
    ';

    $output .= '
    <br />   <br />   <br />   <br />       
           
       <hr>
     <i>We start the job after the payment has been received in our M-PESA account given above<br /></i>
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

  $file_name = 'Debit Note-'.$row["debitnote_id"].'-'.$date.'.pdf';
  $dompdf->loadHtml($output);
  $dompdf->setPaper('A4', 'portrait');
  $dompdf->render();
  $dompdf->stream($file_name, array("Attachment"=>0));
 }


echo $output;

