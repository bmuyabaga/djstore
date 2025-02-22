<?php

//product_fetch.php

include('../../config/function.php');

$columns = array(
    0 => 'p.product_name',
    1 => 'c.category_name',
    2 => 'p.product_base_price',
    3 => 'p.product_quantity',
    4 => 'pb.batch_number',
    5 => 'pb.stock',
    6 => 'pb.production_date',
    7 => 'pb.expiry_date'
);

// Fetch total records count
$query = "SELECT COUNT(*) as total FROM product p LEFT JOIN product_batches pb ON p.product_id = pb.product_id";
$statement = $connect->prepare($query);
$statement->execute();
$totalData = $statement->fetch(PDO::FETCH_ASSOC)['total'];
$totalFiltered = $totalData;

// Search filter
$searchValue = isset($_POST["search"]["value"]) ? $_POST["search"]["value"] : '';

$query = "SELECT p.product_id, p.product_name, c.category_name, p.product_base_price, p.product_quantity AS total_Product_stock, 
                 pb.product_batches_id, pb.batch_number, pb.stock AS batch_quantity, pb.production_date, pb.expiry_date 
          FROM product p 
          LEFT JOIN product_batches pb ON p.product_id = pb.product_id 
          LEFT JOIN category c ON p.category_id = c.category_id ";

if (!empty($searchValue)) {
    $query .= " WHERE p.product_name LIKE :search 
                OR c.category_name LIKE :search 
                OR p.product_base_price LIKE :search 
                OR pb.batch_number LIKE :search";
}

$query .= " ORDER BY p.product_name ASC, pb.batch_number ASC ";

$limit = " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
$query .= $limit;

$statement = $connect->prepare($query);
if (!empty($searchValue)) {
    $statement->bindValue(':search', '%' . $searchValue . '%', PDO::PARAM_STR);
}
$statement->execute();
$products_result = $statement->fetchAll(PDO::FETCH_ASSOC);

$data = array();
$count = $_POST['start'] + 1;
$prev_product_id = null;

foreach ($products_result as $row) {
    $is_new_product = $prev_product_id !== $row['product_id'];

    $nestedData = array();
    $nestedData[] = $is_new_product ? $count++ : "";  // Serial Number
    $nestedData[] = $is_new_product ? $row["product_name"] : "";
    $nestedData[] = $is_new_product ? $row["category_name"] : "";
    $nestedData[] = $is_new_product ? $row["product_base_price"] : "";
    $nestedData[] = $is_new_product ? $row["total_Product_stock"] : "";

    // Batch number as clickable link
    if (!empty($row["batch_number"])) {
        $nestedData[] = '<a href="product_details.php?batch_id=' . $row["product_batches_id"] . '" class="text-primary">' . $row["batch_number"] . '</a>';
    } else {
        $nestedData[] = "-";
    }

    $nestedData[] = !empty($row["batch_quantity"]) ? $row["batch_quantity"] : "-";
    $nestedData[] = !empty($row["production_date"]) ? $row["production_date"] : "-";
    $nestedData[] = !empty($row["expiry_date"]) ? $row["expiry_date"] : "-";

    // Edit button for products
    if ($is_new_product) {
        $nestedData[] = '<a href="edit_product.php?product_id=' . $row["product_id"] . '" class="btn btn-sm btn-warning">Edit</a>';
    } else {
        $nestedData[] = "";
    }

    $data[] = $nestedData;
    $prev_product_id = $row['product_id'];
}

$json_data = array(
    "draw" => intval($_POST["draw"]),
    "recordsTotal" => $totalData,
    "recordsFiltered" => $totalFiltered,
    "data" => $data
);

echo json_encode($json_data);
?>
