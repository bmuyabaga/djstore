
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
               
                <button type="button" name="add" id="add_vendor" data-toggle="modal" data-target="#userModal" class="btn btn-primary btn-xs float-right">Add</button>
              </div>
              <!-- /.card-header -->
            <div class="card-body">
   <table id="supplier_data" class="table table-bordered table-striped">
                    <thead>
              <tr>
                <th>ID</th>
                <th>Supplier name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Tin Number</th>
                               
                <th>Address</th>
                <th>Status</th>
                <th>Edit</th>
                <th>Details</th>
                <th>Delete</th>
              </tr>
            </thead>
                  </table>
            </div>
          </div>
          
          
        </div>
        
      </div>
      
    </div>




  </div>



<!--Modal ya kuingiza new supplier-->

   <div id="vendorModal" class="modal fade">
        <div class="modal-dialog">
            <form method="post" id="vendor_form">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Add Brand</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Suppler Name</label>
                                    <input type="text" name="supplier" id="supplier" class="form-control" required />
                                </div>
                                </div>
                                
                           

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Contact</label>
                                    <input type="text" name="supplier_contact" id="supplier_contact" class="form-control" required />
                                </div>
                                </div>
                                
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="supplier_email" id="supplier_email" class="form-control" required />
                                </div>
                            </div>
                            
                            
                                <div class="col-md-12">
                                <div class="form-group">
                                    <label>TIN Number</label>
                                    <input type="text" name="supplier_tin" id="supplier_tin" class="form-control" required />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" name="supplier_address" id="supplier_address" class="form-control" required />
                                </div>
                            </div>
                           
                            

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Enter Notes</label>
                                    <textarea type="text" name="supplier_notes" id="supplier_notes" class="form-control"></textarea>
                                </div>
                            </div>
                            
                            

                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="vendor_id" id="vendor_id" />
                        <input type="hidden" name="btn_action" id="btn_action" />
                        <input type="submit" name="action_vendor" id="action_vendor" class="btn btn-info" value="Add" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
     </div>





       <script>
$(document).ready(function(){

  $('#add_vendor').click(function(){
    $('#vendorModal').modal('show');
    $('#vendor_form')[0].reset();
    $('.modal-title').html("<i class='fa fa-plus'></i> Add Supplier");
    $('#action_vendor').val('Add');
    $('#btn_action').val('Add');
  });

  $(document).on('submit','#vendor_form', function(event){
    event.preventDefault();
    $('#action_vendor').attr('disabled','disabled');
    var form_data = $(this).serialize();
    $.ajax({
      url:"vendor/vendor_action.php",
      method:"POST",
      data:form_data,
      success:function(data)
      {
        $('#vendor_form')[0].reset();
        $('#vendorModal').modal('hide');
        $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
        $('#action_vendor').attr('disabled', false);
         supplierdataTable.ajax.reload();
      }
    })
  });
    

     $(document).on('click', '.update', function(){
        var vendor_id = $(this).attr("id");
        var btn_action = 'fetch_single';

            $.ajax({
            url:"vendor/vendor_action.php",
            method:"POST",
            data:{vendor_id:vendor_id, btn_action:btn_action},
            dataType:"json",
            success:function(data)
            {
           


                $('#vendorModal').modal('show');
                $('#supplier').val(data.vname);
                $('#supplier_contact').val(data.contactno);
                $('#supplier_email').val(data.email);
                $('#supplier_tin').val(data.tin_no);
                $('#supplier_address').val(data.address);
                $('#supplier_notes').val(data.notes);
               
                $('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Supplier");
                $('#vendor_id').val(vendor_id);
                $('#action_vendor').val('Edit');
                $('#btn_action').val('Edit');
                 supplierdataTable.ajax.reload();
         
            }
        })
    
  });






  $(document).on('click','.delete', function(){
    var vendor_id = $(this).attr("id");
    var status  = $(this).data('status');
    var btn_action = 'delete';
    if(confirm("Are you sure you want to change status?"))
    {
      $.ajax({
        
                url:"vendor/vendor_action.php",
                method:"POST",
                data:{vendor_id:vendor_id, status:status, btn_action:btn_action},
                success:function(data)
                {
                    $('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
                    supplierdataTable.ajax.reload();
                }
      })
    }
    else
    {
      return false;
    }
  });


  var supplierdataTable = $('#supplier_data').DataTable({
    "processing":true,
    "serverSide":true,
    "order":[],
    "ajax":{
      url:"vendor/vendor_fetch.php",
      type:"POST"
    },
    "columnDefs":[
      {
        "targets":[7, 8, 9],
        "orderable":false,
      },
    ],
    "pageLength": 10
  });

});
</script>

<?php

include('includes/footer.php');
?>





