<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
    require('dbconnection.php');
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $username = filter_var($_POST['uname'], FILTER_SANITIZE_STRING);
    $password = $_POST['pword'];
    $confirmation_password = $_POST['cpword'];
    $remote_address = $_SERVER['REMOTE_ADDR'];
    $hash = password_hash($password,PASSWORD_BCRYPT);
    $error = "";

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address';
    } else {
        $sql_u = "SELECT * FROM Users WHERE username='$username'";
        $sql_e = "SELECT * FROM Users WHERE email='$email'";
        $res_u = mysqli_query($conn, $sql_u);
        $res_e = mysqli_query($conn, $sql_e);
    
        if (mysqli_num_rows($res_u) > 0) {
          $error = 'Username already exists'; 	
        } else if(mysqli_num_rows($res_e) > 0){
          $error = 'Email address already exists';
        } else {
            if ($password == $confirmation_password){
        
                $stmt = $conn->prepare("INSERT INTO Users (username, password, email) VALUES (?,?,?)"); //created statement; ?=variable
                $stmt->bind_param("sss", $username, $hash, $email); //bind the values to statement; s=string
                $stmt->execute(); //run the prepared statement with variable values
                $stmt->close(); //terminate the prepared statement
                $conn->close(); //close the database connection

                header('Location: redirect.html');
        
            }else {
                $error = "Passwords do not match.";
            }
        }
    }  
}

?>
<!DOCTYPE html>
<html>
<head>
<title>The Registration Page</title>
<link rel="stylesheet" href="style.css"> 
</head>
<body>
<?php require('header.php'); ?>
<div class="container">
<div class="loginform">
<h2>REGISTER YOUR ACCOUNT BUDDY!</h2>
<h4><?php echo htmlspecialchars($error); ?></h4>
<form action="" method="POST">
Email: <input type="text" name="email"> <br />
Username: <input type="text" name="uname"> <br />
Password: <input type="password" name="pword"> <br />
Confirm Password: <input type="password" name="cpword"> <br />
<input type="submit" value="SUBMIT">
</form>
<p>Already Have an account?<p>
<form action="login.php" method="POST">
    <input type="submit" value="Log In">
</div>
</div>
<?php require('footer.php'); ?>
</body>
</html>