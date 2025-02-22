<?php

include('../config/function.php');


if(!isset($_SESSION["type"]))
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

// Prepare and execute the query
$query = $connect->query("SELECT SUM(grandtotal) AS total_sales FROM sales");
$sales = $query->fetch(PDO::FETCH_ASSOC);

// Get total sales value
$total_sales = isset($sales['total_sales']) ? $sales['total_sales'] : 0;

$expenses =$connect->query("SELECT SUM(expense_total_cost) AS total_expenses FROM expense");
$exp = $expenses->fetch(PDO::FETCH_ASSOC);
$total_expenses = isset($exp['total_expenses']) ? $exp['total_expenses'] : 0;
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
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

     <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
         <!--Sales Overview start-->
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                 <h3 class="card-title">Sales Overview</h3>
              </div>
              <div class="card-body">
                 <div class="row">
                     <!---row start--> 
                      <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                          <div class="inner">
                            <h3><?php echo count_total_user($connect); ?></h3>

                            <p>Total Users</p>
                          </div>
                          <div class="icon">
                            <i class="ion ion-bag"></i>
                          </div>
                          <a href="user.php" class="small-box-footer">Go <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                      <!-- small box -->
                      <div class="small-box bg-success">
                        <div class="inner">
                          <h3><?php echo count_total_category($connect); ?></h3>

                          <p>Total Categories</p>
                        </div>
                        <div class="icon">
                          <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="user.php" class="small-box-footer">Go <i class="fas fa-arrow-circle-right"></i></a>
                      </div>
                    </div>
                    <div class="col-lg-3 col-6">
                      <!-- small box -->
                      <div class="small-box bg-warning">
                        <div class="inner">
                          <h3><?php echo count_total_brand($connect); ?></h3>

                          <p>Total Brands</p>
                        </div>
                        <div class="icon">
                          <i class="ion ion-person-add"></i>
                        </div>
                        <a href="user.php" class="small-box-footer">Go <i class="fas fa-arrow-circle-right"></i></a>
                      </div>
                    </div>
                    <div class="col-lg-3 col-6">
                      <!-- small box -->
                      <div class="small-box bg-danger">
                        <div class="inner">
                          <h3><?php echo count_total_product($connect); ?></h3>

                          <p>Total Products</p>
                        </div>
                        <div class="icon">
                          <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="user.php" class="small-box-footer">Go <i class="fas fa-arrow-circle-right"></i></a>
                      </div>
                   </div>
                   <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                          <div class="inner">
                            <h3><?php echo count_total_user($connect); ?></h3>

                            <p>Total Sales</p>
                          </div>
                          <div class="icon">
                            <i class="ion ion-bag"></i>
                          </div>
                          <a href="user.php" class="small-box-footer">Go <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                      <!-- small box -->
                      <div class="small-box bg-warning">
                        <div class="inner">
                          <h3><?php echo count_total_brand($connect); ?></h3>

                          <p>Total Purchases</p>
                        </div>
                        <div class="icon">
                          <i class="ion ion-person-add"></i>
                        </div>
                        <a href="user.php" class="small-box-footer">Go <i class="fas fa-arrow-circle-right"></i></a>
                      </div>
                    </div>
                    <div class="col-lg-3 col-6">
                      <!-- small box -->
                      <div class="small-box bg-success">
                        <div class="inner">
                          <h3><?php echo count_total_category($connect); ?></h3>

                          <p>Purchased But Not Posted</p>
                        </div>
                        <div class="icon">
                          <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="unreceived_purchases.php" class="small-box-footer">Go <i class="fas fa-arrow-circle-right"></i></a>
                      </div>
                    </div>
                    <div class="col-lg-3 col-6">
                      <!-- small box -->
                      <div class="small-box bg-info">
                        <div class="inner">
                          <h3><?php echo count_total_product($connect); ?></h3>

                          <p>Total Products</p>
                        </div>
                        <div class="icon">
                          <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="user.php" class="small-box-footer">Go <i class="fas fa-arrow-circle-right"></i></a>
                      </div>
                   </div>
                     <!--row end-->
                 </div>
            </div>
          </div>
         <!--Sales Overview end-->
         <!---Revenue start-->
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                 <h3 class="card-title">Revenue Overview</h3>
              </div>
              <div class="card-body">
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                      <h5 class="description-header">TZS <?= daily_sales($connect) ?></h5>
                      <span class="description-text">DAILY SALES</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                      <h5 class="description-header">TZS <?= weekly_sales($connect) ?></h5>
                      <span class="description-text">WEEKLY SALES</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                      <h5 class="description-header">TZS <?= monthly_sales($connect) ?></h5>
                      <span class="description-text">MONTHLY SALES</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block">
                      <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                      <h5 class="description-header">TZS <?= yearly_sales($connect) ?></h5>
                      <span class="description-text">YEARLY SALES</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                </div>
                <!-- /.row -->
              </div>
              <!-- /.card-footer -->
            </div>
          </div>
         <!----Revenue end-->
         <!--net profit start--> 
                <!-- Total Sales -->
          <div class="row">
            <div class="col-md-4">
                <div class="card bg-success text-white p-3">
                    <h5>Total Sales</h5>
                    <h3>TZS<?php echo number_format($total_sales); ?></h3>
                </div>
            </div>

            <!-- Total Expenses -->
            <div class="col-md-4">
                <div class="card bg-danger text-white p-3">
                    <h5>Total Expenses</h5>
                    <h3>TZS<?php echo number_format($total_expenses); ?></h3>
                </div>
            </div>

            <!-- Net Profit -->
            <div class="col-md-4">
                <div class="card bg-primary text-white p-3">
                    <h5>Net Profit</h5>
                    <h3>TZS<?php echo number_format($total_sales - $total_expenses); ?></h3>
                </div>
            </div>
        </div>
