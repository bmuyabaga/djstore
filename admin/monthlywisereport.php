<?php
include('../config/function.php');
if(!isset($_SESSION["type"]))
{
  header('location:login.php');
}


;
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
              <li class="breadcrumb-item active">Monthly Report</li>
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
 <table id="monthwise" class="table table-bordered table-striped">
                  <thead>


                  <tr>
                     <th>Year</th>
                    <th>Month</th>
                    <th>Total</th>
                 

                    
                  </tr>
                  </thead>
                  <tbody>
       <?php
                    



$query= " SELECT MONTHNAME(date) as monthname, YEAR(date) as year, sum(grandtotal) as amount from sales NATURAL JOIN sales_item NATURAL JOIN product NATURAL JOIN client GROUP BY MONTH(date)
 ";
$statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    foreach ($result as $row) {
        
  
    ?>
                  <tr>
                      <td><?php echo $row["year"]; ?></td>
                    <td><?php echo $row["monthname"]; ?></td>
                        <td><?php echo $row["amount"]; ?></td>
                        
                       
                   
                   
                  </tr>
      <?php } ?>
                 
                  </tfoot>
                </table>


            </div>
          </div>
          
          
        </div>
        



      </div>
      
    </div>




  </div>


   
    
    

<script type="text/javascript">
 
  
  $(function () {
    $("#monthwise").DataTable({
      "responsive": true,
      "autoWidth": false,
    });

    });
    // $('#example2').DataTable({
    //   "paging": true,
    //   "lengthChange": false,
    //   "searching": false,
    //   "ordering": true,
    //   "info": true,
    //   "autoWidth": false,
    //   "responsive": true,
    // });


 //addPaymentFromClientaccount();

        $(document).on('click', '.addpayaccount', function(){
        var sales_id = $(this).attr("id");
        var btn_action = 'fetch_single';
        var client_id = $('#clientIDD').val();

        //console.log(sales_id);
            $.ajax({
            url:"clientAccountPay_action.php",
            method:"POST",
            data:{sales_id:sales_id, btn_action:btn_action,client_id:client_id},
            dataType:"json",
      success:function(data)
        {
          //console.log(data.balance);
          $('#customeraccountModal').modal('show');
          $('#invoicenoclientaccount').html(data.sales_iddeni);
           $('#customeridclientaccount').val(data.client_id);
          // $('#customeriddebtor').val(data.client_id);
           $('#totalOutstandingclientaccount').val(data.balance);
          // $('#customeridclientaccount').html(data.deni);
          // $('#payment_statusdebtor').val(data.payment_status);
          $('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Add Payment");
          $('#clientIDdebtor').val(data.client_id);
          $('#action').val('Edit');
          $('#btn_action').val('Edit');
        }
    })

  });

</script>




<?php

include('includes/footer.php');
?>





