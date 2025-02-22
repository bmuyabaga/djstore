<?php
include('../config/function.php');

if(!isset($_SESSION["type"]))
{
  header('location:../login.php');
}



include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
//include('database_connection.php');

?>
<?php

//$query = " SELECT * FROM sales INNER JOIN sales_item ON sales_item.sales_id = sales.sales_id INNER JOIN client ON client.client_id = sales.client_id

//";

$query = " SELECT * FROM sales NATURAL JOIN sales_item NATURAL JOIN product NATURAL JOIN client
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
            <a href="#" class="btn btn-danger btn-sm">General Summary</a>
             <a href="payment_report.php" class="btn btn-primary btn-sm">Payment Summary</a>
             <a href="client_report.php" class="btn btn-info btn-sm">Client Statement</a>
            <a href="invoice_report.php" class="btn btn-success btn-sm">Invoice Report</a>
              <a href="expense_report.php" class="btn btn-warning btn-sm">Expense Report</a>
              <a href="product_report.php" class="btn bg-maroon btn-sm">Product Report</a>
              <a href="product_general_report.php" class="btn bg-pink btn-sm">Product General Report</a>
            </div>

             
           </div>
          </div> <!-- /.card-body -->
          <div class="card-body">
            <div class="row">
        
               
             
           <div class="col-md-3">
              
              <div class="form-group">
                
                  <select class="form-control select2" id="cidr"  style="width: 100%;">
                    <option selected="selected">Select Client</option>
                   <?php echo fill_client_list($connect); ?>
                  </select>
                </div>


           </div>   
              
<div class="col-md-3">
   <div class="input-group mb-3">
                  <input type="date" name="from_date" id="from_date"  class="form-control">
                  <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                  </div>
                </div>

        </div>

        <div class="col-md-3">
   <div class="input-group mb-3">
                  <input type="date" name="to_date" id="to_date"  class="form-control">
                  <div class="input-group-append">
      
                          <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                  </div>
                </div>

        </div>


        <div class="col-md-3">
  
                  <input type="button" name="filter" id="filter" value="Filter" class="btn btn-primary">
        </div>

<table id="order_table" class="table table-bordered">
      <tr>
        <th width="5%">ID</th>
        <th width="30%">Client Name</th>
        <th width="43%">Product</th>
        <th width="10%">Value</th>
        <th width="12%">Order Date</th>
      </tr>
      <?php
      foreach($result as $row)
      {



      ?>

      <tr>
        <td><?php echo $row['sales_id'];  ?></td>
        <td><?php echo $row['client_name'];  ?></td>
        <td><?php echo $row['product_name'];  ?></td>
        <td><?php echo $row['grandtotal'];  ?></td>
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

 $('.select2').select2({
    theme: 'bootstrap4'

   });

})

 
</script>


<script>
$(document).ready(function(){





$('#filter').click(function(){

var from_date = $('#from_date').val();
var to_date = $('#to_date').val();
var cidr = $('#cidr').val();

if(from_date != '' && to_date != '')
{
  $.ajax({
     url: "filter.php",
     method: "POST",
     data: {from_date:from_date, to_date:to_date, cidr:cidr},
     success:function(data)
     {
       $('#order_table').html(data);
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





