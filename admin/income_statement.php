<?php
include('../config/function.php');

if (!isset($_SESSION["type"])) {
    header('location:../login.php');
}

include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');

// Default values for the income statement variables
$total_revenue = 0;
$beginning_inventory = 0;
$total_purchases = 0;
$ending_inventory = 0;
$cogs = 0;
$gross_profit = 0;
$total_expenses = 0;
$net_profit = 0;

// Determine the current date and check if it's the end of the quarter
$year = date('Y');
$current_month = date('n'); // Numeric month (1-12)

// Define quarterly periods and check if we are at the end of the quarter
if ($current_month == 3 || $current_month == 6 || $current_month == 9 || $current_month == 12) {
    $start_date = date('Y-01-01');  // Start date of the year (quarterly calculation)
    $end_date = date('Y-m-t');  // End date of the current quarter (using the current month end)
    
    // Fetch Revenue
    $revenue_stmt = $connect->prepare("SELECT SUM(total) AS total_revenue FROM sales WHERE date BETWEEN ? AND ?");
    $revenue_stmt->execute(array($start_date, $end_date));
    $revenue = $revenue_stmt->fetch(PDO::FETCH_ASSOC);
    $total_revenue = isset($revenue['total_revenue']) ? $revenue['total_revenue'] : 0;

    // Fetch Purchases
    $purchases_stmt = $connect->prepare("SELECT SUM(stock * cost) AS total_purchases FROM product_batches WHERE received_date BETWEEN ? AND ?");
    $purchases_stmt->execute(array($start_date, $end_date));
    $purchases = $purchases_stmt->fetch(PDO::FETCH_ASSOC);
    $total_purchases = isset($purchases['total_purchases']) ? $purchases['total_purchases'] : 0;

    // Fetch Beginning and Ending Inventory
    $begin_stmt = $connect->prepare("SELECT SUM(stock * cost) AS beginning_inventory FROM product_batches WHERE received_date < ?");
    $begin_stmt->execute(array($start_date));
    $beginning_inventory = $begin_stmt->fetch(PDO::FETCH_ASSOC);
    $beginning_inventory = isset($beginning_inventory['beginning_inventory']) ? $beginning_inventory['beginning_inventory'] : 0;

    $end_stmt = $connect->prepare("SELECT SUM(stock * cost) AS ending_inventory FROM product_batches WHERE received_date <= ?");
    $end_stmt->execute(array($end_date));
    $ending_inventory = $end_stmt->fetch(PDO::FETCH_ASSOC);
    $ending_inventory = isset($ending_inventory['ending_inventory']) ? $ending_inventory['ending_inventory'] : 0;

    // Calculate COGS
    $cogs = $beginning_inventory + $total_purchases - $ending_inventory;

    // Fetch Expenses
    $expenses_stmt = $connect->prepare("SELECT expaccount.expense_account AS category, SUM(expense.expense_total_cost) AS total_expense FROM expense
    LEFT JOIN expaccount ON expense.expenseaccount_id = expaccount.expenseaccount_id
     WHERE expense.status = 'active' AND expense.expense_date BETWEEN ? AND ? GROUP BY category");
    $expenses_stmt->execute(array($start_date, $end_date));
    $expenses = $expenses_stmt->fetchAll(PDO::FETCH_ASSOC);
    $total_expenses = 0;
    foreach ($expenses as $expense) {
        $total_expenses += $expense['total_expense'];
    }

    // Calculate Gross and Net Profit
    $gross_profit = $total_revenue - $cogs;
    $net_profit = $gross_profit - $total_expenses;

    // Check if the income statement for this quarter already exists
    $check_stmt = $connect->prepare("SELECT id FROM income_statements WHERE start_date = ? AND end_date = ?");
    $check_stmt->execute([$start_date, $end_date]);

    if ($check_stmt->rowCount() == 0) {
        // Insert income statement into the database
        $insert_stmt = $connect->prepare("INSERT INTO income_statements 
            (start_date, end_date, total_revenue, beginning_inventory, total_purchases, ending_inventory, cogs, gross_profit, total_expenses, net_profit, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

        $insert_stmt->execute([
            $start_date,
            $end_date,
            $total_revenue,
            $beginning_inventory,
            $total_purchases,
            $ending_inventory,
            $cogs,
            $gross_profit,
            $total_expenses,
            $net_profit
        ]);

        if ($insert_stmt->rowCount() > 0) {
            echo "<script>alert('Income Statement for the quarter saved successfully');</script>";
        } else {
            echo "<script>alert('Failed to save Income Statement');</script>";
        }
    } else {
        echo "<script>alert('Income Statement for this quarter already exists');</script>";
    }
} else {
    echo "<script>alert('Not the end of the quarter yet!');</script>";
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
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Reports</li>
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
                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Income Statement</h3>
                            </div> <!-- /.card-body -->
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr><th>Category</th><th>Amount ($)</th></tr>
                                    <tr><td>Revenue</td><td><?= number_format($total_revenue, 2) ?></td></tr>
                                    <tr><td>Beginning Inventory</td><td><?= number_format($beginning_inventory, 2) ?></td></tr>
                                    <tr><td>Purchases</td><td><?= number_format($total_purchases, 2) ?></td></tr>
                                    <tr><td>Ending Inventory</td><td><?= number_format($ending_inventory, 2) ?></td></tr>
                                    <tr><td><strong>COGS</strong></td><td><strong><?= number_format($cogs, 2) ?></strong></td></tr>
                                    <tr><td>Gross Profit</td><td><?= number_format($gross_profit, 2) ?></td></tr>
                                    <tr><td>Total Expenses</td><td><?= number_format($total_expenses, 2) ?></td></tr>
                                    <tr><td><strong>Net Profit</strong></td><td><strong><?= number_format($net_profit, 2) ?></strong></td></tr>
                                </table>
                                <a href="export_income_statement.php?start_date=<?= $start_date ?>&end_date=<?= $end_date ?>" class="btn btn-primary">Export to Excel</a>
                                <a href="print_income_statement.php?start_date=<?= $start_date ?>&end_date=<?= $end_date ?>" class="btn btn-danger">Download PDF</a>
                            </div><!-- /.card-body -->
                        </div>
                    </div><!-- /.container-fluid -->
                </section>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(function(){
 $('.select2').select2({
    theme: 'bootstrap4'
   });
})
</script>

<script>
$(document).ready(function(){
  $('#filter').click(function(){
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();

        if(from_date != '' && to_date != '') {
            window.location.href = "income_statement.php?start_date=" + from_date + "&end_date=" + to_date;
        } else {
            alert("Please Select Date");
        }
    });
});
</script>

<?php
include('includes/footer.php');
?>
