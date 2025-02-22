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
              <li class="breadcrumb-item active">Employee List</li>
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
                <h3 class="card-title">Employee List</h3>
               
                <button type="button" name="add" id="add_loan" data-toggle="modal" data-target="#loanModal"   class="btn btn-primary btn-xs float-right">Add</button>
               
              </div>
              <!-- /.card-header -->
            <div class="card-body">
  <table id="loan_data" class="table table-bordered table-striped">
                                <thead><tr>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Employee Name</th>
                                    <th>Amount</th>
                                    <th>Return On</th>
                                    <th>Amount Returned</th>
                                    <th>Balance</th>
                                    <th>Status</th>
                                    <th>Edit</th>
                                    <th>Pay</th>
                                    <th>Delete</th>
                                </tr></thead>
                            </table>
            </div>
          </div>
          
          
        </div>
        
      </div>
      
    </div>




  </div>



<div id="loanModal" class="modal fade">
        <div class="modal-dialog">
            <form method="post" id="loan_form">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Add Loan</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        
                    </div>
                    <div class="modal-body">
                            <span id="message"></span>

                            <div class="form-group">
                                    <label>Date</label>
                                    <input type="date" name="loandate" id="loandate" class="form-control" required />
                                </div>

                         
                                <div class="form-group">
                                    <label>Employee</label>
                                    <select type="text" name="employeeId" id="employeeId" class="form-control" required>
                                        <option value="">Please Select Employee</option>
                                       <?php echo fill_employee_list($connect);  ?>
                                       
                                    </select>
                           
                                 </div>
                                 <div class="form-group">
                                    <label>Enter Amount</label>
                                    <input type="number" name="loanamount" id="loanamount" class="form-control" required />
                                </div>

                                <div class="form-group">
                                    <label>Return Date</label>
                                    <input type="date" name="returndate" id="returndate" class="form-control" required />
                                </div>

                           <div class="form-group">
                                 <label>Employee</label>
                                  <select type="text" name="paymentmethod" id="paymentmethod" class="form-control" required>
                                     <option value="">Please Select</option>
                                        <option value="">Payment Method</option>
                                        <option value="cash">Cash</option>
                                        <option value="transfer">Transfer</option>
                                        <option value="tigo_pesa">Tigo Pesa</option>
                                       
                                 </select>
                           
                            </div>


                           <div class="form-group">
                            <label>Notes</label>
                            <textarea type="text" name="loannotes" id="loannotes" class="form-control"  ></textarea>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="loan_id" id="loan_id"/>
                        <input type="hidden" name="btn_action" id="btn_action"/>
                        <input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    
      <!--MODAL YA KU ADD PAYMENT LOAN-->

     <div id="malipoModal" class="modal fade">

        <div class="modal-dialog">
            <form method="post" id="order_form">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Add Payment</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        
                    </div>
                    <div class="modal-body">
                        <p id="message" class="text-dark"></p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> Loan ID</label>
                                <input type="text" name="loanloanID" id="loanloanID" class="form-control"  disabled />
                                    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="date" name="loanloanDate" id="loanloanDate" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Employee Name</label>
                            <input type="text" name="employeejina" id="employeejina" class="form-control" disabled />
                        </div>
                        <div class="form-group">
                        <label>Select Payment Method</label>
                            <select name="paypaymethod" id="paypaymethod" class="form-control" />
                                <option value="cash">Cash</option>
                                <option value="transfer">Bank</option>
                                <option value="tigo_pesa">Tigo Pesa</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Total Outstanding</label>
                            <input type="text" name="totaltotaloutstanding" id="totaltotaloutstanding" class="form-control" disabled />
                        </div>
                        <div class="form-group">
                            <label>Amount Paid</label>
                            <input type="text" name="amountamountpaid" id="amountamountpaid" class="form-control" />
                        </div>                      
                        <div class="form-group">
                            <label>Notes</label>
                            <textarea type="text" name="paypaynotes" id="paypaynotes" class="form-control"  ></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="malipoId" id="malipoId" />
                        <input type="hidden" name="employeeIDID" id="employeeIDID" />
                        <input type="hidden" name="btn_Action" id="btn_Action" />
                        <!--<input type="submit" name="action" id="action" class="btn btn-info" value="Add" />-->
                        <button type="button" name="loanPayAdd" id="loanPayAdd" class="btn btn-info" value="Add">Add</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
        

