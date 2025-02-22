<?php
include('../config/function.php');
if(!isset($_SESSION["type"]))
{
  header('location:login.php');
}



include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');


?>

 <style type="text/css">
      h5,h6{
        text-align:center;
      }
        

      @media print {
          .btn-print {
            display:none !important;
          }
    
          
      }
    </style>

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
              <li class="breadcrumb-item active">Inventory Report</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
<div class="container">
<div class="right_col" role="main"> 
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">                 
                        <div class = "x-panel" >
    <?php                    
          
  $query = "
  SELECT * FROM  branch WHERE branch_id=1

  ";

 
 
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();

  foreach ($result as $row) 
  {
      
  
        
    ?>      
                  <h5><b><?php echo $row['branch_name'];?></b> </h5>  
                  <h6>Address: <?php echo $row['branch_address'];?></h6>
                  <h6>Contact #: <?php echo $row['branch_contact'];?></h6>
                  <h5><b>Product Inventory as of today, <?php echo date("M d, Y h:i a");?></b></h5>
                  <div class="mb-3">
                  <a class = "btn btn-success btn-print" href = "" onclick = "window.print()"><i class ="glyphicon glyphicon-print"></i> Print</a>
                 <a class = "btn btn-primary btn-print" href = "home.php"><i class ="glyphicon glyphicon-arrow-left"></i> Back to Homepage</a>   
                  </div>    
                  <table class="table table-bordered table-striped">
                    <thead>
                    
                      <tr>
                      
                        <th>Product Name</th>
                        <th>Qty Left</th>
                        
                                    <th>Price</th>
                                    <th>Total</th>
                                    
                       
                      </tr>
                    </thead>
                    <tbody>
                             <?php
                       

                               $query = "
  SELECT * FROM  product WHERE branch_id=1 ORDER BY product_name

  ";

 
 
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  $grand=0; 

  foreach ($result as $row) 
  {
     
     $total=$row['product_base_price']*$row['product_quantity'];
     $grand+=$total;
  
                            ?>
                      <tr>
                        <td><?php echo $row['product_name'];?></td>
                        <td><?php echo $row['product_quantity'];?></td>
                        
                        <td><?php echo $row['product_base_price'];?></td>
                        <td><?php echo number_format($total,2);?></td>
                        
                       
                      </tr>

<?php }}?>                     
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="3">Total</th>
                        
                        
                        <th colspan="2">P<?php echo number_format($grand,2);?></th>
                        
                        
                      </tr>                   
                    </tfoot>
                  </table>
                </div>
                        </div>
                </div>
            </div>
        </div>      
        <!-- /page content -->

  <!-- footer content -->
        <footer>
          <div class="pull-right">
            Sales and Inventory System <a href="#"></a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

</div>
  </div>





<script>
$(document).ready(function(){






});
</script>

<?php

include('includes/footer.php');
?>





