<?php

session_start();

if($_SESSION["usertype"] != "admin") {
	echo "<script type='text/javascript'>alert('You are not authorized to visit this page');
	window.location = 'logout.php';
	</script>";
}

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "website";

$con = mysqli_connect($servername, $username, $password, $dbname);

if($con == NULL){
	echo" connection failed";
}

mysqli_select_db($con, 'website');

if(!isset($_POST["email"])) {
	echo "<script type='text/javascript'>alert('Email not set!');
	window.location = 'adminchangefacultysubject.php';
	</script>";
}
else if(!isset($_POST["work"])) {
	echo "<script type='text/javascript'>alert('Particular option not selected!');
	window.location = 'adminchangefacultysubject.php';
	</script>";
}

$email = $_POST["email"];
$_SESSION["email2"] = $email;
$_SESSION["usertype2"] = "faculty";
$q1 = "select * from faculty where email = '$email' ";
$q2 = mysqli_query($con, $q1);
$q3 = mysqli_fetch_array($q2);
$_SESSION["branch2"] = $q3['branch'];
$work = $_POST["work"];
$_SESSION["work2"] = $work;
if($work == "add") {
	header('location:adminaddacc2.php');
}
if($work == "remove") {
	header('location:adminremovefacultysubject.php');
}

?>

