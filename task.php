<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
require_once 'config.php';
$sql="SELECT * FROM products ";
$sql=$pdo->prepare($sql);
$sql->execute();
$products=$sql->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TASK TO-DO</title>
    <style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    button {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
    }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Expiration Date</th>
                <?php if($_SESSION['role'] === 'admin' ||$_SESSION['role'] === 'user' ){ ?>
                <th>Action</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach($products as $product): ?>
            <tr>
                <td><?php echo $product['product_name'];?></td>
                <td><?php echo $product['product_price'];?>$</td>
                <td><?php echo $product['expired_date'];?></td>
                <?php if($_SESSION['role'] === "admin"){ ?>
                    <td>
                        <a href="http://localhost:8889/php_task/admindashboard.php">edit</a>
                    </td>
                <?php }?>
                <?php if($_SESSION['role'] === "user"){ ?>
                    <td>
                        <form action ="" method="get">
                        <input type="hidden" name="product_name" value="<?php echo  $product['product_name'];?>">
                        <input type = "number" name="quantity" value="">
                        <input type="submit" value="add to cart">
                        </form>
                    </td>
                <?php }?>
            <?php endforeach; ?>
            </tr>
        </tbody>
    </table>
</body>
</html>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['product_name']) && isset($_GET['quantity'])) {
    $products = $_GET['product_name'];
    $quantity = $_GET['quantity'];
    $id = $_SESSION['user_id'];

    try {
        $sql = "INSERT INTO cart ( products, quantity , customer_id_customer ) VALUES (:products, :quantity , :user_id)";
        $stmt = $pdo->prepare($sql); 
        $stmt->bindParam(':products', $products);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':user_id', $id);

        $stmt->execute();

        echo "Product added to cart successfully.";
    } catch (PDOException $e) {
        // Handle database errors
        echo "error: " . $e->getMessage();
    }
}
?>
