<?php
require 'dompdf/autoload.inc.php'; // Include DomPDF Library
use Dompdf\Dompdf; // Reference the DomPDF namespace
include('../config/function.php');
if(!isset($_SESSION["type"]))
{
    header('location:../login.php');
}

// Get date range (default: current month)
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-t');

// Fetch Beginning Inventory
$begin_stmt = $connect->prepare("SELECT SUM(quantity * cost_price) AS beginning_inventory FROM product_batches WHERE received_date < ?");
$begin_stmt->execute(array($start_date));
$beginning_inventory = $begin_stmt->fetch(PDO::FETCH_ASSOC);
$beginning_inventory = isset($beginning_inventory['beginning_inventory']) ? $beginning_inventory['beginning_inventory'] : 0;

// Fetch Purchases during the period
$purchases_stmt = $connect->prepare("SELECT SUM(quantity * cost_price) AS total_purchases FROM product_batches WHERE received_date BETWEEN ? AND ?");
$purchases_stmt->execute(array($start_date, $end_date));
$total_purchases = $purchases_stmt->fetch(PDO::FETCH_ASSOC);
$total_purchases = isset($total_purchases['total_purchases']) ? $total_purchases['total_purchases'] : 0;

// Fetch Ending Inventory
$end_stmt = $connect->prepare("SELECT SUM(quantity * cost_price) AS ending_inventory FROM product_batches WHERE received_date <= ?");
$end_stmt->execute(array($end_date));
$ending_inventory = $end_stmt->fetch(PDO::FETCH_ASSOC);
$ending_inventory = isset($ending_inventory['ending_inventory']) ? $ending_inventory['ending_inventory'] : 0;

// Calculate COGS
$cogs = $beginning_inventory + $total_purchases - $ending_inventory;

// Generate PDF
$dompdf = new Dompdf();
$html = "<h2>Cost of Goods Sold (COGS) Report</h2>
        <p>From: $start_date To: $end_date</p>
        <table border='1' cellpadding='10'>
            <tr><th>Category</th><th>Amount ($)</th></tr>
            <tr><td>Beginning Inventory</td><td>" . number_format($beginning_inventory, 2) . "</td></tr>
            <tr><td>Purchases</td><td>" . number_format($total_purchases, 2) . "</td></tr>
            <tr><td>Ending Inventory</td><td>" . number_format($ending_inventory, 2) . "</td></tr>
            <tr><td><strong>COGS</strong></td><td><strong>" . number_format($cogs, 2) . "</strong></td></tr>
        </table>";
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("COGS_Report.pdf", array("Attachment" => true));
?>
