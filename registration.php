<?php

session_start();

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "website";

$con = mysqli_connect($servername, $username, $password, $dbname);

if($con == NULL){
	echo" connection failed";
}else{
	echo " connection"; 
}

mysqli_select_db($con, 'website');

$name = $_GET['username'];
$pass = $_GET['password'];
$usertype = $_GET['usertype'];
$divs = $_GET['divi'];
$sub = $_GET['subject_taught'];

if($usertype == "student"){
$usertype = "students";
}else{
$usertype = "faculty";
}

echo $usertype;

$q = " select * from $usertype where name = '$name' && password = '$pass' ";

$result = mysqli_query($con, $q);

$num = mysqli_num_rows($result);

if($num == 1){
	echo" duplicate data ";
}else{
	if($usertype == "students") {
		$qy= " insert  into students(name , password , division) values ('$name' , '$pass' , '$divs') ";
	}else {
		$qy = " insert into faculty(name , password , subject , division) values ('$name' , '$pass' , '$sub' , '$divs') "; 	
	}
	mysqli_query($con, $qy);
	$_SESSION['username'] = $name;
	header('location:index.html');
}

mysqli_close($con);

?>
