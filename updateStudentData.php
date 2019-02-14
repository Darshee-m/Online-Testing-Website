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

$email = $_SESSION["email"];
$usertype = $_SESSION["usertype"];

if($usertype == "student") {
	$q1 = "select * from student where email = '$email' ";
	$q2 = mysqli_query($con, $q1);
	$q3 = mysqli_fetch_array($q2);
	$password = $q3['password'];
	echo "1";
	echo "$password";
	echo "2";

	if($password == "")
	{
		$password = $_POST["password"];
		$password = $con->real_escape_string($password);
		$roll = $_POST["roll"];
		$roll = $con->real_escape_string($roll);
		$name = $_POST["name"];
		$name = $con->real_escape_string($name);
		$join_year1 = $roll/100000;
		$join_year = $join_year1 + 2000;
		$q = "update student set join_year = '$join_year' where email = '$email' ";
		mysqli_query($con, $q);
		$q = "update student set password = '$password' where email = '$email' ";
		mysqli_query($con, $q);
		$q = "update student set rollnumber = '$roll' where email = '$email' ";
		mysqli_query($con, $q);
		$q = "update student set name = '$name' where email = '$email' ";
		mysqli_query($con, $q);
	}
	
	$date = getdate();


	$q1 = "select * from student where email = '$email'";
	$q2 = mysqli_query($con, $q1);
	$q3 = mysqli_fetch_array($q2);
	$join_year = $q3['join_year']; 
	
	$roll = $q3['rollnumber'];
	$temp = $roll/10000;
	$temp2 = $roll/100000;
	$sem_gap = $temp%$temp2;
	$sem_gap = $sem_gap - 1;
	$sem_gap = $sem_gap * 2;

	//input from admin
	$r1 = "select * from reopen";
	$r2 = mysqli_query($con, $r1);
	$r3 = mysqli_fetch_array($r2);
	
	$sem_startDate = $r3['date'];
	$sem_startMonth = $r3['month'];
	$sem_startYear = $r3['year'];

	$year_difference = $date['year'] - $join_year;
	if($date['mon'] == $sem_startMonth) {
		if($date['mday'] >= $sem_startDate) {
			$current_sem = ($year_difference * 2) + 1;
		}
		else {
			$current_sem = $year_difference * 2;
		}
	}
	else {
		if($date['mon'] > $sem_startMonth) {
			$current_sem = ($year_difference * 2) + 1;
		}
		else {
			$current_sem = $year_difference * 2;
		}
	}
	
	$current_sem = $current_sem + $sem_gap;

	$q = " update student set semester = '$current_sem' where email = '$email' ";
	mysqli_query($con, $q);
	header('location:studenthome.php');
}
else {
	$q1 = "select * from faculty where email = '$email' ";
	$q2 = mysqli_query($con, $q1);
	$q3 = mysqli_fetch_array($q2);
	$password = $q3['password'];
	if($password == "") {
		$name = $_POST["name"];
		$password = $_POST["password"];
		$q = " update faculty set name = '$name' where email = '$email' ";
		mysqli_query($con, $q);
		$q = " update faculty set password = '$password' where email = '$email' ";
		mysqli_query($con, $q);
	}
	header('location:facultyhome.php');
}

?>