</div>
         <!--net profit end-->
         <!---Total sales stat start-->
           <div class="col-md-12">
            
              
                 <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Sales Trend</h3>
                  </div>
                  <div class="card-body">
                    <canvas id="salesChart1" width="200" height="50"></canvas>
                  </div>
                </div>
          </div>   
         <!----Total sales stat end-->
         <a href="cogs_report.php?start_date=2025-01-01&end_date=2025-02-31" class="btn btn-primary">Download COGS Report</a>
         <a href="sales_report.php?start_date=2024-01-01&end_date=2024-03-31" class="btn btn-primary">Download Sales Report</a>
         <a href="profit_report.php?start_date=2024-01-01&end_date=2024-03-31" class="btn btn-primary">Download Profit Report</a>
         <a href="inventory_report.php?start_date=2024-01-01&end_date=2024-03-31" class="btn btn-primary">Download Inventory Report</a>
      <!--- latest orders start-->
      <div class="col-md-12">
         <div class="row">
         <div class="col-md-8">
                  <!-- TABLE: LATEST ORDERS -->
                  <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Latest Orders</h3>

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
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>Order ID</th>
                      <th>Item</th>
                      <th>Status</th>
                      <th>Popularity</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                      <td><a href="pages/examples/invoice.html">OR9842</a></td>
                      <td>Call of Duty IV</td>
                      <td><span class="badge badge-success">Shipped</span></td>
                      <td>
                        <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div>
                      </td>
                    </tr>
                    <tr>
                      <td><a href="pages/examples/invoice.html">OR1848</a></td>
                      <td>Samsung Smart TV</td>
                      <td><span class="badge badge-warning">Pending</span></td>
                      <td>
                        <div class="sparkbar" data-color="#f39c12" data-height="20">90,80,-90,70,61,-83,68</div>
                      </td>
                    </tr>
                    <tr>
                      <td><a href="pages/examples/invoice.html">OR7429</a></td>
                      <td>iPhone 6 Plus</td>
                      <td><span class="badge badge-danger">Delivered</span></td>
                      <td>
                        <div class="sparkbar" data-color="#f56954" data-height="20">90,-80,90,70,-61,83,63</div>
                      </td>
                    </tr>
                    <tr>
                      <td><a href="pages/examples/invoice.html">OR7429</a></td>
                      <td>Samsung Smart TV</td>
                      <td><span class="badge badge-info">Processing</span></td>
                      <td>
                        <div class="sparkbar" data-color="#00c0ef" data-height="20">90,80,-90,70,-61,83,63</div>
                      </td>
                    </tr>
                    <tr>
                      <td><a href="pages/examples/invoice.html">OR1848</a></td>
                      <td>Samsung Smart TV</td>
                      <td><span class="badge badge-warning">Pending</span></td>
                      <td>
                        <div class="sparkbar" data-color="#f39c12" data-height="20">90,80,-90,70,61,-83,68</div>
                      </td>
                    </tr>
                    <tr>
                      <td><a href="pages/examples/invoice.html">OR7429</a></td>
                      <td>iPhone 6 Plus</td>
                      <td><span class="badge badge-danger">Delivered</span></td>
                      <td>
                        <div class="sparkbar" data-color="#f56954" data-height="20">90,-80,90,70,-61,83,63</div>
                      </td>
                    </tr>
                    <tr>
                      <td><a href="pages/examples/invoice.html">OR9842</a></td>
                      <td>Call of Duty IV</td>
                      <td><span class="badge badge-success">Shipped</span></td>
                      <td>
                        <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div>
                      </td>
                    </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a>
                <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
      </div> 
       <div class="col-md-4">
            <!-- PRODUCT LIST -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Recently Added Products</h3>

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
                <ul class="products-list product-list-in-card pl-2 pr-2">
                  <li class="item">
                    <div class="product-img">
                      <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                    </div>
                    <div class="product-info">
                      <a href="javascript:void(0)" class="product-title">Samsung TV
                        <span class="badge badge-warning float-right">$1800</span></a>
                      <span class="product-description">
                        Samsung 32" 1080p 60Hz LED Smart HDTV.
                      </span>
                    </div>
                  </li>
                  <!-- /.item -->
                  <li class="item">
                    <div class="product-img">
                      <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                    </div>
                    <div class="product-info">
                      <a href="javascript:void(0)" class="product-title">Bicycle
                        <span class="badge badge-info float-right">$700</span></a>
                      <span class="product-description">
                        26" Mongoose Dolomite Men's 7-speed, Navy Blue.
                      </span>
                    </div>
                  </li>
                  <!-- /.item -->
                  <li class="item">
                    <div class="product-img">
                      <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                    </div>
                    <div class="product-info">
                      <a href="javascript:void(0)" class="product-title">
                        Xbox One <span class="badge badge-danger float-right">
                        $350
                      </span>
                      </a>
                      <span class="product-description">
                        Xbox One Console Bundle with Halo Master Chief Collection.
                      </span>
                    </div>
                  </li>
                  <!-- /.item -->
                  <li class="item">
                    <div class="product-img">
                      <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                    </div>
                    <div class="product-info">
                      <a href="javascript:void(0)" class="product-title">PlayStation 4
                        <span class="badge badge-success float-right">$399</span></a>
                      <span class="product-description">
                        PlayStation 4 500GB Console (PS4)
                      </span>
                    </div>
                  </li>
                  <!-- /.item -->
                </ul>
              </div>
              <!-- /.card-body -->
              <div class="card-footer text-center">
                <a href="javascript:void(0)" class="uppercase">View All Products</a>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
       </div>
         </div> <!--row end-->
      </div>
    
    <!----latest orders end-->
    <!--Anually product stats start--> 
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Product Sales Trend: <?= date('Y') ?></h3>
          </div>
          <div class="card-body">
          <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>SKU</th>
                <th>Item</th>
                <th>Jan</th>
                <th>Feb</th>
                <th>Mar</th>
                <th>Apr</th>
                <th>May</th>
                <th>Jun</th>
                <th>Jul</th>
                <th>Aug</th>
                <th>Sept</th>
                <th>Oct</th>
                <th>Nov</th>
                <th>Dec</th>
            </tr>
        </thead>
        <tbody>
      <?php
        // SQL query (pivot query)
