<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json");

$conn = new mysqli('localhost', 'root', '', 'product_db');
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed: " . $conn->connect_error]));
}

$response = [];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sql = "SELECT * FROM products";  // This will fetch all products from the table
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;  // Collect all products in an array
        }
        $response['status'] = "success";
        $response['data'] = $products;  // Returning the list of products
    } else {
        $response['error'] = "No products found.";  // In case no products are found
    }
} else {
    $response['error'] = "Only GET method is allowed.";  // Handling if method is not GET
}

$conn->close();

echo json_encode($response);  // Return the final JSON response

?>
