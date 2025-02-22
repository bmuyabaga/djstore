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


    <link rel="stylesheet" href="assets/dist/css/datepicker.css">
    <script src="assets/dist/js/bootstrap-datepicker1.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>

    <script>
    // $(document).ready(function(){
    //     $('#expense_date').datepicker({
    //         format: "yyyy-mm-dd",
    //         autoclose: true
    //     });
    // });
    </script>

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
<div class="container">
<span id="alert_action"></span>
</div>
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
<table id="expense_data" class="table table-bordered table-striped">
                    <thead>
              <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Expense name</th>
                <th>Amount</th>
                <th>Payment Method</th>
                <th>Description</th>
                                <th>Expense Status</th>
                <th>Edit</th>
                                <th>View</th>
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



<!--Modal ya kuingiza new users-->

 <div id="expenseModal" class="modal fade">
        <div class="modal-dialog">
            <form method="post" id="expense_form">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Add Brand</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                     <label>Expense name</label>
                                    <select name="expenseaccount_id" id="expenseaccount_id" style="width: 100%;" class="form-control selectbox" required>
                                <option value="">Please Select</option>
                                <?php echo fill_expense_account_list($connect); ?>
                            </select>
                                </div>
                                
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="date" name="expense_date" id="expense_date" class="form-control" required />
                                </div>
                                </div>
                                
                     
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input type="text" name="quantity" id="quantity" class="form-control" required />
                                </div>
                            </div>
                            
                            
                                <div class="col-md-12">
                                <div class="form-group">
                                    <label>Units</label>
                                    <input type="text" name="units" id="units" class="form-control" required />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Units Cost</label>
                                    <input type="text" name="units_cost" id="units_cost" class="form-control" required />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Total cost</label>
                                    <input type="text" name="total_cost" id="total_cost" class="form-control" required />
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Enter Payment Method</label>
                                    <select type="text" name="pay_method" id="pay_method" class="form-control" required>
                                        <option value="">Please Select</option>
                                        <option value="cash">Cash</option>
                                        <option value="tigo_pesa">Tigo Pesa</option>
                                        <option value="transfer">Bank</option>
                                    </select>
                                </div>
                            </div>
                            

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Enter Notes</label>
                                    <textarea type="text" name="notes" id="notes" class="form-control"></textarea>
                                </div>
                            </div>
                            
                            

                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="expense_id" id="expense_id" />
                        <input type="hidden" name="btn_action" id="btn_action" />
                        <input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
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






  var clientdataTable = $('#expense_data').DataTable({
    "processing":true,
    "serverSide":true,
    "order":[],
    "ajax":{
      url:"expense/expense_fetch.php",
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





