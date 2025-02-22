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


$query = " SELECT * FROM payments NATURAL JOIN client 
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
             <a href="#" class="btn btn-primary btn-sm">Payment Summary</a>
             <a href="client_statement" class="btn btn-info btn-sm">Client Statement</a>
            <a href="invoice_report.php" class="btn btn-success btn-sm">Invoice Report</a>
              <a href="expense_report.php" class="btn btn-warning btn-sm">Expense Report</a>
               <a href="product_report.php" class="btn bg-maroon btn-sm">Product Report</a>
                <a href="product_general_report.php" class="btn bg-olive btn-sm">Product General Report</a>
            </div>
             
           </div>
          </div> <!-- /.card-body -->
          <div class="card-body">
            <div class="row">
        
               
             
           <!--<div class="col-md-3">
              
              <div class="form-group">
                
                  <select class="form-control select2" id="cidr"  style="width: 100%;">
                    <option selected="selected">Select Client</option>
                   <?php// echo fill_client_list($connect); ?>
                  </select>
                </div>


           </div>-->   
              
<div class="col-md-3">
   <div class="input-group mb-3">
                  <input type="date" name="from_date1" id="from_date1"  class="form-control">
                  <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                  </div>
                </div>

        </div>

        <div class="col-md-3">
   <div class="input-group mb-3">
                  <input type="date" name="to_date1" id="to_date1"  class="form-control">
                  <div class="input-group-append">
      
                          <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                  </div>
                </div>

        </div>


        <div class="col-md-3">
  
                  <input type="button" name="filter1" id="filter1" value="Filter" class="btn btn-primary">
        </div>

<table id="payment_table" class="table table-bordered">
      <tr>
        <th width="5%">ID</th>
        <th width="50%">Client Name</th>
        
        <th width="20%">Value</th>
        <th width="25%">Payment Date</th>
      </tr>
      <?php
      foreach($result as $row)
      {



      ?>

      <tr>
        <td><?php echo $row['payment_id'];  ?></td>
        <td><?php echo $row['client_name'];  ?></td>
       
        <td><?php echo $row['paid'];  ?></td>
        <td><?php echo $row['payment_date'];  ?></td>
      </tr>
     
<?php } ?>
    </table>
      <span id="load_data">

      </span>        
              
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


$(document).ready(function(){





$('#filter1').click(function(){

var from_date1 = $('#from_date1').val();
var to_date1 = $('#to_date1').val();
//var cidr = $('#cidr').val();

if(from_date1 != '' && to_date1 != '')
{
  $.ajax({
     url: "filter_pay_report.php",
     method: "POST",
     data: {from_date1:from_date1, to_date1:to_date1},
     success:function(data)
     {
       $('#load_data').html(data);
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





