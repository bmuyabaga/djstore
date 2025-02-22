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
               
                <!--<button type="button" name="add" id="add_button" data-toggle="modal" data-target="#userModal" class="btn btn-primary btn-xs float-right">Add</button>-->
              </div>
              <!-- /.card-header -->
            <div class="card-body">
  <table id="order_data" class="table table-bordered table-striped">
                    <thead>
              <tr>
                <th>Purchase ID</th>
                <th>Supplier Name</th>
                <th>Total Amount</th>
                  <th>Pay</th>
                  <th>Balance</th>
                <th>Payment Status</th>
                <th> Status</th>
                <th>Purchase Date</th>
                <?php
                if($_SESSION['type'] == 'master')
                {
                  echo '<th>Created By</th>';
                }
                ?>
                <th></th>
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
              <div id="purchaseModal" class="modal fade">

      <div class="modal-dialog">
        <form method="post" id="order_form" name="autoSumForm">
          <div class="modal-content">
            <div class="modal-header bg-info" >
             
            <h4 class="modal-title" style="color: white;">Add Payment</h4>
             <button type="button" class="close" data-dismiss="modal" style="color: white;">&times;</button>
            </div>
            <div class="modal-body">
              <p id="message" class="text-dark"></p>
             

         <div class="form-group">
            <label>Invoice</label>
              <select name="PurchaseIDD" id="PurchaseIDD" class="form-control" />
                <option value=""></option>
                 <input type="hidden" name="totalamount" id="totalamount"  class="form-control amount" onFocus="startCalcate();" onBlur="stopCalcate();"  tabindex="8"  />
                 <input type="hidden" name="vendorID" id="vendorID"  class="form-control " />
               
              </select>
            </div>

             <div class="form-group">
              <label>Received On</label>
              <input type="date" name="Receiveddate" id="Receiveddate" class="form-control" />
            </div>


            <div class="form-group">
            <label>Select Payment Method</label>
              <select name="paymentMethod1" id="paymentMethod1" class="form-control" />
                <option value="cash">Cash</option>
                <option value="transfer">Bank</option>
                <option value="tigo_pesa">Tigo Pesa</option>
              </select>
            </div>
           
            <div class="form-group">
              <label>Amount Paid</label>
              <input type="text" name="paidvalue" id="paidvalue" value="0" class="form-control" tabindex="9"  onFocus="startCalcate();" onBlur="stopCalcate();" value="" />
             
             
            </div>
            
            <div class="form-group">
              <label>Balance</label>
              <input type="text" name="remainder" id="remainder" class="form-control" value="" disabled/>
              
            </div>
            <div class="form-group">
              <label>Notes</label>
              <textarea type="text" name="paymentNotes1" id="paymentNotes1" class="form-control"  ></textarea>
            </div>
            </div>
            <div class="modal-footer">
              <input type="hidden" name="PurchID" id="PurchID" />
              <input type="hidden" name="VendorIDD" id="VendorIDD" />
              <!--<input type="hidden" name="btn_action" id="btn_action" />-->
              <!--<input type="submit" name="action" id="action" class="btn btn-info" value="" />-->
              
             
                    <button class="btn btn-info" id="addpay" name="addpay" type="submit" >
                       Add
                      </button>
            
            </div>
          </div>
        </form>
      </div>

    </div>




      <!-- ADD STOCK MODAL -->

    <div id="stockModal" class="modal fade">

      <div class="modal-dialog">
        <form  id="stock_form" method="post">
          <div class="modal-content">
            <div class="modal-header bg-info">
              <h4 class="modal-title" style="color: white;">Add Stock</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
          
            </div>
            <div class="modal-body">
            
              <div class="row">

            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Purchase Date</label>
                                    <input type="date" name="pdate" id="pdate" class="form-control" value="" readonly  />
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Purchase ID</label>
                                    <input type="text" name="ppid" id="ppid" class="form-control" value="" readonly />
                                </div>
                                </div>

                            
    <div class="col-md-12">
                <div class="form-group">
                  <label>Total Purchase Value</label>
                  <input type="text" name="tvalue" id="tvalue" class="form-control" value="" readonly />
                </div>
              </div>
            

              <div class="col-md-12">
                <div class="form-group">
                <label>Product Name</label>

                                <select class="form-control select3" style="width: 100%;" name="pname" id="pname"  required>

                          <?php echo fill_product_list2($connect); ?>

                     >

                
                </select>

                
                </div>
              </div>
              
            </div>

            <div class="form-group">
              <label>Produced Qty</label>
              <input type="number" name="pqty" id="pqty" class="form-control" required />
              

            </div>
             
            
            </div>
            <div class="modal-footer">
              <input type="hidden" name="purchase_id" id="purchase_id" />
              <input type="hidden" name="btn_action" id="btn_action" />
              <!--<input type="submit" name="action" id="action" class="btn btn-info" onclick="AddCategory()"  value="Add" />-->
              <button type="submit" name="addstockdata" id="addstockdata" class="btn btn-info">Add</button>
              
              
            </div>
          </div>
        </form>
      </div>

    </div>

