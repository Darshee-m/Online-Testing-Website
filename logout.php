<?php

session_start();

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "website";

$con = mysqli_connect($servername, $username, $password, $dbname);

if($con == NULL){
	echo" connection failed";
}
else{
	echo " connection"; 
}


mysqli_select_db($con, 'website');

$usertype = $_SESSION["usertype"];
$email = $_SESSION["email"];

if($usertype == "faculty") {
	$q = "delete from subjectselected where email = '$email' ";
	mysqli_query($con, $q);
}

$q = "update $usertype set status = 'inactive' where email = '$email' ";
mysqli_query($con, $q);

session_destroy();

header('location:index.html');


?>