$sql = "
    SELECT 
        p.product_code, 
        p.product_name,
        IFNULL(SUM(CASE WHEN MONTH(s.date) = 1 THEN si.qty END), 0) AS January,
        IFNULL(SUM(CASE WHEN MONTH(s.date) = 2 THEN si.qty END), 0) AS February,
        IFNULL(SUM(CASE WHEN MONTH(s.date) = 3 THEN si.qty END), 0) AS March,
        IFNULL(SUM(CASE WHEN MONTH(s.date) = 4 THEN si.qty END), 0) AS April,
        IFNULL(SUM(CASE WHEN MONTH(s.date) = 5 THEN si.qty END), 0) AS May,
        IFNULL(SUM(CASE WHEN MONTH(s.date) = 6 THEN si.qty END), 0) AS June,
        IFNULL(SUM(CASE WHEN MONTH(s.date) = 7 THEN si.qty END), 0) AS July,
        IFNULL(SUM(CASE WHEN MONTH(s.date) = 8 THEN si.qty END), 0) AS August,
        IFNULL(SUM(CASE WHEN MONTH(s.date) = 9 THEN si.qty END), 0) AS September,
        IFNULL(SUM(CASE WHEN MONTH(s.date) = 10 THEN si.qty END), 0) AS October,
        IFNULL(SUM(CASE WHEN MONTH(s.date) = 11 THEN si.qty END), 0) AS November,
        IFNULL(SUM(CASE WHEN MONTH(s.date) = 12 THEN si.qty END), 0) AS December
    FROM 
        sales s
    JOIN 
        sales_item si ON s.sales_id = si.sales_id
    JOIN 
        product p ON si.product_code = p.product_code
    WHERE 
        YEAR(s.date) = YEAR(CURRENT_DATE)
    GROUP BY 
        p.product_code, 
        p.product_name
    ORDER BY 
        p.product_name;
