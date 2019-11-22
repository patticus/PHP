<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

$error = "";

$remote_address = $_SERVER['REMOTE_ADDR'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['uname'] != null) {
    //Store the POST variables as local variables
    $form_username = filter_var($_POST['uname'], FILTER_SANITIZE_STRING);
    $form_password = $_POST['pword']; //pword is input filed name from form

    require('dbconnection.php');

    // $sql = "SELECT username, password FROM Users WHERE username='$form_username' LIMIT 1";
    // $result = $conn->query($sql);

    $stmt = $conn->prepare("SELECT username, password FROM Users WHERE username=? OR email=? LIMIT 1");
    $stmt->bind_param('ss', $form_username, $form_username);
    $stmt->execute();
    $result = $stmt->get_result();
    $stored_username;
    $stored_password;

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $stored_username = $row['username'];
            $stored_hash = $row['password'];
        }

    } else {
        $error = "Invalid Username";
    }

    if (password_verify($form_password,$stored_hash)){
        $_SESSION['username'] = $stored_username;
        
        $cookie_name = "user";
        $cookie_value = "You";
        setcookie($cookie_name, $cookie_value, time() + (180), "/");

        header('Location: home.php');
    } else if (!password_verify($form_password,$stored_hash)){
        $error = "Invalid Password";
    }
     $stmt->close();
     $conn->close();   
 }
?>

<!DOCTYPE html>
<html>
<head>
<title>My Login Page</title>
<link rel="stylesheet" href="style.css"> 
</head>
<body>
<?php require('header.php'); ?>
<div class="container">
<div class="loginform">
<?php

if ($_SESSION['username'] != null){
    header('Location: home.php');
} 
?>
<h4><?php echo $error; ?></h4>

<form action="" method="POST">
Username or Email: <input type="text" placeholder="Enter Username or Email" name="uname">
<br>
Password: <input type="password" placeholder="Enter Password" name="pword">
<br>
<input type="submit" value="Log In">
</form>
<p><a href="registration.php">Register</a> a new account.</p>
</div>
</div>
<?php require('footer.php'); ?>
</body>
</html>