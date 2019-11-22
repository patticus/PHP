<?php
session_start();
// store to test if they *were* logged in
$old_user = $_SESSION['username'];
unset($_SESSION['username']);
session_destroy();

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
if (!empty($old_user))
{
echo '<h1>You have been logged out.</h1>';
}
else
{
// if they weren't logged in but came to this page somehow
echo '<p>You were not logged in, and so have not been logged out.</p>';
}
?>
<p><a href="login.php">Back to Login Page</a></p>
</div>
</div>
<?php require('footer.php'); ?>
</body>
</html>