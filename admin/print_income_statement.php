<?php
// Include necessary files
include('../config/function.php');
require_once '../dompdf/autoload.inc.php'; // Path to DomPDF autoload

use Dompdf\Dompdf;

// Fetch Income Statement data as already fetched in your main page
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-t');

// Fetching the data from the database (same queries as before)
$revenue_stmt = $connect->prepare("SELECT SUM(total) AS total_revenue FROM sales WHERE date BETWEEN ? AND ?");
$revenue_stmt->execute(array($start_date, $end_date));
$revenue = $revenue_stmt->fetch(PDO::FETCH_ASSOC);
$total_revenue = isset($revenue['total_revenue']) ? $revenue['total_revenue'] : 0;

// Repeat for Purchases, Beginning Inventory, Ending Inventory, Expenses, etc...

// Create HTML content for the PDF
$html = '
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Income Statement from ' . $start_date . ' to ' . $end_date . '</h2>
    <table>
        <tr><th>Category</th><th>Amount ($)</th></tr>
        <tr><td>Revenue</td><td>' . number_format($total_revenue, 2) . '</td></tr>
        <tr><td>Beginning Inventory</td><td>' . number_format($beginning_inventory, 2) . '</td></tr>
        <tr><td>Purchases</td><td>' . number_format($total_purchases, 2) . '</td></tr>
        <tr><td>Ending Inventory</td><td>' . number_format($ending_inventory, 2) . '</td></tr>
        <tr><td><strong>COGS</strong></td><td><strong>' . number_format($cogs, 2) . '</strong></td></tr>
        <tr><td>Gross Profit</td><td>' . number_format($gross_profit, 2) . '</td></tr>
        <tr><td>Total Expenses</td><td>' . number_format($total_expenses, 2) . '</td></tr>
        <tr><td><strong>Net Profit</strong></td><td><strong>' . number_format($net_profit, 2) . '</strong></td></tr>
    </table>
</body>
</html>
';

// Initialize DomPDF
$dompdf = new Dompdf();

// Load HTML content
$dompdf->loadHtml($html);

// (Optional) Set paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render PDF (first pass)
$dompdf->render();

// Output the generated PDF (force download)
$dompdf->stream('Income_Statement_' . $start_date . '_to_' . $end_date . '.pdf', array('Attachment' => 1));
exit;
?>
