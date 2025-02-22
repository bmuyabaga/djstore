<?php
include('../config/function.php');
if(!isset($_SESSION["type"]))
{
    header('location:../login.php');
}




include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');

if (!isset($_GET['batch_id']) || empty($_GET['batch_id'])) {
    echo "Invalid Batch ID.";
    exit;
}

$batch_id = $_GET['batch_id'];
$query = "SELECT p.product_name, c.category_name, p.product_base_price, p.product_quantity, 
                 pb.batch_number, pb.stock, pb.production_date, pb.expiry_date 
          FROM product_batches pb 
          JOIN product p ON pb.product_id = p.product_id 
          JOIN category c ON p.category_id = c.category_id
          WHERE pb.product_batches_id = :batch_id";
$statement = $connect->prepare($query);
$statement->bindParam(':batch_id', $batch_id, PDO::PARAM_INT);
$statement->execute();
$batch = $statement->fetch(PDO::FETCH_ASSOC);

if (!$batch) {
    echo "Batch not found.";
    exit;
}


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
              <li class="breadcrumb-item"><a href="#">Nyumbani</a></li>
              <li class="breadcrumb-item active">Batch Details</li>
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
                <h3 class="card-title">Batch Details</h3>
               
                <button type="button" name="add" id="add_product"  class="btn btn-primary btn-xs float-right">Ongeza</button>
              </div>
              <!-- /.card-header -->
            <div class="card-body">
                   <!--product table start--> 
                   <table class="table table-bordered">
                        <tr><th>Product Name</th><td><?= $batch['product_name'] ?></td></tr>
                        <tr><th>Category</th><td><?= $batch['category_name'] ?></td></tr>
                        <tr><th>Base Price</th><td><?= $batch['product_base_price'] ?></td></tr>
                        <tr><th>Total Stock</th><td><?= $batch['product_quantity'] ?></td></tr>
                        <tr><th>Batch Number</th><td><?= $batch['batch_number'] ?></td></tr>
                        <tr><th>Batch Stock</th><td><?= $batch['stock'] ?></td></tr>
                        <tr><th>Production Date</th><td><?= $batch['production_date'] ?></td></tr>
                        <tr><th>Expiry Date</th><td><?= $batch['expiry_date'] ?></td></tr>
                 </table>
                  <a href="product.php" class="btn btn-secondary">Back to Products</a>
                   <!--product table end-->
            </div>
          </div>
          
          
        </div>
        
      </div>
      
    </div>




  </div>




<?php

include('includes/footer.php');
?>





