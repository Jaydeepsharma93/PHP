<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");


$conn = new mysqli('localhost', 'root', '', 'product_db');
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed: " . $conn->connect_error]));
}

// Initialize response array
$response = [];

// Insert product into database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are provided
    if (isset($_POST['name']) && isset($_POST['price']) && isset($_POST['description'])) {
        $name = $conn->real_escape_string($_POST['name']);
        $price = $conn->real_escape_string($_POST['price']);
        $description = $conn->real_escape_string($_POST['description']);

        $sql = "INSERT INTO products (name, price, description) VALUES ('$name', '$price', '$description')";
        if ($conn->query($sql) === TRUE) {
            $response['status'] = "Product added successfully!";
        } else {
            $response['error'] = "Error inserting product: " . $conn->error;
        }
    } else {
        $response['error'] = "Missing required fields: name, price, description.";
    }
} else {
    $response['error'] = "Only POST method is allowed.";
}

// Close the database connection
$conn->close();

// Output the response in JSON format
echo json_encode($response);

?>
