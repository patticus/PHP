<?php
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

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if ($_POST['logout'] == 'logout'){
        unset($_SESSION['username']);
        session_destroy(); 
        header('Location: login.php');
    }
    if ($_POST['continue'] == 'continue'){
        header('Location: addproducts.php');
    } 
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Welcome</title>
<link rel="stylesheet" href="style.css"> 
</head>
<body>
<?php require('header.php'); ?>
<div class="container">
<div class="loginform">
<?php
if (isset($_SESSION['username']))
{
?>
<h1><?php echo "Welcome, " . $_SESSION['username'] . "!"; ?></h1>
<form action="" method="POST">
<input type="submit" value="Continue" name = "continue">
<input type="hidden" value="continue" name = "continue">
</form>
<form action="" method="POST">
<input type="submit" value="Log Out" name = "logout">
<input type="hidden" value="logout" name = "logout">
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