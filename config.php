<?php
session_start(); 

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rizq";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verify that session variables exist
if (!isset($_SESSION['id']) || !isset($_SESSION['name']) || !isset($_SESSION['email'])) {
    header("Location: logreg.php"); // Redirect to login if session variables are not set
    exit();
}

// Retrieve session data
$userId = $_SESSION['id'];
$name = $_SESSION['name'];
$email = $_SESSION['email'];

// Get additional data from URL parameters
$item = isset($_GET['item-name']) ? $_GET['item-name'] : null;
$size = isset($_GET['size']) ? $_GET['size'] : null;
$addons = isset($_GET['addons']) ? $_GET['addons'] : null;
$totalprice = isset($_GET['total-price']) ? $_GET['total-price'] : null;
$paymentType = isset($_GET['paymenttype']) ? $_GET['paymenttype'] : null;

// Prepare and bind SQL statement to insert data into the `orders` table
$stmt = $conn->prepare("INSERT INTO orders (id, name, email, item, size, addons, totalprice, paymenttype) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssssss", $userId, $name, $email, $item, $size, $addons, $totalprice, $paymentType);

// Execute the statement
if ($stmt->execute()) {
    // Redirect to checkoutcomplete.html if successful
    header("Location: checkoutcomplete.html");
    exit(); // Ensure no further code is executed after the redirect
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and the database connection
$stmt->close();
$conn->close();
?>
