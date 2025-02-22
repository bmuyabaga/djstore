<?php
include('../config/function.php');
if(!isset($_SESSION["type"]))
{
  header('location:login.php');
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
               
                <!--<button type="button" name="add" id="add_button" data-toggle="modal" data-target="#userModal" class="btn btn-primary btn-xs float-right">Add</button>-->
              </div>
              <!-- /.card-header -->
            <div class="card-body">
<table id="payment_data" class="table table-bordered table-striped">
                    <thead>
              <tr>
                <th>PaymentID</th>
                <th>Sales ID</th>
                <th>Client Name</th>
                <th>Payment Date</th>
                <th>Payment Method</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Edit</th>
                <th>Print</th>
                <th>Delete</th>
              </tr>
            </thead>
                  </table><script>
$(document).ready(function(){

  $('#add_button').click(function(){
    $('#paymentModal').modal('show');
    $('#brand_form')[0].reset();
    $('.modal-title').html("<i class='fa fa-plus'></i> Add Brand");
    $('#action').val('Add');
    $('#btn_action').val('Add');
  });

  $(document).on('submit','#brand_form', function(event){
    event.preventDefault();
    $('#action').attr('disabled','disabled');
    var form_data = $(this).serialize();
    $.ajax({
      url:"brand_action.php",
      method:"POST",
      data:form_data,
      success:function(data)
      {
        $('#brand_form')[0].reset();
        $('#paymentModal').modal('hide');
        $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
        $('#action').attr('disabled', false);
        branddataTable.ajax.reload();
      }
    })
  });

  $(document).on('click', '.update', function(){
    var brand_id = $(this).attr("id");
    var btn_action = 'fetch_single';
    $.ajax({
      url:'brand_action.php',
      method:"POST",
      data:{brand_id:brand_id, btn_action:btn_action},
      dataType:"json",
      success:function(data)
      {
        $('#paymentModal').modal('show');
        $('#category_id').val(data.category_id);
        $('#brand_name').val(data.brand_name);
        $('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Brand");
        $('#brand_id').val(brand_id);
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
        url:"brand_action.php",
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


  var branddataTable = $('#payment_data').DataTable({
    "processing":true,
    "serverSide":true,
    "order":[],
    "ajax":{
      url:"payments/sales_payment_fetch.php",
      type:"POST"
    },
    "columnDefs":[
      {
        "targets":[7, 8,9],
        "orderable":false,
      },
    ],
    "pageLength": 10
  });

});
</script>




            </div>
          </div>
          
          
        </div>
        



      </div>
      
    </div>




  </div>


    
    
    






<?php

include('includes/footer.php');
?>





