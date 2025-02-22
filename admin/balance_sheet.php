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

// Fetch total assets (Cash + Inventory + Accounts Receivable)
$cash_stmt = $connect->prepare("SELECT SUM(paid) AS total_cash FROM payments WHERE payment_method='cash'");
$cash_stmt->execute();
$cash = $cash_stmt->fetch(PDO::FETCH_ASSOC);
$total_cash = isset($cash['total_cash']) ? $cash['total_cash'] : 0;

$inventory_stmt = $connect->prepare("SELECT SUM(product_quantity * product_base_price) AS total_inventory FROM product WHERE product_quantity > 0 AND product_status = 'active'");
$inventory_stmt->execute();
$inventory = $inventory_stmt->fetch(PDO::FETCH_ASSOC);
$total_inventory = isset($inventory['total_inventory']) ? $inventory['total_inventory'] : 0;

$receivables_stmt = $connect->prepare("SELECT SUM(total) AS total_receivable FROM sales WHERE payment_type = 'unpaid' OR payment_type = 'partially_paid' AND status = 'active'");
$receivables_stmt->execute();
$accounts_receivable = $receivables_stmt->fetch(PDO::FETCH_ASSOC);
$total_receivable = isset($accounts_receivable['total_receivable']) ? $accounts_receivable['total_receivable'] : 0;

$total_assets = $total_cash + $total_inventory + $total_receivable;

// Fetch total liabilities (Loans + Accounts Payable)
$loans_stmt = $connect->prepare("SELECT SUM(amount) AS total_loans FROM liabilities WHERE type='loan'");
$loans_stmt->execute();
$loans = $loans_stmt->fetch(PDO::FETCH_ASSOC);
$total_loans = isset($loans['total_loans']) ? $loans['total_loans'] : 0;

$payables_stmt = $connect->prepare("SELECT SUM(total) AS total_payable FROM purchase WHERE payment_type = 'unpaid' OR payment_type = 'partially_paid' AND status = 'active'");
$payables_stmt->execute();
$accounts_payable = $payables_stmt->fetch(PDO::FETCH_ASSOC);
$total_payable = isset($accounts_payable['total_payable']) ? $accounts_payable['total_payable'] : 0;

$total_liabilities = $total_loans + $total_payable;

// Fetch owner’s equity (Capital + Retained Earnings)
$capital_stmt = $connect->prepare("SELECT SUM(amount) AS total_capital FROM equity WHERE type='capital'");
$capital_stmt->execute();
$capital = $capital_stmt->fetch(PDO::FETCH_ASSOC);
$total_capital = isset($capital['total_capital']) ? $capital['total_capital'] : 0;

$retained_stmt = $connect->prepare("SELECT SUM(profit) AS total_retained FROM financial_reports");
$retained_stmt->execute();
$retained_earnings = $retained_stmt->fetch(PDO::FETCH_ASSOC);
$total_retained = isset($retained_earnings['total_retained']) ? $retained_earnings['total_retained'] : 0;

$total_equity = $total_capital + $total_retained;

// Calculate balance sheet total
$balance_sheet_total = $total_assets - $total_liabilities;


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

        <!---table start---> 
        <h2>Balance Sheet</h2>
    <table class="table table-bordered">
        <thead>
            <tr class="table-dark">
                <th>Category</th>
                <th>Amount ($)</th>
            </tr>
        </thead>
        <tbody>
            <tr class="table-success">
                <td><strong>Total Assets</strong></td>
                <td><?php echo number_format($total_assets, 2); ?></td>
            </tr>
            <tr>
                <td>Cash</td>
                <td><?php echo number_format($total_cash, 2); ?></td>
            </tr>
            <tr>
                <td>Inventory</td>
                <td><?php echo number_format($total_inventory, 2); ?></td>
            </tr>
            <tr>
                <td>Accounts Receivable</td>
                <td><?php echo number_format($total_receivable, 2); ?></td>
            </tr>
            <tr class="table-danger">
                <td><strong>Total Liabilities</strong></td>
                <td><?php echo number_format($total_liabilities, 2); ?></td>
            </tr>
            <tr>
                <td>Loans</td>
                <td><?php echo number_format($total_loans, 2); ?></td>
            </tr>
            <tr>
                <td>Accounts Payable</td>
                <td><?php echo number_format($total_payable, 2); ?></td>
            </tr>
            <tr class="table-primary">
                <td><strong>Total Equity</strong></td>
                <td><?php echo number_format($total_equity, 2); ?></td>
            </tr>
            <tr>
                <td>Owner’s Capital</td>
                <td><?php echo number_format($total_capital, 2); ?></td>
            </tr>
            <tr>
                <td>Retained Earnings</td>
                <td><?php echo number_format($total_retained, 2); ?></td>
            </tr>
            <tr class="table-info">
                <td><strong>Balance Sheet Total</strong></td>
                <td><strong><?php echo number_format($balance_sheet_total, 2); ?></strong></td>
            </tr>
        </tbody>
    </table>
        <!----table end--->
              
              
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





