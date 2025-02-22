<?php
include('config/function.php');
if(!isset($_SESSION['type']))
{
  header("location:login.php");
}

include('includes/header.php');
include('includes/sidebar.php');


$stmt = $connect->prepare("SELECT w.id, w.purchase_id,w.product_id, p.product_name AS productName, p.product_code, w.quantity, w.received_quantity, w.status
                           FROM warehouse_alerts w
                           INNER JOIN product p ON w.product_id = p.product_id
                           WHERE w.status != 'Received'");
$stmt->execute();
$alerts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch total sales
$stmt = $connect->prepare("SELECT COUNT(*) AS pending_purchases FROM warehouse_alerts WHERE status != 'Received'");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$pending_purchases = $row['pending_purchases'] ? $row['pending_purchases'] : 0;

// Fetch total products
$stmt = $connect->prepare("SELECT COUNT(*) AS total_products FROM product WHERE product_status = 'active'");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$totalProducts = $row['total_products'] ? $row['total_products'] : 0;

// Fetch low stock products
$stmt = $connect->prepare("SELECT COUNT(*) AS low_stock_products FROM product WHERE product_quantity <= 3 AND product_status = 'active'");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$low_stock_products = $row['low_stock_products'] ? $row['low_stock_products'] : 0;

// Fetch total suppliers
$stmt = $connect->prepare("SELECT COUNT(DISINCT product_id) AS total_product_received_today FROM product_batches WHERE DATE(date_received) = CURDATE()");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$total_product_received_today = $row['total_product_received_today'] ? $row['total_product_received_today'] : 0;


?>
 <main class="col-md-10 ms-sm-auto px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard Overview</h1>
                </div>
                
                <div class="row">
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <h5>Pending Purchases</h5>
                                <h2><?= $pending_purchases ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h5>Stock Items</h5>
                                <h2><?= $totalProducts ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-danger text-white">
                            <div class="card-body">
                                <h5>Low Stock Alerts</h5>
                                <h2><?= $low_stock_products ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h5>Received Today</h5>
                                <h2><?= $total_product_received_today ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <h4>Pending Purchases</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>PurchaseID</th>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Received Quantity</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (count($alerts) > 0): ?>
                <?php foreach ($alerts as $alert): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($alert['id']); ?></td>
                        <td><?php echo htmlspecialchars($alert['purchase_id']); ?></td>
                        <td><?php echo htmlspecialchars($alert['productName']); ?></td>
                        <td><?php echo htmlspecialchars($alert['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($alert['received_quantity']); ?></td>
                        <td><span class="badge bg-warning"><?php echo htmlspecialchars($alert['status']); ?></span></td>
                        <td>
                            <!--<button class="btn btn-sm btn-success">Received</button>-->
                            <a href="product_receiving.php?pid=<?php echo $alert['product_id']; ?> && purchaseId=<?php echo $alert['purchase_id']; ?> && sku=<?php echo $alert['product_code']; ?>" class="btn btn-sm btn-success">Receive</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">No pending warehouse alerts</td>
                </tr>
            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </main>
            <?php include('includes/footer.php'); ?>