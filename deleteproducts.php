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
<title>Delete Products</title>
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
<?php
$id= filter_var($_POST['delete'], FILTER_SANITIZE_NUMBER_INT);
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $query = "DELETE FROM inventory WHERE Id= (?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();


    if ($stmt->affected_rows > 0) {
    header('Location: '.$_SERVER['REQUEST_URI']);
    echo "<p>Product deleted from the database.</p>";
    }
}
?>

<form action="" method="POST">

    <input type="text" placeholder="Enter ID number to delete" name="delete">
    <input type="submit" value="Delete">
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