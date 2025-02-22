<?php
include('../config/function.php');
if(!isset($_SESSION["type"]))
{
  header('location:../login.php');
}

if($_SESSION["type"] != 'master')
{
  header("location:../index.php");
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
              <li class="breadcrumb-item active">Tax List</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <div class="container">
    <span id="alert_action"></span>
      <div class="row">
        <div class="col-md-12">


                   <div class="card">
              <div class="card-header">
                <h3 class="card-title">Tax List</h3>
               
                 <button type="button" name="add" id="add_tax" data-toggle="modal" data-target="#taxModal" class="btn btn-success btn-xs btn-xs float-right">Add</button>  
              </div>
              <!-- /.card-header -->
            <div class="card-body">
  <table id="tax_data" class="table table-bordered table-striped">
                          <thead><tr>
                  <th>Tax Name</th>
                  <th>Percentage</th>
                  <th>Status</th>
                  <th>Added On</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr></thead>
              </table>
            </div>
          </div>
          
          
        </div>
        
      </div>
      
    </div>




  </div>



<!--Modal ya kuingiza new category-->

    <div id="taxModal" class="modal fade">
      <div class="modal-dialog">
        <form method="post" id="tax_form">
          <div class="modal-content">
            <div class="modal-header bg-info">
                 <h4 class="modal-title"><i class="fa fa-plus"></i> Add Tax</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
           
            </div>
            <div class="modal-body">
              <label>Enter Tax Name</label>
            <input type="text" name="tax_name" id="tax_name" class="form-control" required />
            <label>Enter Tax Percentage</label>
            <input type="text" name="tax_percentage" id="tax_percentage" class="form-control" required />
            </div>
            <div class="modal-footer">
              <input type="hidden" name="tax_id" id="tax_id"/>
              <input type="hidden" name="btn_action" id="btn_action"/>
              <input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </form>
      </div>
    </div>





       <script>
$(document).ready(function(){

  $('#add_tax').click(function(){
    $('#tax_form')[0].reset();
    $('.modal-title').html("<i class='fa fa-plus'></i> Add Tax");
    $('#action').val('Add');
    $('#btn_action').val('Add');
  });

  $(document).on('submit','#tax_form', function(event){
    event.preventDefault();
    $('#action').attr('disabled','disabled');
    var form_data = $(this).serialize();
    $.ajax({
      url:"tax/tax_action.php",
      method:"POST",
      data:form_data,
      success:function(data)
      {
        $('#tax_form')[0].reset();
        $('#taxModal').modal('hide');
        $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
        $('#action').attr('disabled', false);
        taxdataTable.ajax.reload();
      }
    })
  });

  $(document).on('click', '.update_tax', function(){
    var tax_id = $(this).attr("id");
    var btn_action = 'fetch_single';
    $.ajax({
      url:"tax/tax_action.php",
      method:"POST",
      data:{tax_id:tax_id, btn_action:btn_action},
      dataType:"json",
      success:function(data)
      {
        $('#taxModal').modal('show');
        $('#tax_name').val(data.tax_name);
        $('#tax_percentage').val(data.tax_percentage)
        $('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Tax");
        $('#tax_id').val(tax_id);
        $('#action').val('Edit');
        $('#btn_action').val("Edit");
      }
    })
  });

  var taxdataTable = $('#tax_data').DataTable({
    "processing":true,
    "serverSide":true,
    "order":[],
    "ajax":{
      url:"tax/tax_fetch.php",
      type:"POST"
    },
    "columnDefs":[
      {
        "targets":[4, 5],
        "orderable":false,
      },
    ],
    "pageLength": 25
  });
  $(document).on('click', '.delete_tax', function(){
    var tax_id = $(this).attr('id');
    var status = $(this).data("status");
    var btn_action = 'delete';
    if(confirm("Are you sure you want to change status?"))
    {
      $.ajax({
        url:"tax/tax_action.php",
        method:"POST",
        data:{tax_id:tax_id, status:status, btn_action:btn_action},
        success:function(data)
        {
          $('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
          taxdataTable.ajax.reload();
        }
      })
    }
    else
    {
      return false;
    }
  });
});
</script>

<?php

include('includes/footer.php');
?>





