<?php
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
<title>View Products</title>
<link rel="stylesheet" href="style.css"> 
</head>
<body>
<?php require('header.php'); ?>
<div class="container">
<div class="loginform">
<?php
if(isset($_SESSION['username'])){
    require('dbconnection.php');
    $sql = "SELECT * FROM inventory";
    $results = $conn->query($sql);
?>

 <table class="products">
 <thead>
 <tr>
 <th>ID</th>
 <th>Name</th>
 <th>Price</th>
 <th>Quantity</th>
 <th>Date Added</th>
 </tr>
 </thead>
 <tbody>

 <?php
 //alternative way to display records

 while($row = $results->fetch_assoc()){
 echo "<tr>";
 echo "<td>" . $row['id'] . "</td>";
 echo "<td>" . $row['product_name'] . "</td>";
 echo "<td>" . $row['product_cost'] . "</td>";
 echo "<td>" . $row['on_hand'] . "</td>";
 echo "<td>" . $row['last_updated'] . "</td>";
 echo "</tr>";
 }

 ?>
 </tbody>
 </table>
<form action="addproducts.php" method="post">
    <input type="submit" value="Add Another Product" />
</form>
<form action="deleteproducts.php" method="post">
    <input type="submit" value="Delete a Product" />
</form>

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