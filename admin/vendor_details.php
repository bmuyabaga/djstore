<?php

if($_SERVER['REQUEST_METHOD']=='GET')
{
 
  include('../config/function.php');



include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');



$last_id1 = $_GET['view']; 
   
              
  }




?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Supplier Account</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

  <?php
                                $query_client = "SELECT * FROM vendor WHERE vendor_id = $last_id1";
                                $statement1 = $connect->prepare($query_client);
                                $statement1->execute();
                                $result1 = $statement1->fetchAll();

                                  foreach ($result1 as $row1) {

                                   //echo $client_name = $row1['client_name'];
  
                                

                                ?>
            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="#"
                       alt="User profile picture">
                       <?php //echo $row1['photo'];?>
                </div>

                <h3 class="profile-username text-center"><?php echo $row1['vname'];  ?></h3>

                <p class="text-muted text-center">Software Engineer</p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Address</b> <a class="float-right"><?php echo $row1['address'];  ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Contact</b> <a class="float-right"><?php echo $row1['contactno'];  ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Balance</b> <a class="float-right">TZS.<?php //echo $row1['total_outstanding'];  ?></a>
                  </li>
                </ul>

             

                 <a href="<?php echo "purchase_invoice_create.php?vid=$last_id1";?>" target="_blank" class="btn btn-primary btn-block"><b>Create New Invoice</b></a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
<?php } ?>
            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Summary</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
               
                <strong><i class="fas fa-book mr-1"></i> Total Purchase</strong>
               <?php
               $totalpurchase='';
               $totalpayment='';
               
                  $querysum="SELECT SUM(grandtotal) as totalpurchase FROM purchase WHERE vendor_id=$last_id1 ";
                  $statement = $connect->prepare($querysum);
                  $statement->execute();
                  $result = $statement->fetchAll();
                  
                  $querypurchasePay="SELECT SUM(paid) as totalpurchasepay FROM  purchase_payment WHERE vendor_id=$last_id1 ";
                  $statementP = $connect->prepare($querypurchasePay);
                  $statementP->execute();
                  $resultP = $statementP->fetchAll();
                  
                  foreach($result as $row)
                  { $totalpurchase=$row['totalpurchase'];
                  ?>
                <p class="text-muted">
                  <h2><?php echo number_format($row['totalpurchase'],2); ?></h2>
                </p>
<?php } 

foreach($resultP as $rowP)
{ $totalpayment=$rowP['totalpurchasepay'];
?>
                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Total Payment</strong>
     
                <p class="text-muted"><h2><?php echo number_format($rowP['totalpurchasepay'],2); ?></h2></p>
<?php } ?>
                <hr>
   
                <strong><i class="fas fa-pencil-alt mr-1"></i> Total Unpaid Amount</strong>
                
                <p class="text-muted">
               <h2><?php echo number_format((($totalpurchase)-($totalpayment)),2); ?></h2>
                </p>

                <hr>

                <!--<strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>-->
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Sales History</a></li>
                  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Payment History</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Order History</a></li>
                  <li class="nav-item"><a class="nav-link" href="#purchaseItem" data-toggle="tab">Purchased Items</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    <!-- Post -->
                    <div class="post">
                    
                

                <table id="example1" class="table table-bordered table-striped">
                  <thead>


                  <tr>
                    <th>SalesID</th>
                    <th>Date</th>
                    <th>Amount Due</th>
                    <th>Amount Paid</th>
                    <th>Unpaid Amount</th>
                    
                  </tr>
                  </thead>
                  <tbody>
       <?php
                    