<script type="text/javascript">

  

    $(document).ready(function(){
      getProductcodeStocking();
      insert_stock2();
      add_Purchase_payment();

     //Initialize Select2 Elements
    $('.select3').select2({
      theme: 'bootstrap4'
    });

      var orderdataTable = $('#order_data').DataTable({
      "processing":true,
      "serverSide":true,
      "order":[],
      "ajax":{
        url:"purchase/purchase_fetch.php",
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
          "targets":[ 8, 9, 10,11,12],
          "orderable":false,
        },
      ],
      <?php
      }
      ?>
      "pageLength": 10
    });

   function getProductcodeStocking()
  {
     $("#product_code").keyup(function(e){
     
      $.ajax({
          type: "POST",
          url: 'product/get_productStocking.php',
          dataType: "JSON",
          data: {procode:$("#product_code").val() },

          success:function(data)
          {
            
          $("#product_name").val(data.product_name);
           $("#product_id").val(data.product_id);
           //current_stock = Number(data.product_quantity);
           $("#qty").focus();      

          },

          error:function()
          {


          }


      });



     });

  }



    $(document).on('click', '.payment', function(){
      var purchase_id = $(this).attr("id");
      var btn_action = 'fetch_single';
   
     
      $.ajax({
        url:"payments/fetch_purchase_payment.php",
        method:"POST",
        data:{purchase_id:purchase_id, btn_action:btn_action},
        dataType:"json",
        success:function(data)
        {
          $('#purchaseModal').modal('show');
             $('#PurchaseIDD').html(data.purchaseID);
             $('#totalamount').val(data.balance);
             $('#vendorID').val(data.vendor_id);
             $('#PurchID').val(data.purchase_id);
          // $('#invoiceno').html(data.sales_id);
          // $('#payment_status').val(data.payment_status);
           $('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Add Payment");
           //$('#clientID').val(data.client_id);
        //$('#action').val('Edit');
          //$('#btn_action').val('Edit');
         
        }
      })
    });


    $(document).on('click', '.addstock', function(){
      var purchase_id = $(this).attr("id");
      var btn_action = 'fetch_single';
      console.log(purchase_id);
      //var stock_date = $("#stockin_date").val();
      //var product_code = $("#product_code").val();
     // var product_name = $("#product_name").val();
     // var qty = $("#qty").val();
      //var btn_action = 'fetch_single';

        $.ajax({
        url:"stocking/stock_action.php",
        method:"POST",
        data:{purchase_id:purchase_id, btn_action:btn_action},
        dataType:"json",
        success:function(data)
        {
                    
          $('#stockModal').modal('show');
          $('#pdate').val(data.date);
          $('#tvalue').val(data.grandtotal);
          $('.modal-title').html("<i class='fa fa-pencil-square-o'></i>  Add Stock");
          $('#ppid').val(purchase_id);
          $('#action').val('Add');
          $('#btn_action').val('Add');
          orderdataTable.ajax.reload();
        }
      })
   
    });


function insert_stock2(){

  $(document).on('click','#addstockdata', function(){
     
      var pdate = $('#pdate').val();
      var ppid = $('#ppid').val();
      var tvalue = $('#tvalue').val();
      var pname = $('#pname').val();
      
     var pqty = $('#pqty').val();

    if(pqty == "")
    {

      //$('#message').html('Please Fill The Blanks'
      $('#message').fadeIn().html('<div class="alert alert-success">Fill the blanks</div>');
    }
    else
    {
      $.ajax({

        url : 'stocking/add_stock.php',
        method : 'POST',
        data : {pdate:pdate, ppid:ppid, tvalue:tvalue, pname:pname, pqty:pqty},
        success : function(data)
        {
          //$('#message').html(data);
          $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
          $('#stockModal').modal('show');
          orderdataTable.ajax.reload();
        }
      })
    }


  })
}




function add_Purchase_payment(){

  $(document).on('click','#addpay', function(){
     
      var Receiveddate = $('#Receiveddate').val();
      var paymentMethod1 = $('#paymentMethod1').val();
      var paidvalue = $('#paidvalue').val();
      var totalamount = $('#totalamount').val();
      var vendorID = $('#vendorID').val();
     var PurchaseIDD = $('#PurchaseIDD').val();
     var paymentNotes1 = $('#paymentNotes1').val();
     var remainder = $('#remainder').val();

    if(Receiveddate == "" || paymentMethod1 == "" || paidvalue == "")
    {

      //$('#message').html('Please Fill The Blanks'
      $('#message').fadeIn().html('<div class="alert alert-success">Fill the blanks</div>');
    }
    else
    {
      $.ajax({

        url : 'payments/purchase_payment.php',
        method : 'POST',
        data : {Receiveddate:Receiveddate, paymentMethod1:paymentMethod1, paidvalue:paidvalue, remainder:remainder,PurchaseIDD:PurchaseIDD,vendorID:vendorID,totalamount:totalamount,paymentNotes1:paymentNotes1},
        success : function(data)
        {
          //$('#message').html(data);
          $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
          $('#purchaseModal').modal('show');
          orderdataTable.ajax.reload();
        }
      })
    }


  })
}



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






    // $(document).on('click', '.pay', function(){
    //  var purchasePay_id = $(this).attr("id");
      
    
    //  var btn_action1 = 'fetch_single1';
    //  $.ajax({
    //    url:"stockin_action.php",
    //    method:"POST",
    //    data:{purchasePay_id:purchasePay_id, btn_action1:btn_action1},
    //    dataType:"json",
    //    success:function(data)
    //    {
    //      console.log(purchasePay_id);
                    
    //      $('#paymentModal').modal('show');
    //      $('#ppurchase_id').val(data.sales_id);
    //      $('#vendor_name').val(data.vendor_name);
    //      $('#totalOutstanding').val(data.balance);
    //      $('.modal-title').html("<i class='fa fa-pencil-square-o'></i>  Add Stock");
    //      $('#vendorId').val(purchase_id);
    //      $('#paybtn').val('Add');
    //      $('#btn_Action').val('Add');
    //    }
    //  })
    // });




 

    });



$(function(){
  $("#totalamount, #paidvalue").on("keydown keyup click", paidvalue);

  function paidvalue()
  {

    var sum = (Number($('#totalamount').val()) - Number($('#paidvalue').val()));

    $("#remainder").val(sum);

  }





  });
</script>




<?php

include('includes/footer.php');
?>





