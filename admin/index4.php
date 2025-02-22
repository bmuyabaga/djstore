<?php
include('../config/function.php');
if(!isset($_SESSION['type']))
{
  header("location:../login.php");
}
if($_SESSION['type'] != 'master')
{
  header('location:../index.php');
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
              <li class="breadcrumb-item active">Bank</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

      <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">NMB</span>
                <span class="info-box-number">
                  <?php echo count_total_nmb_value($connect) ?>
                  
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">CRDB</span>
                <span class="info-box-number"><?php echo count_total_crdb_value($connect) ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-thumbs-up"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Deposit</span>
                <span class="info-box-number"><?php //echo count_total_sales_value($connect);  ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Withdraw</span>
                <span class="info-box-number"></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->


 <div class="col-md-12">
            <!-- Info Boxes Style 2 -->
          <div class="info-box mb-3 bg-warning">
              <span class="info-box-icon"><i class="fas fa-tag"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total NMB Deposit</span>
                <span class="info-box-number"><?php echo count_totalnmbvalue($connect); ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-success">
              <span class="info-box-icon"><i class="far fa-heart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total NMB Withdraw</span>
                <span class="info-box-number"><?php echo count_totalnmbwithvalue($connect); ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-danger">
              <span class="info-box-icon"><i class="fas fa-cloud-download-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total CRDB Deposit</span>
                <span class="info-box-number"><?php echo count_totalcrdbvalue($connect); ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-info">
              <span class="info-box-icon"><i class="far fa-comment"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total CRDB Withdraw</span>
                <span class="info-box-number"><?php echo count_totalcrdbwithvalue($connect); ?></span>
              </div>
          </div>
          <!-- /.col -->
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->







        <div class="row">
          <div class="col-md-12">
             <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Bank List</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table id="category_data" class="table table-bordered table-striped">
                          <thead><tr>
                  <th>ID</th>
                  <th>Amount</th>
                  <th>Transaction</th>
                  <th>Bank Type</th>

                  <th>By</th>
                  <th>On</th>
                  <th>Status</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr></thead>
                        </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <a href="javascript:void(0)" name="add" id="add_button" data-toggle="modal" data-target="#nmbModal" class="btn btn-sm btn-info float-left">New bank Record</a>
                <a href="#" class="btn btn-sm btn-secondary float-right">New bank Record</a>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card --> 
        </div>
        <!-- /.row -->

       

         

           
            
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->







   <div id="nmbModal" class="modal fade">
      <div class="modal-dialog">
        <form method="post" id="nmb_form">
          <div class="modal-content">
            <div class="modal-header bg-info">
              <h4 class="modal-title"><i class="fa fa-plus"></i> Add Transaction</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            
            </div>
            <div class="modal-body">
                <span id="message"></span>
               
                                <div class="form-group">
                                    <label>Transaction</label>
                                    <select type="text" name="transact" id="transact" class="form-control" required>
                                        <option value="">Please Select Transaction</option>
                                        <option value="deposit">Deposit</option>
                                        <option value="withdraw">Withdraw</option>
                                       
                                    </select>
                           
                                 </div>

                                 <div class="form-group">
                                    <label>Bank Type</label>
                                    <select type="text" name="bank" id="bank" class="form-control" required>
                                        <option value="">Please Select Bank</option>
                                        <option value="nmb">NMB</option>
                                        <option value="crdb">CRDB</option>
                                       
                                    </select>
                           
                                 </div>

                                 <div class="form-group">
                                    <label>Enter Amount</label>
                                    <input type="number" name="amount" id="amount" class="form-control" required />
                                </div>

                                 <div class="form-group">
                                    <label>Transaction Status</label>
                                    <select type="text" name="transactStatus" id="transactStatus" class="form-control" required>
                                        <option value=""> Select Transaction Status</option>
                                        <option value="cash">Cash</option>
                                        <option value="tigo_pesa">Tigo Pesa</option>
                                        <option value="transfer">Transfer</option>
                                        <option value="cheque">Cheque</option>
                                       
                                    </select>
                           
                                 </div>
                                 
                        <div class="form-group">
              <label>Notes</label>
              <textarea type="text" name="nmbnotes" id="nmbnotes" class="form-control"  ></textarea>
            </div>

            </div>
            <div class="modal-footer">
                <input type="hidden" name="nmb_id" id="nmb_id"/>
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

  $('#add_button').click(function(){
    $('#nmb_form')[0].reset();
    $('.modal-title').html("<i class='fa fa-plus'></i> Add Deposit|Withdraw");
    $('#action').val('Add');
    $('#btn_action').val('Add');
  });

  $(document).on('submit','#nmb_form', function(event){
    event.preventDefault();
    $('#action').attr('disabled','disabled');
    var form_data = $(this).serialize();
    $.ajax({
      url:"nmb/nmb_action.php",
      method:"POST",
      data:form_data,
      success:function(data)
      {
        $('#nmb_form')[0].reset();
        $('#nmbModal').modal('hide');
        $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
        $('#action').attr('disabled', false);
        nmbTable.ajax.reload();
      }
    })
  });

  $(document).on('click', '.update', function(){
    var nmb_id = $(this).attr("id");
    var btn_action = 'fetch_single';
    $.ajax({
      url:"nmb/nmb_action.php",
      method:"POST",
      data:{nmb_id:nmb_id, btn_action:btn_action},
      dataType:"json",
      success:function(data)
      {
        $('#nmbModal').modal('show');
        $('#transact').val(data.transaction);
        $('#bank').val(data.bank_type);
        $('#amount').val(data.amount);
        $('#transactStatus').val(data.method);
        $('#nmbnotes').val(data.notes);
        $('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Transaction");
        $('#nmb_id').val(nmb_id);
        $('#action').val('Edit');
        $('#btn_action').val("Edit");
      }
    })
  });

  var nmbTable = $('#category_data').DataTable({
    "processing":true,
    "serverSide":true,
    "order":[],
    "ajax":{
      url:"nmb/nmb_fetch.php",
      type:"POST"
    },
    "columnDefs":[
      {
        "targets":[7, 8],
        "orderable":false,
      },
    ],
    "pageLength": 10
  });


    $(document).on('click', '.delete', function(){
    var nmb_id = $(this).attr('id');
    var status = $(this).data("status");
    var btn_action = 'delete';
    if(confirm("Are you sure you want to change status?"))
    {
      $.ajax({
        url:"nmb/nmb_action.php",
        method:"POST",
        data:{nmb_id:nmb_id, status:status, btn_action:btn_action},
        success:function(data)
        {
          $('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
          nmbTable.ajax.reload();
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