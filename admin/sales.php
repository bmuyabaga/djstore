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
              <li class="breadcrumb-item active">Sales List</li>
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
                <h3 class="card-title">Sales List</h3>
               
                <button type="button" name="add" id="add_button" data-toggle="modal" data-target="#userModal" class="btn btn-primary btn-xs float-right">Add</button>
              </div>
              <!-- /.card-header -->
            <div class="card-body">
             <table id="order_data" class="table table-bordered table-striped">
                    <thead>
              <tr>
                

                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Total Amount</th>
                <th>Paid</th>
                <th>Due</th>
                <th>Payment Status</th>
                <th>Order Status</th>
                <th>Order Date</th>
                <?php
                if($_SESSION['type'] == 'master')
                {
                  echo '<th>Created By</th>';
                }
                ?>
                <th></th>
                <th></th>
                <th></th>
              </tr>
            </thead>
                  </table>


            </div>
          </div>
          
          
        </div>
        



      </div>
      
    </div>




  </div>


    <!--modal-->
              <div id="paymentModal" class="modal fade">

      <div class="modal-dialog">
        <form method="post" id="order_form" method="post" action="payments/add_payment.php" name="autoSumForm">
          <div class="modal-content">
            <div class="modal-header bg-info" >
             
            <h4 class="modal-title" style="color: white;">Add Payment</h4>
             <button type="button" class="close" data-dismiss="modal" style="color: white;">&times;</button>
            </div>
            <div class="modal-body">
              <p id="message" class="text-dark"></p>
             

      <div class="form-group">
            <label>Invoice</label>
              <select name="invoiceno" id="invoiceno" class="form-control" />
                <option value=""></option>
                 <input type="hidden" name="totalOutstanding" id="totalOutstanding"  class="form-control amount" onFocus="startCalcate();" onBlur="stopCalcate();"  tabindex="8"  />
                 <input type="hidden" name="customerid" id="customerid"  class="form-control " />
               
              </select>
            </div>

             <div class="form-group">
              <label>Received On</label>
              <input type="date" name="Received" id="Received" class="form-control" required/>
            </div>
          

            <div class="form-group">
            <label>Select Payment Method</label>
              <select name="paymentMethod" id="paymentMethod" class="form-control"  required/>
                <option value="cash">Cash</option>
                <option value="transfer">Bank</option>
                <option value="tigo_pesa">Tigo Pesa</option>
              </select>
            </div>
           
            <div class="form-group">
              <label>Amount Paid</label>
              <input type="text" name="amountPaid" id="amountPaid" value="0" class="form-control" tabindex="9"  onFocus="startCalcate();" onBlur="stopCalcate();" value="" required/>
             
             
            </div>
            
            <div class="form-group">
              <label>Balance</label>
              <input type="text" name="balance" id="balance" class="form-control" value="" disabled/>
              
            </div>
            <div class="form-group">
              <label>Notes</label>
              <textarea type="text" name="paymentNotes" id="paymentNotes" class="form-control"  ></textarea>
            </div>
            </div>
            <div class="modal-footer">
              <input type="hidden" name="salesID" id="salesID" />
              <input type="hidden" name="clientID" id="clientID" />
              <input type="hidden" name="btn_action" id="btn_action" />
              <!--<input type="submit" name="action" id="action" class="btn btn-info" value="" />-->
              
             
                    <button class="btn btn-info" id="daterange-btn" name="cash" type="submit"  tabindex="7">
                       Add
                      </button>
            
            </div>
          </div>
        </form>
      </div>

    </div>





     

    

<script type="text/javascript">
    $(document).ready(function(){

     // insert_payment();
    

      var orderdataTable = $('#order_data').DataTable({
      "processing":true,
      "serverSide":true,
      "order":[],
      "ajax":{
        url:"sales/sales_fetch.php",
        type:"POST"
      },
      <?php
      if($_SESSION["type"] == 'master')
      {
      ?>
      "columnDefs":[
        {
          "targets":[4, 5, 6, 7, 8, 9],
          "orderable":false,
        },
      ],
      <?php
      }
      else
      {
      ?>
      "columnDefs":[
        {
          "targets":[6, 7, 8, 9, 10],
          "orderable":false,
        },
      ],
      <?php
      }
      ?>
      "pageLength": 10
    });

    $('#add_button').click(function(){
      $('#paymentModal').modal('show');
      $('#order_form')[0].reset();
      $('.modal-title').html("<i class='fa fa-plus'></i> Create Order");
      $('#action').val('Add');
      $('#btn_action').val('Add');
      $('#span_product_details').html('');
      add_product_row();
    });

    
    $(document).on('click', '.update', function(){
      var inventory_order_id = $(this).attr("id");
      var btn_action = 'fetch_single';
      $.ajax({
        url:"sales/sales_action.php",
        method:"POST",
        data:{inventory_order_id:inventory_order_id, btn_action:btn_action},
        dataType:"json",
        success:function(data)
        {
          $('#paymentModal').modal('show');
          $('#salesId').val(data.sales_id);
          $('#clientName').val(data.client_name);
          $('#customerid').val(data.client_id);
          $('#totalOutstanding').val(data.balance);
          $('#invoiceno').html(data.sales_id);
          $('#payment_status').val(data.payment_status);
          $('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Add Payment");
          $('#clientID').val(data.client_id);
          $('#action').val('Edit');
          $('#btn_action').val('Edit');
        }
      })
    });
    // Insert payment into the payment Table




    $(document).on('click', '.delete', function(){
      var inventory_order_id = $(this).attr("id");
      var status = $(this).data("status");
      var btn_action = "delete";
      if(confirm("Are you sure you want to change status?"))
      {
        $.ajax({
          url:"order_action.php",
          method:"POST",
          data:{inventory_order_id:inventory_order_id, status:status, btn_action:btn_action},
          success:function(data)
          {
            $('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
            orderdataTable.ajax.reload();
          }
        })
      }
      else
      {
        return false;
      }
    });
 
 

    });
    
     $(function(){
  $("#totalOutstanding, #amountPaid").on("keydown keyup click", amountPaid);

  function amountPaid()
  {

    var sum = (Number($('#totalOutstanding').val()) - Number($('#amountPaid').val()));

    $("#balance").val(sum);

  }





  });
</script>




<?php

include('includes/footer.php');
?>





