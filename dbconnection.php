<?php

//Setup database connection variables

$dbservername = "localhost";
$dbusername = "pjohnson37";
$dbpassword = "southhills#";
$dbname = "pjohnson37";

//Create the connection
$conn = new mysqli($dbservername,$dbusername,$dbpassword,$dbname);

if($conn->connect_error) {
    die("Ok, my teacher did not know what he was doing");
}
?>