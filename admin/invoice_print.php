<?php
include('../config/function.php');

if($_SERVER['REQUEST_METHOD']=='GET')
{
 $last_id = $_GET['view']; 



$query= "SELECT sales_item.sales_id,sales_item.product_code,sales_item.selling_price,sales_item.qty,sales_item.total,sales.date,sales.total,sales.discount,sales.grandtotal,sales.pay,sales.balance,sales.payment_type,user_details.user_name,
product.product_name,product.product_description,client.client_name,client.address1,client.address2,client.city,client.country,client.tin_no,client.vrn, branch.branch_name, branch.branch_address, branch.branch_contact,branch.branch_email,branch.tin_noo, client.due_days, client.due_type, client.max_credit FROM sales, sales_item,product, client, user_details, branch WHERE 
sales.sales_id = sales_item.sales_id AND product.product_code = sales_item.product_code AND client.client_id = sales.client_id AND user_details.user_id = sales.user_id AND branch.branch_id = branch.branch_id AND 
sales_item.sales_id = $last_id";




  $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

      $output = array();
    foreach($result as $row)
    {
      $output['sales_id'] = $row['sales_id'];
      $output['product_id'] = $row['product_code'];
      $output['selling_price'] = $row['selling_price'];
      $output['qty'] = $row['qty'];
   


  }      






include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
//include('database_connection.php');

?>

 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   

   <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
           

            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> <?php echo $row['branch_name'];?>.
                    <small class="float-right"><?php echo $row['date'];?></small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  From
                  <address>
                    <strong><?php echo $row['branch_name'];?></strong><br>
                    <?php echo $row['branch_address'];?><br>
                    TIN: <?php echo $row['tin_noo'];?><br>
                    <?php echo $row['branch_contact'];?><br>
                    Email: <?php echo $row['branch_email'];?>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                 Billing To
                  <address>
                    <strong><?php echo $row['client_name'];?></strong><br>
                    <?php echo $row['address1'];?><br>
                    <?php echo $row['city'];?><br>
                    TIN: <?php echo $row['tin_no'];?><br>
                    Email: john.doe@example.com
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>Invoice</b><br>
                  <br>
                  Invoice # <?php echo $row['sales_id'];?><br>
                  <b>Date:</b> 4F3S8J<br>
                  <b>Due Date:</b> <?php echo $row['due_type'];?><br>
                  <b>Pay Terms:</b> <?php echo $row['due_days'];?> day(s) <?php echo $row['due_type'];?><br>

                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>Qty</th>
                      <th>Product</th>
                      <th>Serial #</th>
                      <th>Unit Price</th>
                      <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
              <?php    
                $x = 1;
                $statement=$connect->prepare($query);
                 $statement->execute();
                 $result = $statement->fetchAll();

    
                foreach($result as $row)
                  {
      

              ?>
                    <tr>
                      <td><?php echo $row[3];?> </td>
                      <td><b><?php  echo $row[13];?></b><br><?php  echo $row[14];?></td>
                      <td><?php  echo $row[1];?></td>
                      <td><?php echo number_format($row[2],2);?></td>
                      <td><?php echo number_format($row[4],2);?></td>
                    </tr>
               <?php $x++; } ?>

                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                  <p class="lead">Payment Methods:</p>
                  <!--<img src="../../dist/img/credit/visa.png" alt="Visa">
                  <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
                  <img src="../../dist/img/credit/american-express.png" alt="American Express">
                  <img src="../../dist/img/credit/paypal2.png" alt="Paypal">-->

                  <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                 The payment can be made in cash or direct deposit in the bank through the following below bank details.
                  </p>

                  <address>
                    Account Name: Bethel Business <br>
                    Account Name: Bethel Business
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-6">
                  <p class="lead">Amount Due 2/22/2014</p>

                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td><b>TZS<?php echo number_format($row[6],2);?></b></td>
                      </tr>
                      <!--<tr>
                        <th>Tax (9.3%)</th>
                        <td>$10.34</td>
                      </tr>-->
                      <!--<tr>
                        <th>Shipping:</th>
                        <td>$5.80</td>
                      </tr>-->
                      <tr>
                        <th>Total:</th>
                        <td><b>TZS <?php echo number_format($row[8]-$row[7],2);?></td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

<?php   } ?>

  


  </div>







    

          <script type="text/javascript"> 
  window.addEventListener("load", window.print());
</script>


<?php

//include('includes/footer.php');
?>





