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

$email = $_POST["email"];
$password = $_POST["password"];
$password = $con->real_escape_string($password);
$email = $con->real_escape_string($email);

$q1 = "select * from student where email = '$email' && password = '$password' && status = 'inactive'";
$q2 = "select * from faculty where email = '$email' && password = '$password' && status = 'inactive'";
$q3 = "select * from admin where email = '$email' && password = '$password' ";

$result = mysqli_query($con, $q1);
$num = mysqli_num_rows($result);

if($num == 1) {
	$_SESSION["email"] = $email;
	$_SESSION["usertype"] = "student";
	$q = "update student set status = 'active' where email = '$email' ";
	mysqli_query($con, $q);
	if($password == "") {
		header('location:newlogin.php');
	}
	else {	
		header('location:updateStudentData.php');
	}
}
else {
	$result = mysqli_query($con, $q2);
	$num = mysqli_num_rows($result);
	if($num >= 1) {
		$_SESSION["email"] = $email;
		$_SESSION["usertype"] = "faculty";
		$q = "update faculty set status = 'active' where email = '$email' ";
		mysqli_query($con, $q);
		if($password == "") {
			header('location:newlogin.php');
		}
		else {	
		header('location:facultyhome.php');
		}
	}
	else {
		$result = mysqli_query($con, $q3);
		$num = mysqli_num_rows($result);
		if($num == 1) {
			$_SESSION["email"] = $email;
			$_SESSION["usertype"] = "admin";
			$q = "update admin set status = 'active' where email = '$email' ";
			mysqli_query($con, $q);
			header('location:adminhome.php');
		}
		else {
			echo "Username/Password is incorrect.";
			header('location:login.php');
		}
	}
}
?>
