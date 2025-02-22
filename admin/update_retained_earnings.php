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
if(isset($_POST["update_retained_earnings"]))
{

// Fetch total revenue (sales)
$sales_stmt = $connect->prepare("SELECT SUM(amount) AS total_sales FROM transactions WHERE category='sale'");
$sales_stmt->execute();
$row = $sales_stmt->fetch(PDO::FETCH_ASSOC);
$total_sales = isset($row['total_sales']) ? $row['total_sales'] : 0;

// Fetch total expenses
$expenses_stmt = $connect->prepare("SELECT SUM(amount) AS total_expenses FROM transactions WHERE category='expense'");
$expenses_stmt->execute();
$row = $expenses_stmt->fetch(PDO::FETCH_ASSOC);
$total_expenses = isset($row['total_expenses']) ? $row['total_expenses'] : 0;

// Fetch total withdrawals (if owners take money out)
$withdrawals_stmt = $connect->prepare("SELECT SUM(amount) AS total_withdrawals FROM transactions WHERE category='withdrawal'");
$withdrawals_stmt->execute();
$row = $withdrawals_stmt->fetch(PDO::FETCH_ASSOC);
$total_withdrawals = isset($row['total_withdrawals']) ? $row['total_withdrawals'] : 0;

// Calculate net profit
$net_profit = $total_sales - $total_expenses;

// Fetch previous retained earnings
$prev_retained_stmt = $connect->prepare("SELECT SUM(amount) AS prev_retained FROM equity WHERE type='retained_earnings'");
$prev_retained_stmt->execute();
$row = $prev_retained_stmt->fetch(PDO::FETCH_ASSOC);
$prev_retained = isset($row['prev_retained']) ? $row['prev_retained'] : 0;

// Calculate new retained earnings
$new_retained_earnings = $prev_retained + $net_profit - $total_withdrawals;

// Insert retained earnings into equity table
$insert_stmt = $connect->prepare("INSERT INTO equity (type, amount, description) VALUES ('retained_earnings', ?, 'Quarterly retained earnings update')");
$insert_stmt->execute([$new_retained_earnings]);

echo "Retained Earnings Updated: $" . number_format($new_retained_earnings, 2);

}

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
            <h3 class="card-title">Update Retained Earnings</h3>
          </div> <!-- /.card-body -->
          <div class="card-body">
            <div class="row">
        
               
             
          
              <form method="post" id="insert_form">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Update Retained Earnings</label>
                    <input type="submit" name="update_retained_earnings" id="update_retained_earnings" class="btn btn-primary" value="Update Retained Earnings" />
                  </div>
                </div>
              </form>
              
              
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





