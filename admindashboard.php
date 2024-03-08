<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

require_once 'config.php'; // Assuming config.php contains database connection details
$conn = new PDO($dsn, $username, $password, $options);

// Fetch tasks and user information
$sql = "SELECT * FROM products";
$stmt = $conn->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        color: #700961;
    }

    h1 {
        text-align: center;
        color: #555;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    th,
    td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ccc;
    }

    th {
        background-color: #f8f8f8;
        color: #555;
    }

    tr:hover {
        background-color: #f2f2f2;
    }

    .nav-links {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .nav-links a {
        margin: 0 10px;
        color: #555;
        text-decoration: none;
    }
    </style>
</head>

<body>
    <h1>Welcome to the Admin Panel</h1>

    <!-- <div class="nav-links">
        <a href="admindashboard.php">Admin Panel</a>
        <a href="show.php">Show Tasks</a>
        <a href="task.php">Add Admin Task</a>
        <a href="show_users.php">Show Users</a>
        <a href="logout.php">Logout</a>
    </div> -->

    <table>
        <thead>
            <tr>
                <th>Products</th>
                <th>Price</th>
                <th>Expired Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
            <?php if($_SESSION['role'] === "admin"): ?>
            <tr>
                <form action="" method="GET">
                    <td><input type="text" name="product_name" id="product_name"
                            value="<?php echo $product['product_name']; ?>"></td>
                    <td><input type="text" name="product_price" id="product_price"
                            value="<?php echo $product['product_price']; ?>"></td>
                    <td><input type="date" name="expired_date" id="expired_date"
                            value="<?php echo $product['expired_date']; ?>"></td>
                    <td>
                        <input type="hidden" name="product_id" id="product_id"
                            value="<?php echo $product['product_id']; ?>">
                        <input type="submit" value="Edit" class="button">
                    </td>
                </form>
            </tr>
            <?php endif; ?>
            <?php endforeach; ?>
                <?php if($_SESSION['role'] === "admin"): ?>
            <tr>
                <form action="" method="GET">

                    <td><input type="text" name="product_name2" id="product_name"></td>
                    <td><input type="text" name="product_price2" id="product_price"></td>
                    <td><input type="date" name="expired_date2" id="expired_date"></td>
                    <td><input type="submit" value="add" class="button"></td>
                </form>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>

<?php 
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['product_name']) && isset($_GET['product_price']) && isset($_GET['expired_date']) && isset($_GET['product_id'])) {
    $name = $_GET['product_name'];
    $price = $_GET['product_price'];
    $date = $_GET['expired_date'];
    $id = $_GET['product_id'];
    try {
        $sql = "UPDATE products SET product_name = :uname, product_price = :price, expired_date = :edate WHERE product_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':uname', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':edate', $date);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        echo "Product updated successfully.";
    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
}



if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['product_name2']) && isset($_GET['product_price2']) && isset($_GET['expired_date2'])) {
    $name2 = $_GET["product_name2"];
    $price2 = $_GET['product_price2'];
    $date2 = $_GET['expired_date2'];
   try { 
    $sql2 = "INSERT INTO products ( product_name ,product_price ,expired_date ) VALUES (:name2, :price2 ,:date2 );";
    $stmt = $conn->prepare($sql2);
    $stmt->bindParam(':name2', $name2);
    $stmt->bindParam(':price2', $price2);
    $stmt->bindParam(':date2', $date2);
    $stmt->execute();}
    catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
    }
?>


</html>