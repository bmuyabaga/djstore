<?php
include('../config/function.php');
if(!isset($_SESSION["type"]))
{
  header('location:../login.php');
}

if($_SESSION["type"] != 'master')
{
  header("location:../index.php");
}

include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
// Fetch purchases and purchase items from the database
$query = "
    SELECT p.purchase_id, p.date, pr.prouct_name, pi.qty, pi.buying_price
    FROM purchase p
    LEFT JOIN purchase_item pi ON p.purchase_id = pi.purchase_id
    LEFT JOIN product pr ON pi.product_code = pr.product_code
    ORDER BY p.purchase_date DESC
";
$stmt = $connect->prepare($query);
$stmt->execute();
$purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Close the connection
$connect = null;

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
              <li class="breadcrumb-item active">Category List</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <div class="container">
      <span id="alert_action"></span>
      <div class="row">
        <div class="col-md-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Category List</h3>
               
                 <button type="button" name="add" id="add_category" data-toggle="modal" data-target="#categoryModal" class="btn btn-success btn-xs btn-xs float-right">Add</button>  
              </div>
              <!-- /.card-header -->
                <div class="card-body">
                <table class="table table-bordered">
                        <tbody>
                            <!-- Purchase 1 -->
                            <tr class="table-primary">
                                <th colspan="5">Purchase Number: PUR-001 | Date: 2024-01-30</th>
                            </tr>
                            <tr>
                                <td>Laptop</td>
                                <td>2</td>
                                <td>$500.00</td>
                                <td>$1000.00</td>
                                <td>
                                    <button class="btn btn-success btn-sm" onclick="addStock(1, 'PUR-001', 2)">Add Stock</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Mouse</td>
                                <td>5</td>
                                <td>$20.00</td>
                                <td>$100.00</td>
                                <td>
                                    <button class="btn btn-success btn-sm" onclick="addStock(2, 'PUR-001', 5)">Add Stock</button>
                                </td>
                            </tr>

                            <!-- Purchase 2 -->
                            <tr class="table-primary">
                                <th colspan="5">Purchase Number: PUR-002 | Date: 2024-01-29</th>
                            </tr>
                            <tr>
                                <td>Keyboard</td>
                                <td>3</td>
                                <td>$30.00</td>
                                <td>$90.00</td>
                                <td>
                                    <button class="btn btn-success btn-sm" onclick="addStock(3, 'PUR-002', 3)">Add Stock</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
          </div>
           
        </div>
        
      </div>
      
    </div>




  </div>



<!--Modal ya kuingiza new category-->

    <div id="categoryModal" class="modal fade">
      <div class="modal-dialog">
        <form method="post" id="category_form">
          <div class="modal-content">
            <div class="modal-header bg-info">
                 <h4 class="modal-title"><i class="fa fa-plus"></i> Add Category</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
           
            </div>
            <div class="modal-body">
              <label>Enter Category Name</label>
            <input type="text" name="category_name" id="category_name" class="form-control" required />
            </div>
            <div class="modal-footer">
              <input type="hidden" name="category_id" id="category_id"/>
              <input type="hidden" name="btn_action" id="btn_action"/>
              <input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </form>
      </div>
    </div>





<script>

function addStock(productId, purchaseNumber, quantity) {
            let userId = 1; // Replace with the actual logged-in user ID
            let purchaseDate = new Date().toISOString().slice(0, 10); // Get today's date

            $.ajax({
                url: "stocking_action.php",
                type: "POST",
                data: {
                    product_id: productId,
                    purchase_id: purchaseNumber,
                    quantity: quantity,
                    date: purchaseDate,
                    user_id: userId
                },
                success: function(response) {
                    alert(response);
                },
                error: function(xhr, status, error) {
                    alert("Error: " + error);
                }
            });
        }

</script>

<?php

include('includes/footer.php');
?>





