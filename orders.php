<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rizq"; // your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch orders
$sql = "SELECT * FROM orders";
$result = $conn->query($sql);
$orders = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}

// Handle delete request
if (isset($_POST['delete_order_id']) && isset($_POST['delete_order_item'])) {
    $delete_id = $_POST['delete_order_id'];
    $delete_item = $_POST['delete_order_item'];
    $delete_sql = "DELETE FROM orders WHERE id = $delete_id AND item = '$delete_item'";

    if ($conn->query($delete_sql) === TRUE) {
        echo "Order deleted successfully";
    } else {
        echo "Error deleting order: " . $conn->error;
    }
    header("Location: orders.php"); // Refresh the page
}

// Handle update request
if (isset($_POST['update_order_id']) && isset($_POST['update_order_item'])) {
    $update_id = $_POST['update_order_id'];
    $update_item = $_POST['update_order_item'];
    $item = $_POST['item'];
    $size = $_POST['size'];
    $addons = $_POST['addons'];
    $total_price = $_POST['total_price'];

    $update_sql = "UPDATE orders SET item = '$item', size = '$size', addons = '$addons', totalprice = '$total_price' WHERE id = $update_id AND item = '$update_item'";

    if ($conn->query($update_sql) === TRUE) {
        echo "Order updated successfully";
    } else {
        echo "Error updating order: " . $conn->error;
    }
    header("Location: orders.php"); // Refresh the page
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rizq © Blankreaper</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(109.6deg, rgb(255, 219, 47) 11.2%, rgb(244, 253, 0) 100.2%);
            display: flex;
            filter: blur(10%);
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
            row-gap: 10rem;
        }

        .orders-container {
            width: 100%;
            max-width: 800px;
            top: -11rem;
            position: relative;
        }

        .order-card {
            background-color: #fff;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding-right: 2.29rem;
        }

        .order-card input {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .actions {
            display: flex;
            gap: 10px;
            /* Space between buttons */
            margin-top: 10px;
        }

        .action-form {
            display: inline;
            /* Ensures forms don't stack vertically */
        }

        .actions button {
            margin: 0;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .edit-btn,
        .save-btn {
            background-color: #007bff;
            color: white;
            border: none;
        }

        .edit-btn:hover,
        .save-btn:hover {
            background-color: #0056b3;
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
            border: none;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }

        .cancel-btn {
            background-color: #6c757d;
            color: white;
            border: none;
            display: none;
        }

        .cancel-btn:hover {
            background-color: #5a6268;
        }


        .save-btn {
            display: none;
        }


        .button-container {
            position: relative;
            width: 100px;
            height: 100px;
            margin-inline: auto;
            top: -7rem;
        }

        .button {
            position: absolute;
            width: 80px;
            height: 80px;
            background-color: transparent;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            outline: none;
        }

        /* Create the initial left arrow */
        .button::before,
        .button::after {
            content: '';
            position: absolute;
            width: 40px;
            height: 4px;
            background-color: black;
            transition: all 0.5s ease;
        }

        .button::before {
            transform: rotate(-45deg) translate(1px, -18px);
            border-radius: 1rem;
        }

        .button::after {
            transform: rotate(45deg) translate(1px, 17px);
            border-radius: 1rem;
        }

        .button .third-line {
            position: absolute;
            width: 88px;
            height: 4px;
            background-color: black;
            transition: all 0.5s ease;
            left: 15px;
            border-radius: 1rem;
        }

        /* Hover effect to transform the left arrow into a cross */
        .button:hover::before {
            transform: rotate(45deg) translate(0, 0);
            width: 60px;
        }

        .button:hover::after {
            transform: rotate(-45deg) translate(0, 0);
            width: 60px;
        }

        .button:hover .third-line {
            opacity: 0;
        }
    </style>
</head>

<body>

    <div class="button-container">
        <button class="button" onclick="navigateToPage()">
            <div class="third-line"></div>
        </button>
    </div>

    <div class="orders-container">
        <h2>Your Orders</h2>

        <?php if (empty($orders)) { ?>
            <p>No orders found.</p>
        <?php } else { ?>
            <?php foreach ($orders as $order) { ?>
                <div class="order-card">
                    <!-- Update Order Form -->
                    <form method="POST" action="orders.php" style="display: inline;">
                        <input type="hidden" name="update_order_id" value="<?= $order['id'] ?>">
                        <input type="hidden" name="update_order_item" value="<?= $order['item'] ?>">

                        <input type="text" name="item" class="order-name" value="<?= $order['item'] ?>" readonly>
                        <input type="text" name="size" class="order-size" value="<?= $order['size'] ?>" readonly>
                        <input type="text" name="addons" class="order-addons" value="<?= $order['addons'] ?>" readonly>
                        <input type="text" name="total_price" class="order-total" value="<?= $order['totalprice'] ?>" readonly>

                        <div class="actions">
                            <form method="POST" action="orders.php" class="action-form">
                                <input type="hidden" name="update_order_id" value="<?= $order['id'] ?>">
                                <input type="hidden" name="update_order_item" value="<?= $order['item'] ?>">

                                <button type="button" class="edit-btn" onclick="toggleEdit(this)">Edit</button>
                                <button type="submit" class="save-btn" style="display:none;">Save</button>
                                <button type="button" class="cancel-btn" style="display:none;" onclick="cancelEdit(this)">Cancel</button>
                            </form>

                            <form method="POST" action="orders.php" class="action-form">
                                <input type="hidden" name="delete_order_id" value="<?= $order['id'] ?>">
                                <input type="hidden" name="delete_order_item" value="<?= $order['item'] ?>">
                                <button type="submit" class="delete-btn">Delete</button>
                            </form>
                        </div>


                    <?php } ?>
                <?php } ?>
                </div>

                <script>
                    function toggleEdit(button) {
                        const form = button.closest('form');
                        const inputs = form.querySelectorAll('input:not([type="hidden"])');
                        const saveButton = form.querySelector('.save-btn');
                        const cancelButton = form.querySelector('.cancel-btn');
                        const editButton = form.querySelector('.edit-btn');
                        const sizeInput = form.querySelector('input[name="size"]');

                        // Save original values
                        if (!form.originalValues) {
                            form.originalValues = Array.from(inputs).map(input => input.value);
                        }

                        // Toggle edit mode, except for 'item', 'total_price', and when size is 'None'
                        inputs.forEach(input => {
                            if (input.name !== 'item' && input.name !== 'total_price' && !(input.name === 'size' && sizeInput.value === 'None')) {
                                input.readOnly = !input.readOnly;
                            }
                        });

                        // Toggle the display of the buttons
                        if (saveButton.style.display === "none" || saveButton.style.display === "") {
                            saveButton.style.display = "inline-block";
                            cancelButton.style.display = "inline-block";
                            editButton.style.display = "none";
                        } else {
                            saveButton.style.display = "none";
                            cancelButton.style.display = "none";
                            editButton.style.display = "inline-block";
                        }
                    }




                    function cancelEdit(button) {
                        const form = button.closest('form');
                        const inputs = form.querySelectorAll('input:not([type="hidden"])');
                        const saveButton = form.querySelector('.save-btn');
                        const cancelButton = form.querySelector('.cancel-btn');
                        const editButton = form.querySelector('.edit-btn');

                        // Restore original values
                        if (form.originalValues) {
                            form.originalValues.forEach((value, index) => {
                                inputs[index].value = value;
                            });
                        }

                        // Disable editing
                        inputs.forEach(input => {
                            input.readOnly = true;
                        });

                        // Toggle buttons
                        saveButton.style.display = "none";
                        cancelButton.style.display = "none";
                        editButton.style.display = "inline-block";
                    }


                    function navigateToPage() {
                        window.location.href = 'home.html';
                    }
                </script>

</body>

</html>