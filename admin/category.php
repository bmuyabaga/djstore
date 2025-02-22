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
              <li class="breadcrumb-item active">Category List</li>
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
                <h3 class="card-title">Category List</h3>
               
                 <button type="button" name="add" id="add_category" data-toggle="modal" data-target="#categoryModal" class="btn btn-success btn-xs btn-xs float-right">Add</button>  
              </div>
              <!-- /.card-header -->
            <div class="card-body">
               <table id="category_data" class="table table-bordered table-striped">
                          <thead><tr>
                  <th>ID</th>
                  <th>Category Name</th>
                  <th>Status</th>
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

    <div id="categoryModal" class="modal fade">
      <div class="modal-dialog">
        <form method="post" id="category_form">
          <div class="modal-content">
            <div class="modal-header bg-info">
                 <h4 class="modal-title"><i class="fa fa-plus"></i> Add Category</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
           
            </div>
            <div class="modal-body">
              <label>Enter Category Name</label>
            <input type="text" name="category_name" id="category_name" class="form-control" required />
            </div>
            <div class="modal-footer">
              <input type="hidden" name="category_id" id="category_id"/>
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

  $('#add_category').click(function(){
    $('#category_form')[0].reset();
    $('.modal-title').html("<i class='fa fa-plus'></i> Add Category");
    $('#action').val('Add');
    $('#btn_action').val('Add');
  });

  $(document).on('submit','#category_form', function(event){
    event.preventDefault();
    $('#action').attr('disabled','disabled');
    var form_data = $(this).serialize();
    $.ajax({
      url:"category/category_action.php",
      method:"POST",
      data:form_data,
      success:function(data)
      {
        $('#category_form')[0].reset();
        $('#categoryModal').modal('hide');
        $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
        $('#action').attr('disabled', false);
        categorydataTable.ajax.reload();
      }
    })
  });

  $(document).on('click', '.update', function(){
    var category_id = $(this).attr("id");
    var btn_action = 'fetch_single';
    $.ajax({
      url:"category/category_action.php",
      method:"POST",
      data:{category_id:category_id, btn_action:btn_action},
      dataType:"json",
      success:function(response)
      {
        $('#categoryModal').modal('show');
        $('#category_name').val(response.category_name);
        $('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Category");
        $('#category_id').val(category_id);
        $('#action').val('Edit');
        $('#btn_action').val("Edit");

        // var res = JSON.parse(response);
        //         if(res.status == 200)
        //         {
        //             swal(res.message,res.message,res.status_type);
        //         }
        //         else
        //         {
        //             swal(res.message,res.message,res.status_type);
        //         }
      }
    })
  });

  var categorydataTable = $('#category_data').DataTable({
    "processing":true,
    "serverSide":true,
    "order":[],
    "ajax":{
      url:"category/category_fetch.php",
      type:"POST"
    },
    "columnDefs":[
      {
        "targets":[3, 4],
        "orderable":false,
      },
    ],
    "pageLength": 25
  });
  $(document).on('click', '.delete', function(){
    var category_id = $(this).attr('id');
    var status = $(this).data("status");
    var btn_action = 'delete';
    if(confirm("Are you sure you want to change status?"))
    {
      $.ajax({
        url:"category/category_action.php",
        method:"POST",
        data:{category_id:category_id, status:status, btn_action:btn_action},
        success:function(data)
        {
          $('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
          categorydataTable.ajax.reload();
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





