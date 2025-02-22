<?php
include('../config/function.php');
if(!isset($_SESSION["type"]))
{
    header('location:../login.php');
}


include('function.php');
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
              <li class="breadcrumb-item active">Input List</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
<div class="container">
<span id="alert_action"></span>
</div>
    <div class="container">
      <div class="row">
        <div class="col-md-12">


                   <div class="card">
              <div class="card-header">
                <h3 class="card-title">Input List</h3>
               
                <button type="button" name="add" id="add_input" data-toggle="modal" data-target="#inputModal" class="btn btn-primary btn-xs float-right">Add</button>          
               
              </div>
              <!-- /.card-header -->
            <div class="card-body">
 <table id="input_data" class="table table-bordered table-striped">
                                <thead><tr>
                                    <th>ID</th>
                                    <th>Input name</th>
                                    <th>Price</th>
                                    <th>Code</th>
                                    <th>Recorded By</th>
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



<!--Modal ya kuingiza new users-->

  <div id="inputModal" class="modal fade">
        <div class="modal-dialog">
            <form method="post" id="input_form">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                         <h4 class="modal-title"><i class="fa fa-plus"></i> Add Input</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                       
                    </div>
                    <div class="modal-body">
                            <span id="message"></span>
                         
                                <div class="form-group">
                                    <label>Input name</label>
                                    <input type="text" name="input_name" id="input_name" class="form-control" required />
                           
                                 </div>
                                 <div class="form-group">
                                    <label>Enter Price</label>
                                    <input type="text" name="input_price" id="input_price" class="form-control" required />
                                </div>

                                 <div class="form-group">
                                    <label>Input Code</label>
                                  <input type="text" name="input_code" id="input_code" class="form-control" required />
                           
                                 </div>

                                 <div class="form-group">
                                    <label>Notes</label>
                                 <textarea type="text" name="input_notes" id="input_notes" class="form-control"></textarea>
                           
                                 </div>

                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="input_id" id="input_id"/>
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

    $('#add_input').click(function(){
        $('#input_form')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i> Add Input");
        $('#action').val('Add');
        $('#btn_action').val('Add');
    });

    $(document).on('submit','#input_form', function(event){
        event.preventDefault();
        $('#action').attr('disabled','disabled');
        var form_data = $(this).serialize();
        $.ajax({
            url:"input/input_action.php",
            method:"POST",
            data:form_data,
            success:function(data)
            {
                $('#input_form')[0].reset();
                $('#inputModal').modal('hide');
                $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
                $('#action').attr('disabled', false);
                inputTable.ajax.reload();
            }
        })
    });

    $(document).on('click', '.update', function(){
        var input_id = $(this).attr("id");
        var btn_action = 'fetch_single';
        $.ajax({
            url:"input/input_action.php",
            method:"POST",
            data:{input_id:input_id, btn_action:btn_action},
            dataType:"json",
            success:function(data)
            {
                $('#inputModal').modal('show');
                $('#input_name').val(data.input_name);
                $('#input_price').val(data.price);
                $('#input_code').val(data.barcode);
                $('#input_notes').val(data.description);
                $('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Transaction");
                $('#input_id').val(input_id);
                $('#action').val('Edit');
                $('#btn_action').val("Edit");
            }
        })
    });

    var inputTable = $('#input_data').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
            url:"input/input_fetch.php",
            type:"POST"
        },
        "columnDefs":[
            {
                "targets":[6, 7],
                "orderable":false,
            },
        ],
        "pageLength": 10
    });

    $(document).on('click', '.delete', function(){
        var input_id = $(this).attr('id');
        var status = $(this).data("status");
        var btn_action = 'delete';
        if(confirm("Are you sure you want to change status?"))
        {
            $.ajax({
                url:"input/input_action.php",
                method:"POST",
                data:{input_id:input_id, status:status, btn_action:btn_action},
                success:function(data)
                {
                    $('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
                    inputTable.ajax.reload();
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





