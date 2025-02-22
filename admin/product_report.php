<?php
include('../config/function.php');

if(!isset($_SESSION["type"]))
{
  header('location:../login.php');
}


include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');


?>
<?php


$query = " SELECT * FROM sales NATURAL JOIN sales_item NATURAL JOIN product
";
$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();




?>


 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
     
         <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Reports</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

<span id="alert_action"></span>
    <div class="container">
      <div class="row">
        <div class="col-md-12">


              <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card card-info card-outline">
          <div class="card-header">
           <div class="row">
            <div class="col-md-12">
            <a href="sales_report.php" class="btn btn-danger btn-sm">General Summary</a>
             <a href="payment_report.php" class="btn btn-primary btn-sm">Payment Summary</a>
             <a href="client_statement.php" class="btn btn-info btn-sm">Client Statement</a>
            <a href="invoice_report.php" class="btn btn-success btn-sm">Invoice Report</a>
              <a href="expense_report.php" class="btn btn-warning btn-sm">Expense Report</a>
              <a href="#" class="btn bg-maroon btn-sm">Product Report</a>
              <a href="product_general_report.php" class="btn bg-olive btn-sm">Product General Report</a>
            </div>
             
           </div>
          </div> <!-- /.card-body -->
          <div class="card-body">
            <div class="row">
        
               
             
           <div class="col-md-3">
              
              <div class="form-group">
                
                  <select class="form-control selectproduct" id="productcode"  style="width: 100%;">
                    <option selected="selected">Select Client</option>
                   <?php echo fill_product_list2($connect); ?>
                  </select>
                </div>


           </div>   
              
<div class="col-md-3">
   <div class="input-group mb-3">
                  <input type="date" name="fromdate" id="fromdate"  class="form-control">
                  <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                  </div>
                </div>

        </div>

        <div class="col-md-3">
   <div class="input-group mb-3">
                  <input type="date" name="todate" id="todate"  class="form-control">
                  <div class="input-group-append">
      
                          <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                  </div>
                </div>

        </div>


        <div class="col-md-3">
  
                  <input type="button" name="filterProduct" id="filterProduct" value="Filter" class="btn btn-primary">
        </div>

<table id="productTable" class="table table-bordered">
      <tr>
        <th width="5%">qty</th>
        <th width="30%">Product Name</th>
        <th width="43%">Price</th>

        <th width="10%">Total</th>
        <th width="12%">Date</th>
      </tr>
      <?php
      $qty=0;$grand=0;$discount=0;
      foreach($result as $row)
      {

         $total=$row['qty']*$row['product_base_price'];
    $grand=$grand+$total-$row['discount'];
    $discount=$discount+$row['discount'];

      ?>

      <tr>
        <td><?php echo $row['qty'];  ?></td>
        <td><?php echo $row['product_name'];  ?></td>
        <td><?php echo $row['product_base_price'];  ?></td>
        <td><?php echo $total;  ?></td>
        <td><?php echo $row['date'];  ?></td>
      </tr>
     
<?php } ?>
    </table>
              
              
            </div>
          </div><!-- /.card-body -->
        </div>
      </div><!-- /.container-fluid -->
    </section>
          
          
        </div>
        
      </div>
      
    </div>




  </div>


<script type="text/javascript">
$(function(){

 $('.selectproduct').select2({
    theme: 'bootstrap4'

   });

})

 
</script>


<script>
$(document).ready(function(){





$('#filterProduct').click(function(){

var fromdate = $('#fromdate').val();
var todate = $('#todate').val();
var productcode = $('#productcode').val();

if(fromdate != '' && fromdate != '')
{
  $.ajax({
     url: "filter_product_report.php",
     method: "POST",
     data: {fromdate:fromdate, todate:todate, productcode:productcode},
     success:function(data)
     {
       $('#productTable').html(data);
     }

  });

}
else
{
  alert("Please Select Date");
}

});


});

</script>





<?php

include('includes/footer.php');
?>





