<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
?>

<div class="fixed">
<ul>
  <li><a href="home.php">Home</a></li>
  <li><a href="addproducts.php">Add Product</a></li>
  <li><a href="showproducts.php">View Products</a></li>
  <li><a href="deleteproducts.php">Delete Products</a></li>
  <?php if( isset($_SESSION['username']) && !empty($_SESSION['username']) )
    {
    ?>
        <li><a href="logout.php">Log Out</a></li>
        <li><a href="passwd.php">Chang Passwd</a></li>
    <?php } else { ?>
        <li><a href="login.php">Log In</a></li>
    <?php } ?>
  
</ul>
</div>
