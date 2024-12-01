<?php
session_start();
if (!isset($_SESSION['id'])) {
    // If the user is not logged in, return an empty JSON response
    header("Content-Type: application/json");
    echo json_encode([]);
    exit();
}

require 'db_conn.php'; // Include your database connection

$userId = $_SESSION['id']; // Get the logged-in user's ID

// Fetch orders for the logged-in user
$sql = "SELECT * FROM orders WHERE id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

// Return the orders as a JSON response
header("Content-Type: application/json");
echo json_encode($orders);

$stmt->close();
$conn->close();
?>
