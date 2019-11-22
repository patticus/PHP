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

$error = "";
$username = $_SESSION['username'];
$remote_address = $_SERVER['REMOTE_ADDR'];
$password = $_POST['pword'];
$confirmation_password = $_POST['cpword'];
$hash = password_hash($password,PASSWORD_BCRYPT);

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['oldpword'] != null) {
    //Store the POST variables as local variables
    $form_password = $_POST['oldpword']; //pword is input filed name from form

    require('dbconnection.php');

    $stmt = $conn->prepare("SELECT password FROM Users WHERE username=? LIMIT 1");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $stored_hash = $row['password'];
        }

    } else {
        $error = "Invalid Password";
    }

    if (password_verify($form_password,$stored_hash)){
        if ($password == $confirmation_password){

            if ($password == $form_password){
                $error = "Cannot reuse old password.";
            } else {
                $stmt2 = $conn->prepare("UPDATE Users SET password =? WHERE username =?"); //created statement; ?=variable
                $stmt2->bind_param("ss", $hash, $username); //bind the values to statement; s=string
                $stmt2->execute(); //run the prepared statement with variable values

                //Logs out and redirects to login page
                unset($_SESSION['username']);
                session_destroy();
                header('Location: pwdredirect.html');    

                $stmt2->close();

            }
    
        } else {
            $error = "Passwords do not match.";
        }
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
<h2>Change password for <?php echo $username; ?> </h2>
<h4><?php echo $error; ?></h4>
<form action="" method="POST">
Old Password: <input type="password" name="oldpword"> <br />
New Password: <input type="password" name="pword"> <br />
Confirm Password: <input type="password" name="cpword"> <br />
<input type="submit" value="SUBMIT">
</form>
</div>
</div>
<?php require('footer.php'); ?>
</body>
</html>