$query_sales= "SELECT * FROM purchase WHERE vendor_id = $last_id1  ";
$statement = $connect->prepare($query_sales);
    $statement->execute();
    $result = $statement->fetchAll();

    foreach ($result as $row) {
        # code...
  
    ?>
                  <tr>
                    <td><?php echo $row['purchase_id']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo $row['grandtotal']; ?></td>
                    <td><?php echo $row['pay']; ?></td>
                    <td><?php echo $row['balance']; ?></td>
                   
                   
                  </tr>
      <?php } ?>
                 
                  </tfoot>
                </table>
           




                      

                     
                    </div>
                    <!-- /.post -->

                    <!-- Post -->
                    <div class="post clearfix">
                      <div class="user-block">
                        
                        <span class="username">
                         
                          
                        </span>
                       
                      </div>
                      <!-- /.user-block -->
                     
                    </div>
                    <!-- /.post -->

                    <!-- Post -->
                    <div class="post">
                      <div class="user-block">
                       
                      </div>
                      <!-- /.user-block -->
                      <div class="row mb-3">
                        <div class="col-sm-6">
                          
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                          <div class="row">
                            <div class="col-sm-6">
                              
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-6">
                              
                            </div>
                            <!-- /.col -->
                          </div>
                          <!-- /.row -->
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->

                  
                     
                    </div>
                    <!-- /.post -->
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="timeline">
                    <!-- The timeline -->
                    <div class="timeline timeline-inverse">
                      <!-- timeline time label -->
                      <div class="time-label">
                        <span class="bg-danger">
                          10 Feb. 2014
                        </span>
                      </div>
                      <!-- /.timeline-label -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-envelope bg-primary"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 12:05</span>

                          <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                          <div class="timeline-body">
                          

                           <table id="example2" class="table table-bordered table-striped">
                  <thead>


                  <tr>
                    <th>PaymentID</th>
                    <th>SalesID</th>
                    <th>Amount Paid</th>
                    <th>Payment Method</th>
                    <th>Payment Date</th>

                    
                  </tr>
                  </thead>
                  <tbody>
       <?php
                    



$query_payment= "SELECT * FROM purchase_payment WHERE vendor_id = $last_id1  ";
$statement = $connect->prepare($query_payment);
    $statement->execute();
    $result = $statement->fetchAll();

    foreach ($result as $row) {
        # code...
  
    ?>
                  <tr>
                    <td><?php echo $row['payment_id']; ?></td>
                        <td><?php echo $row['purchase_id']; ?></td>
                        <td><?php echo $row['paid']; ?></td>
                        <td><?php echo $row['payment_method']; ?></td>
                        <td><?php echo $row['payment_date']; ?></td>
                       
                   
                   
                  </tr>
      <?php } ?>
                 
                  </tfoot>
                </table>
                          </div>
                          <div class="timeline-footer">
                            <a href="#" class="btn btn-primary btn-sm">Read more</a>
                            <a href="#" class="btn btn-danger btn-sm">Delete</a>
                          </div>
                        </div>
                      </div>
                      <!-- END timeline item -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-user bg-info"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>

                          <h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted your friend request
                          </h3>
                        </div>
                      </div>
                      <!-- END timeline item -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-comments bg-warning"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>

                          <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                          <div class="timeline-body">
                            Take me to your leader!
                            Switzerland is small and neutral!
                            We are more like Germany, ambitious and misunderstood!
                          </div>
                          <div class="timeline-footer">
                            <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                          </div>
                        </div>
                      </div>
                      <!-- END timeline item -->
                      <!-- timeline time label -->
                      <div class="time-label">
                        <span class="bg-success">
                          3 Jan. 2014
                        </span>
                      </div>
                      <!-- /.timeline-label -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-camera bg-purple"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 2 days ago</span>

                          <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                          <div class="timeline-body">
                            <img src="http://placehold.it/150x100" alt="...">
                            <img src="http://placehold.it/150x100" alt="...">
                            <img src="http://placehold.it/150x100" alt="...">
                            <img src="http://placehold.it/150x100" alt="...">
                          </div>
                        </div>
                      </div>
                      <!-- END timeline item -->
                      <div>
                        <i class="far fa-clock bg-gray"></i>
                      </div>
                    </div>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="settings">


                           <table id="example3" class="table table-bordered table-striped">
                  <thead>


                  <tr>
                    <th>PaymentID</th>
                    <th>SalesID</th>
                    <th>Amount Paid</th>
                    <th>Payment Method</th>
                    <th>Payment Date</th>
                    
                    
                  </tr>
                  </thead>
                  <tbody>
       <?php
                    



$query_payment= "SELECT * FROM payments WHERE client_id = $last_id1  ";
$statement = $connect->prepare($query_payment);
    $statement->execute();
    $result = $statement->fetchAll();

    foreach ($result as $row) {
        # code...
  
    ?>
                  <tr>
                    <td><?php echo $row['payment_id']; ?></td>
                        <td><?php echo $row['sales_id']; ?></td>
                        <td><?php echo $row['paid']; ?></td>
                        <td><?php echo $row['payment_method']; ?></td>
                        <td><?php echo $row['payment_date']; ?></td>
                       
                   
                   
                  </tr>
      <?php } ?>
                 
                  </tfoot>
                </table>
                 
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->







<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });

     $("#example2").DataTable({
      "responsive": true,
      "autoWidth": false,
    });

        $("#example3").DataTable({
      "responsive": true,
      "autoWidth": false,
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
  });
</script>

<?php

include('includes/footer.php');
?>





