<?php
include('../config/function.php');
if(!isset($_SESSION["type"]))
{
  header('location:../login.php');
}


include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');

// Fetch data from the database
$sql = "SELECT * FROM orders  
        LEFT JOIN orders_item ON orders.order_id = orders_item.order_id
        LEFT JOIN client ON orders.client_id = client.client_id
        LEFT JOIN product ON orders_item.product_code = product.product_code OR orders_item.product_id = product.product_id
        LEFT JOIN user_details ON orders.user_id = user_details.user_id
        ORDER BY client_name, order_date ASC";
$stmt = $connect->prepare($sql);
$stmt->execute();

$clients = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $clients[$row['client_name']][] = $row;
}


?>


    <link rel="stylesheet" href="assets/dist/css/datepicker.css">
    <script src="assets/dist/js/bootstrap-datepicker1.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>

    <script>
    $(document).ready(function(){
        $('#expense_date').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true
        });
    });
    </script>
  <!--<style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .table-header {
            background-color: #007bff;
            color: white;
        }
        .highlight {
            background-color: #f2f2f2;
        }
        .section-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>-->
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
              <li class="breadcrumb-item active">Registered Users</li>
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


                   <div class="card">
              <div class="card-header">
                <h3 class="card-title">Registered Users</h3>
               
                <button type="button" name="add" id="add_expense" data-toggle="modal" data-target="#userModal" class="btn btn-primary btn-xs float-right">Add</button>
              </div>
              <!-- /.card-header -->
            <div class="card-body">
             <!--orders area start--> 
                   <!-- Hotel Verde -->
        <?php if (!empty($clients)): ?>
        <?php foreach ($clients as $clientName => $orders): ?>
        <h2 class="section-title"><?= htmlspecialchars($clientName) ?></h2>
        <table class="table table-bordered">
            <thead class="table-header">
                <tr>
                    <th>Date</th>
                    <th>SKU</th>
                    <th>Qty</th>
                    <th>Product</th>
                    <th>Units</th>
                    <th>&Sigma; Stock</th>
                    <th>ETD</th>
                    <th>Order Nr.</th>
                    <th>By</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= htmlspecialchars($order['order_date']) ?></td>
                    <td><?= htmlspecialchars($order['product_code']) ?></td>
                    <td><?= htmlspecialchars($order['qty']) ?></td>
                    <td><?= htmlspecialchars($order['product_name']) ?></td>
                    <td><?= htmlspecialchars($order['product_unit']) ?></td>
                    <td><?= htmlspecialchars($order['product_quantity']) ?></td>
                    <td>2025-01-29</td>
                    <td><?= htmlspecialchars($order['order_id']) ?></td>
                    <td><?= htmlspecialchars($order['user_name']) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
        </table>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No records found.</p>
    <?php endif; ?>
        
             <!--orders area end-->
            </div>
          </div>
          
          
        </div>
        
      </div>
      
    </div>




  </div>





<script>
$(document).ready(function(){


  $('#add_expense').click(function(){
    $('#expenseModal').modal('show');
    $('#expense_form')[0].reset();
    $('.modal-title').html("<i class='fa fa-plus'></i> Add Expense");
    $('#action').val('Add');
    $('#btn_action').val('Add');
  });

  $(document).on('submit','#expense_form', function(event){
    event.preventDefault();
    $('#action').attr('disabled','disabled');
    var form_data = $(this).serialize();
    $.ajax({
      url:"expense/expense_action.php",
      method:"POST",
      data:form_data,
      success:function(data)
      {
        $('#expense_form')[0].reset();
        $('#expenseModal').modal('hide');
        $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
        $('#action').attr('disabled', false);
        clientdataTable.ajax.reload();
      }
    })
  });
    

     $(document).on('click', '.update', function(){
        var expense_id = $(this).attr("id");
        var btn_action = 'fetch_single';
        $.ajax({
            url:"expense/expense_action.php",
            method:"POST",
            data:{expense_id:expense_id, btn_action:btn_action},
            dataType:"json",
            success:function(data)
      {
         console.log(expense_id);
                console.log(data.expenseaccount_id);

                $('#expenseModal').modal('show');
                $('#expenseaccount_id').val(data.expenseaccount_id);
                $('#expense_date').val(data.expense_date);
                $('#quantity').val(data.quantity);
                $('#units').val(data.units);
                $('#units_cost').val(data.expense_unit_cost);
                $('#total_cost').val(data.expense_total_cost);
                $('#pay_method').val(data.payment_method);
                $('#notes').val(data.description);
              
                $('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Client");
                $('#expense_id').val(expense_id);
                $('#action').val('Edit');
                $('#btn_action').val('Edit');
         
      }
    })
  });






  $(document).on('click','.delete', function(){
    var brand_id = $(this).attr("id");
    var status  = $(this).data('status');
    var btn_action = 'delete';
    if(confirm("Are you sure you want to change status?"))
    {
      $.ajax({
        url:"expense/expense_action.php",
        method:"POST",
        data:{brand_id:brand_id, status:status, btn_action:btn_action},
        success:function(data)
        {
          $('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
          branddataTable.ajax.reload();
        }
      })
    }
    else
    {
      return false;
    }
  });


  // $(function () {
  //   $("#orderTable").DataTable({
  //     "responsive": true,
  //     "autoWidth": false,
  //   });
  // });



  // var clientdataTable = $('#order_data').DataTable({
  //   "processing":true,
  //   "serverSide":true,
  //   "order":[],
  //   "ajax":{
  //     url:"order/order_fetch.php",
  //     type:"POST"
  //   },
  //   "columnDefs":[
  //     {
  //       "targets":[7],
  //       "orderable":false,
  //     },
  //   ],
  //   "pageLength": 10
  // });

});





  $(function(){
  $("#quantity, #units_cost").on("keydown keyup click", units_cost);

  function units_cost()
  {

    var sum = (Number($('#quantity').val()) * Number($('#units_cost').val()));

    $("#total_cost").val(sum);
  }



   $('.selectbox').select2({
    theme: 'bootstrap4'

   });


 });

 
   


</script>

<?php

include('includes/footer.php');
?>





