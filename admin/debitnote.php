<?php
include('../config/function.php');

if(!isset($_SESSION["type"]))
{
  header('location:../login.php');
}

if($_SESSION["type"] != 'master')
{
  header("location:..index.php");
}
include('includes/header.php');
include('includes/topbar.php');


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
              <li class="breadcrumb-item active">Debit Note List</li>
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
                <h3 class="card-title">Debit Norte List</h3>
               
                <button type="button" name="add" id="add_debit" data-toggle="modal" data-target="#userModal" class="btn btn-primary btn-xs float-right">Add</button>
              </div>
              <!-- /.card-header -->
            <div class="card-body">
   <table id="debitnote_data" class="table table-bordered table-striped">
                    <thead>
              <tr>
                <th>Debit Note ID</th>
                <th>Sales ID</th>
                <th>ZFDA Invoice Number</th>
                <th>PDF</th>
                <th>Date</th>
                <th>Customer Name</th>              
                <th>Amount</th>
                <th>Status</th>
                <th>Username</th>
                <th>pdf</th>
           
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

   <div id="debitModal" class="modal fade">
        <div class="modal-dialog">
            <form method="post" id="debit_form">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Add Debit Note</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Sales Invoice Number</label>
                                    <input type="text" name="salesinvpoce" id="salesinvoice" class="form-control" required />
                                </div>
                                </div>
                               <div class="col-md-12"> 
                              <div class="form-group">
                                <select name="client_idd" id="client_idd" class="form-control select_client" style="width: 100%;" required>
                                <option value="">Select Customer</option>
                                <?php echo fill_client_list($connect); ?>
                              </select>
                              </div>
                              </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Instituition Invoice Number</label>
                                    <input type="text" name="zfdainvoice" id="zfdainvoice" class="form-control" required />
                                </div>
                                </div>
                                
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>ZFDA PDF Link</label>
                                    <input type="text" name="invoice_pdf" id="invoice_pdf" class="form-control" required />
                                </div>
                            </div>
                            
                            
                                <div class="col-md-12">
                                <div class="form-group">
                                    <label>Invoice Amount</label>
                                    <input type="text" name="invoice_amount" id="invoice_amount" class="form-control" required />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Company Name</label>
                                    <input type="text" name="organization" id="organization" class="form-control" required />
                                </div>
                            </div>
                             <div class="col-md-12">
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="date" name="debit_date" id="debit_date" class="form-control" required />
                                </div>
                            </div>
                           
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Enter Notes</label>
                                    <textarea type="text" name="debit_notes" id="debit_notes" class="form-control"></textarea>
                                </div>
                            </div>
                            
                            

                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="debitnote_id" id="debitnote_id" />
                        <input type="hidden" name="btn_action" id="btn_action" />
                        <input type="submit" name="action_debit" id="action_debit" class="btn btn-info" value="Add" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
     </div>





       <script>
$(document).ready(function(){

    $('.select_client').select2({
      theme: 'bootstrap4'
    });

  $('#add_debit').click(function(){
    $('#debitModal').modal('show');
    $('#debit_form')[0].reset();
    $('.modal-title').html("<i class='fa fa-plus'></i> Add Debit note");
    $('#action_debit').val('Add');
    $('#btn_action').val('Add');
  });

  $(document).on('submit','#debit_form', function(event){
    event.preventDefault();
    $('#action_debit').attr('disabled','disabled');
    var form_data = $(this).serialize();
    $.ajax({
      url:"debit_note/debitnote_action.php",
      method:"POST",
      data:form_data,
      success:function(data)
      {
        $('#debit_form')[0].reset();
        $('#debitModal').modal('hide');
        $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
        $('#action_debit').attr('disabled', false);
         debitnoteTable.ajax.reload();
      }
    })
  });
    

     $(document).on('click', '.update', function(){
        var debitnote_id = $(this).attr("id");
        var btn_action = 'fetch_single';

            $.ajax({
            url:"vendor/debitnote_action.php",
            method:"POST",
            data:{debitnote_id:debitnote_id, btn_action:btn_action},
            dataType:"json",
            success:function(data)
            {
           
                $('#debitModal').modal('show');
                $('#supplier').val(data.vname);
                $('#supplier_contact').val(data.contactno);
                $('#supplier_email').val(data.email);
                $('#supplier_tin').val(data.tin_no);
                $('#supplier_address').val(data.address);
                $('#supplier_notes').val(data.notes);
               
                $('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Supplier");
                $('#debitnote_id').val(debitnote_id);
                $('#action_debit').val('Edit');
                $('#btn_action').val('Edit');
                 debitnoteTable.ajax.reload();
         
            }
        })
    
  });






  $(document).on('click','.delete', function(){
    var debitnote_id = $(this).attr("id");
    var status  = $(this).data('status');
    var btn_action = 'delete';
    if(confirm("Are you sure you want to change status?"))
    {
      $.ajax({
        
                url:"vendor/debitnote_action.php",
                method:"POST",
                data:{debitnote_id:debitnote_id, status:status, btn_action:btn_action},
                success:function(data)
                {
                    $('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
                    debitnoteTable.ajax.reload();
                }
      })
    }
    else
    {
      return false;
    }
  });


  var debitnoteTable = $('#debitnote_data').DataTable({
    "processing":true,
    "serverSide":true,
    "order":[],
    "ajax":{
      url:"debit_note/debit_note_fetch.php",
      type:"POST"
    },
    "columnDefs":[
      {
        "targets":[3,8, 9, 10],
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





