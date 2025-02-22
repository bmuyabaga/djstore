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
              <li class="breadcrumb-item active">Debtors List</li>
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
                <h3 class="card-title">Debtors List</h3>
               
                <button type="button" name="add" id="add_input" data-toggle="modal" data-target="#inputModal" class="btn btn-primary btn-xs float-right">Add</button>          
               
              </div>
              <!-- /.card-header -->
            <div class="card-body">
 
 <table id="creditor_data" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer name</th>
                                <th>Total Outstanding</th>
                                <th>Invoices</th>
                            
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
              <div id="debtorModal" class="modal fade">

      <div class="modal-dialog">
        <form method="post" id="debtor_form" method="post" name="autoSumForm">
          <div class="modal-content">
            <div class="modal-header bg-info" >
             
            <h4 class="modal-title" style="color: white;">Add Payment</h4>
             <button type="button" class="close" data-dismiss="modal" style="color: white;">&times;</button>
            </div>
            <div class="modal-body">
              <p id="message" class="text-dark"></p>
             

      <div class="form-group">
            <label>Invoice</label>
              <select name="invoicenodebtor" id="invoicenodebtor" class="form-control" />
                <option value="" selected disabled></option>
              
                 <input type="hidden" name="totalOutstandingdebtor" id="totalOutstandingdebtor"  class="form-control amount" onFocus="startCalcate();" onBlur="stopCalcate();"  tabindex="8"  />
                 <input type="hidden" name="customeriddebtor" id="customeriddebtor"  class="form-control " />
               
              </select>
            </div>

             <div class="form-group">
              <label>Received On</label>
              <input type="date" name="Receiveddebtor" id="Receiveddebtor" class="form-control" required/>
            </div>

            <!--<div class="form-group">
                  <label>Date:</label>
                    <div class="input-group date" id="reservationdatedebtor" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate"/ required>
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>-->


            <div class="form-group">
            <label>Select Payment Method</label>
              <select name="paymentMethoddebtor" id="paymentMethoddebtor" class="form-control"  required/>
                <option value="cash">Cash</option>
                <option value="transfer">Bank</option>
                <option value="tigo_pesa">Tigo Pesa</option>
              </select>
            </div>
           
            <div class="form-group">
              <label>Amount Paid</label>
              <input type="text" name="amountPaiddebtor" id="amountPaiddebtor" value="0" class="form-control" tabindex="9"  onFocus="startCalcate();" onBlur="stopCalcate();" value="" required/>
             
             
            </div>
            
            <!--<div class="form-group">
              <label>Balance</label>
              <input type="text" name="balancedebtor" id="balancedebtor" class="form-control" value="" disabled/>
              
            </div>-->
            <div class="form-group">
              <label>Notes</label>
              <textarea type="text" name="paymentNotesdebtor" id="paymentNotesdebtor" class="form-control"  ></textarea>
            </div>
            </div>
            <div class="modal-footer">
              <input type="hidden" name="salesIDdebtor" id="salesIDdebtor" />
              <input type="hidden" name="clientIDdebtor" id="clientIDdebtor" />
              <input type="hidden" name="btn_action" id="btn_action" />
              <!--<input type="submit" name="action" id="action" class="btn btn-info" value="" />-->
              
             
                    <button type="submit" name="addpaydebtor" id="addpaydebtor" class="btn btn-info">Add</button>
            
            </div>
          </div>
        </form>
      </div>

    </div>
    



<script>
$(document).ready(function(){

addPaymentFromDebtors();

    var clientdataTable = $('#creditor_data').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
            url:"debtors/debtor_fetch.php",
            type:"POST"
        },
        "columnDefs":[
            {
                "targets":[3],
                "orderable":false,
            },
        ],
        "pageLength": 10
    });



        $(document).on('click', '.enter', function(){
        var client_id = $(this).attr("id");
        var btn_action = 'fetch_single';
        //console.log(client_id);
            $.ajax({
            url:"debtors/debtor_action.php",
            method:"POST",
            data:{client_id:client_id, btn_action:btn_action},
            dataType:"json",
      success:function(data)
        {
          console.log(data.balance);
          $('#debtorModal').modal('show');
          $('#salesIddebtor').val(data.sales_id);
          $('#clientNamedebtor').val(data.client_name);
          $('#customeriddebtor').val(data.client_id);
          $('#totalOutstandingdebtor').val(data.balance);
          $('#invoicenodebtor').html(data.deni);
          $('#payment_statusdebtor').val(data.payment_status);
          $('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Add Payment");
          $('#clientIDdebtor').val(data.client_id);
          $('#action').val('Edit');
          $('#btn_action').val('Edit');
        }
    })

  });



 function addPaymentFromDebtors(){

  $(document).on('click','#addpaydebtor', function(){
     
      var invoicenodebtor = $('#invoicenodebtor').val();
      var customeriddebtor = $('#customeriddebtor').val();
      var Receiveddebtor = $('#Receiveddebtor').val();
      var paymentMethoddebtor = $('#paymentMethoddebtor').val();
      var amountPaiddebtor = $('#amountPaiddebtor').val();
     var paymentNotesdebtor = $('#paymentNotesdebtor').val();
     var salesIDdebtor = $('#salesIDdebtor').val();
     //var remainder = $('#remainder').val();

    if(Receiveddebtor == "" || paymentMethoddebtor == "" || amountPaiddebtor == "")
    {

      //$('#message').html('Please Fill The Blanks'
      $('#message').fadeIn().html('<div class="alert alert-success">Fill the blanks</div>');
    }
    else
    {
      $.ajax({

        url : 'payments/add_payment_from_debtor.php',
        method : 'POST',
        data : {invoicenodebtor:invoicenodebtor, customeriddebtor:customeriddebtor, Receiveddebtor:Receiveddebtor, 
          paymentMethoddebtor:paymentMethoddebtor,amountPaiddebtor:amountPaiddebtor,paymentNotesdebtor:paymentNotesdebtor,salesIDdebtor:salesIDdebtor},
        success : function(data)
        {
          //$('#message').html(data);
          $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
          $('#debtorModal').modal('show');
          creditor_data.ajax.reload();
        }
      })
    }


  })
}



});




  // $(function(){
  // $("#totalOutstanding, #amountPaid").on("keydown keyup click", amountPaid);

  // function amountPaid()
  // {

  //   var sum = (Number($('#totalOutstanding').val()) - Number($('#amountPaid').val()));

  //   $("#balance").val(sum);

  // }





  // });

    $(function(){
  $("#invoicenodebtor").change(function(){
    var displayinvoice = $("#invoicenodebtor option:selected").val();


    $("#salesIDdebtor").val(displayinvoice);

    var salesId = $("#salesIDdebtor").val()
    console.log(salesId);
    $.ajax({
        url:"debtors/show_deni.php",
            method:"POST",
            data:{salesId:salesId},
            dataType:"json",
            success:function(data)
            {
              $("balancedebtor").val(data.balance);
            }
    })

  });







  });
</script>


<?php

include('includes/footer.php');
?>