";

$statement=$connect->prepare($sql);
$statement->execute();
$result=$statement->fetchAll();
$total_rows = $statement->rowCount();

//Fetch results into an array
$data = [];
if ($total_rows > 0) {
    foreach ($result as $row) {
        $data[] = $row;
    }
}
    

?>
            <?php foreach ($data as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['product_code']); ?></td>
                    <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['January']); ?></td>
                    <td><?php echo htmlspecialchars($row['February']); ?></td>
                    <td><?php echo htmlspecialchars($row['March']); ?></td>
                    <td><?php echo htmlspecialchars($row['April']); ?></td>
                    <td><?php echo htmlspecialchars($row['May']); ?></td>
                    <td><?php echo htmlspecialchars($row['June']); ?></td>
                    <td><?php echo htmlspecialchars($row['July']); ?></td>
                    <td><?php echo htmlspecialchars($row['August']); ?></td>
                    <td><?php echo htmlspecialchars($row['September']); ?></td>
                    <td><?php echo htmlspecialchars($row['October']); ?></td>
                    <td><?php echo htmlspecialchars($row['November']); ?></td>
                    <td><?php echo htmlspecialchars($row['December']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
          </div>
        </div>
      </div>
    <!--Anually product stats end-->
         </div>
        </div><!-- /.container-fluid -->
    </section>

</div>

<?php
$query = "SELECT SUM(grandtotal) as total_sales, MONTHNAME(date) as month FROM sales
WHERE YEAR(date) = YEAR(CURRENT_DATE) GROUP BY MONTH(date) ORDER BY MONTH(date)";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$total_rows = $statement->rowCount();
$months = [];
$sales = [];
if($total_rows > 0)
{
  foreach($result as $row)
  {
    $months[] = $row["month"];
    $sales[] = $row["total_sales"];
  }
}

?>

<script type="text/javascript">
  
  function updateUserStatus()
  {
    jQuery.ajax({
     
     url:'update_user_status.php',
     success:function()
     {

     }

    });
  }

  setInterval(function(){
updateUserStatus();

  },5000);
  
  // Placeholder for Sales Trend Chart
  const salesCtx = document.getElementById('salesChart1').getContext('2d');
        new Chart(salesCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($months); ?>,
                datasets: [{
                    label: 'Sales',
                    data: <?php echo json_encode($sales); ?>,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    tension: 0.1
                }]
            }
        });

</script>


<?php

include('includes/footer.php');
?>