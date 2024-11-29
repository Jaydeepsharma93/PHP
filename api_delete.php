<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE");
header("Content-Type: application/json");

$conn = new mysqli('localhost', 'root', '', 'product_db');
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed: " . $conn->connect_error]));
}

$response = [];

if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    // Raw JSON input पढ़ना
    $input = json_decode(file_get_contents("php://input"), true);

    if (isset($input['id'])) {
        $id = $conn->real_escape_string($input['id']);

        $sql = "DELETE FROM products WHERE id = '$id'";
        if ($conn->query($sql) === TRUE) {
            if ($conn->affected_rows > 0) {
                $response['status'] = "Product deleted successfully!";
            } else {
                $response['error'] = "No product found with the given ID.";
            }
        } else {
            $response['error'] = "Error deleting product: " . $conn->error;
        }
    } else {
        $response['error'] = "Missing required field: id.";
    }
} else {
    $response['error'] = "Only DELETE method is allowed.";
}

$conn->close();

echo json_encode($response);

?>
