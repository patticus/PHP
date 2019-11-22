<?php 
// Continuation of addproducts.php - This page inserts products into the database
require('dbconnection.php'); 
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
    $cookie_name = "user";
    $cookie_value = "You";
    setcookie($cookie_name, $cookie_value, time() + (180), "/");
    if(!isset($_COOKIE[$cookie_name])) {
        unset($_SESSION['username']);
        session_destroy();
        header('Location: login.php');
    }
?>

<!DOCTYPE html>
<html>
<head>
<title>Success</title>
<link rel="stylesheet" href="style.css"> 
</head>
<body>
<?php require('header.php'); ?>
<div class="container">
<div class="loginform">
<?php
if (isset($_SESSION['username'])){
if (!isset($_POST['Product']) || !isset($_POST['Price']) || !isset($_POST['Quantity'])) {
echo "<p>You have not entered all the required details.<br />
Please go back and try again.</p>";
exit;
}
$product= filter_var($_POST['Product'], FILTER_SANITIZE_STRING);
$price= filter_var($_POST['Price'], FILTER_SANITIZE_STRING);
$quantity= filter_var($_POST['Quantity'], FILTER_SANITIZE_STRING);
$price = doubleval($price);
$quantity = intval($quantity);
$date = date('Y-m-d H:i:s');
if (mysqli_connect_errno()) {
echo "<p>Error: Could not connect to database.<br/>
Please try again later.</p>";
exit;
}
$query = "INSERT INTO inventory (product_name, product_cost, on_hand, last_updated) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param('sdis', $product, $price, $quantity, $date);
$stmt->execute();
if ($stmt->affected_rows > 0) {
echo  "<h1>Success!</h1>";
echo "<p>Product inserted into the database.</p>";
?>
<form action="addproducts.php" method="post">
    <input type="submit" value="Add Another Product" />
</form><form action="showproducts.php" method="post">
    <input type="submit" value="View List of Products" />
</form>

<?php
} else {
echo "<p>An error has occurred.<br/>
The item was not added.</p>";
}
$conn->close();
?>
<?php
} else {
echo '<p>You are not logged in.</p>';
echo '<p>Only logged in members may see this page.</p>';
echo '<p><a href="login.php">Return to Login Page</a></p>';
}
?>
</div>
</div>
<?php require('footer.php'); ?>
</body>
</html>