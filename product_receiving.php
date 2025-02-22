<?php
include('config/function.php');
if(!isset($_SESSION['type']))
{
  header("location:login.php");
}

include('includes/header.php');
include('includes/sidebar.php');

// submit form
if (isset($_GET['pid']) && isset($_GET['purchaseId'])) {
    $product_id = intval($_GET['pid']);
    $purchase_id = intval($_GET['purchaseId']);
    $sku = $_GET['sku'];
   


?>
 <main class="col-md-10 ms-sm-auto px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard Overview</h1>
                </div>
                
                <div class="container mt-4">
                <?php
    if (isset($_SESSION['success'])) {
        echo "<p style='color: green;'>" . $_SESSION['success'] . "</p>";
        unset($_SESSION['success']); // Clear the message after displaying
    }

    if (isset($_SESSION['error'])) {
        echo "<p style='color: red;'>" . $_SESSION['error'] . "</p>";
        unset($_SESSION['error']); // Clear the message after displaying
    }
    ?>
        <div class="card">
            <div class="card-header">
            <h3 class="card-title">Receive Product Batch</h3>
            </div>
            <div class="card-body">
            <form action="product_receiving_action.php" method="POST">
            <!--start of a row-->
            <div class="row">
                 <div class="col-md-6">
                 <label for="received_quantity" class="form-label">Quantity Received</label>
                 <input type="number" name="received_quantity" id="received_quantity" class="form-control" required>
                 </div>
                 <div class="col-md-6">
                 <label for="batch_number" class="form-label">Batch Number</label>
                 <input type="text" name="batch_number" id="batch_number" class="form-control" required>
                 </div>

                 <div class="col-md-6">
                 <label for="production_date" class="form-label">Production Date</label>
                 <input type="date" name="production_date" id="production_date" class="form-control" required>
                 </div>

                 <div class="col-md-6">
                 <label for="expiry_date" class="form-label">Expiry Date</label>
                 <input type="date" name="expiry_date" id="expiry_date" class="form-control" required>
                 </div>
                 </div>
                 <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" >
                 <input type="hidden" name="purchase_id" value="<?php echo $purchase_id; ?>" >
                 <input type="hidden" name="sku" value="<?php echo $sku; ?>" >
                 <button type="submit" name="add_batch" class="btn btn-success mt-3">Receive Batch</button>
                 
            </div>
            <!--end of row-->
         
            
            
        </form>
            </div><!--end of card body-->
        </div><!-- end of card-->
        
    </div>
               
 </main>
            <?php
            } else {
                echo "Invalid parameters!";
            }
             include('includes/footer.php');
              ?>