<script>
$(document).ready(function(){

    addLoanpayment();
insertLoan_payment();

    $('#add_loan').click(function(){
        $('#loan_form')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i> Add Loan Application");
        $('#action').val('Add');
        $('#btn_action').val('Add');
    });

    $(document).on('submit','#loan_form', function(event){
        event.preventDefault();
        $('#action').attr('disabled','disabled');
        var form_data = $(this).serialize();
        $.ajax({
            url:"loan/loan_action.php",
            method:"POST",
            data:form_data,
            success:function(data)
            {
                $('#loan_form')[0].reset();
                $('#loanModal').modal('hide');
                $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
                $('#action').attr('disabled', false);
                loanTable.ajax.reload();
            }
        })
    });

    $(document).on('click', '.update', function(){
        var loan_id = $(this).attr("id");
        var btn_action = 'fetch_single';
        $.ajax({
            url:"loan/loan_action.php",
            method:"POST",
            data:{loan_id:loan_id, btn_action:btn_action},
            dataType:"json",
            success:function(data)
            {
                $('#loanModal').modal('show');
                $('#loandate').val(data.loan_date);
                $('#employeeId').val(data.first_name);
                $('#loanamount').val(data.amount);
                $('#returndate').val(data.return_date);
                $('#paymentmethod').val(data.payment_method);
                $('#loannotes').val(data.notes);
                $('#loan_id').val(data.loan_id);
                $('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Transaction");
                $('#loan_id').val(loan_id);
                $('#action').val('Edit');
                $('#btn_action').val("Edit");
            }
        })
    });

    var loanTable = $('#loan_data').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
            url:"loan/loan_fetch.php",
            type:"POST"
        },
        "columnDefs":[
            {
                "targets":[8, 9,10],
                "orderable":false,
            },
        ],
        "pageLength": 10
    });
    // $(document).on('click', '.delete', function(){
    //     var loan_id = $(this).attr('id');
    //     var status = $(this).data("status");
    //     var btn_action = 'delete';
    //     if(confirm("Are you sure you want to change status?"))
    //     {
    //         $.ajax({
    //             url:"nmb/nmb_action.php",
    //             method:"POST",
    //             data:{loan_id:loan_id, status:status, btn_action:btn_action},
    //             success:function(data)
    //             {
    //                 $('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
    //                 nmbTable.ajax.reload();
    //             }
    //         })
    //     }
    //     else
    //     {
    //         return false;
    //     }
    // });












    function addLoanpayment()
{
   $(document).on('click', '.malipo', function(){

  var loanPayment = $(this).attr('id');

    
       $.ajax({
        url:"loan/loan_repayment_fetch.php",
        method:"POST",
        data:{loanID:loanPayment},
        dataType:"json",
        success:function(data)
        {
                  $('#malipoId').val(data.loan_id);
                  $('#loanloanID').val(data.loan_id);
                  $('#employeejina').val(data.first_name);
                  $('#employeeIDID').val(data.emp_id);
                  $('#totaltotaloutstanding').val(data.balance);
                  $('#malipoModal').modal('show');
                 


            }

    })

   })

}



function insertLoan_payment(){

    $(document).on('click','#loanPayAdd', function(){
     
      var loanloanID = $('#loanloanID').val();
      var loanloanDate = $('#loanloanDate').val();
      var employeejina = $('#employeejina').val();
      var paypaymethod = $('#paypaymethod').val();
      
     var totaltotaloutstanding = $('#totaltotaloutstanding').val();
       var amountamountpaid = $('#amountamountpaid').val();
         var paypaynotes = $('#paypaynotes').val();
          //var ppaymentNotes = $('#ppaymentNotes').val();
          var employeeIDID = $('#employeeIDID').val();


    if(loanloanDate == "" || amountamountpaid == "" || paypaymethod == "" )
    {

        //$('#message').html('Please Fill The Blanks'
        $('#message').fadeIn().html('<div class="alert alert-success">Fill the blanks</div>');
    }
    else
    {
        $.ajax({

            url : 'loan/loan_repayment_action.php',
            method : 'POST',
            data : {loanloanID:loanloanID, loanloanDate:loanloanDate, employeejina:employeejina, totaltotaloutstanding:totaltotaloutstanding, amountamountpaid:amountamountpaid, paypaynotes:paypaynotes, employeeIDID:employeeIDID, paypaymethod:paypaymethod},
            success : function(data)
            {
                //$('#message').html(data);
                $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
                $('#malipoModal').modal('hide');
            
           loanTable.ajax.reload();
            }
        })
    }


    })
}

});
</script>

<?php

include('includes/footer.php');
?>





