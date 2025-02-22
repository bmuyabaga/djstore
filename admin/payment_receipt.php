<?php
 ob_start();
//view_order.php

 

$getOrderId = '';

if(isset($_GET["pdf"]) && isset($_GET['payment_id']))
{
  
 require_once 'pdf.php';
 include('../config/function.php');
 

$getOrderId = $_GET['payment_id'];
echo $getOrderId;

$pdf = $_GET['pdf'];
echo $pdf;

  if(!isset($_SESSION['type']))
  {
    header('location:../login.php');
  }
  $output = '';

   $statement = $connect->prepare("
    SELECT * FROM payments INNER JOIN client ON client.client_id=payments.client_id INNER JOIN branch ON branch.branch_id=payments.branch_id
    WHERE payments.payment_id = :payment_id
    LIMIT 1
  ");
  $statement->execute(
    array(
      ':payment_id'       =>  $_GET["payment_id"]
    )
  );
  $result = $statement->fetchAll();
  foreach($result as $row)
  {
$output .= '
<div width="100%" height="30%" align="center"><b>PAYMENT RECEIPT</b></div>

<br /><br />

  <table width="100%"   cellpadding="5" cellspacing="0">
  <style>
#top { margin-top:15px;}
  </style>
   <td width="60%">
            <b>'.$row['branch_name'].'</b><br />
            <address>
            '.$row['branch_address'].'.
            </address>
            Phone:'.$row['branch_contact'].'<br/>
            TIN:'.$row['tin_noo'].'<br/>
            Email: '.$row['branch_email'].'<br />
      
      </td>
      <td width="40%" id="top">
          <div align="left">
            <b>Received From: </b><br />
            <b>'.$row['client_name'].'</b>
            <address>
            '.$row['city'].','.$row['address1'].'.
            </address>
            
      </div>
      </td>
}
</tr>
</table>
          

        <br />
';
     $output .= '
    <table width="100%"   cellpadding="5" cellspacing="0">
      <tr>
        <td  align="center" style="font-size:18px"><b></b></td>
      </tr>
      <tr>


          

        <br />


     
    ';

   $statement = $connect->prepare("
    SELECT * FROM sales 
    WHERE sales_id = :sales_id
    LIMIT 1
  ");
  $statement->execute(
    array(
      ':sales_id'       =>  $row["sales_id"]
    )
  );
  $result1 = $statement->fetchAll();
  foreach($result1 as $row1)
  {

    $output .= '
 
   
     <table width="100%" border="1" cellpadding="5" cellspacing="0">
        <thead style="background: #e6e9e7;">
          <tr>
            <th>Payment ID</th>
           <td>'.$row['payment_id'].'</td>
          </tr>
            <tr>
            <th>Payment date</th>
           <td>'.$row['payment_date'].'</td>
          </tr>

            <tr>
            <th>Invoice No</th>
           <td>'.$row['sales_id'].'</td>
          </tr>

            <tr>
            <th>Invoice date</th>
           <td>'.$row1['date'].'</td>
          </tr>

            <tr>
            <th>Invoice Due Amount</th>
           <td>'.$row['due'].' tzs</td>
          </tr>

            <tr>
            <th>Paid Amount</th>
           <td>'.$row['paid'].' tzs</td>
          </tr>

            <tr>
            <th>Invoice Balance</th>
           <td>'.$row['balance'].' tzs</td>
          </tr>

          <tr>
            <th>Payment Method</th>
           <td>'.$row['payment_method'].'</td>
          </tr>
           <tr>
            <th>Notes</th>
           <td></td>
          </tr>

        </thead>
        </table>
     






    ';


  

}


      $output .= '

       
     


            </table>

              
                 

                

                 
     
    ';

    $output .= '
    <br /> <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
  
                 <address align="left">
                  <p>_________________________</P>  
                  Receiver Name
                  </address>
                  
                     <p>_________________________</P>                                                
                   Date, Signature/Stamp
                  </address>


    ';


  }

   $date=date("Y-m-d");

  $file_name = 'Receipt-'.$row["payment_id"].'-'.$date.'.pdf';
  //$file_name = 'Receipt-'.$row["payment_id"].'.pdf';
  $dompdf->loadHtml($output);
  $dompdf->setPaper('A4', 'portrait');
  $dompdf->render();

  $dompdf->stream($file_name, array("Attachment"=>0));
 }


echo $output;

?>