
<?php
// *NOTE: This is split up into two pages - adding products to database continues on addproducts2.php file
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
<title>Add Products</title>
<link rel="stylesheet" href="style.css"> 
</head>
<body>
<?php require('header.php'); ?>
<div class="container">
<div class="loginform">
<?php
// check session variable
if (isset($_SESSION['username']))
{
echo "You are logged in as " . $_SESSION['username'];
echo '<p><em>You may add products to the store.</em></p>';
?>
<form action="addproducts2.php" method="post">
<fieldset>
<p><label for="Product">Product:</label>
<input type="text" id="Product" name="Product" placeholder="Product Name"
maxlength="60" size="30" required /></p>
<p><label for="Price">Price:</label>
 <input type="text" placeholder="$" id="Price" name="Price"
maxlength="7" size="7" required /></p>
<p><label for="Quantity">Quantity:</label>
<input type="number" placeholder="Quantity" id="Quantity" name="Quantity"
maxlength="7" size="7" required /></p>
</fieldset>
<p><input type="submit" value="Add New Product" /></p>
</form>
</form>
<form action="showproducts.php" method="post">
    <input type="submit" value="View List of Products" />
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