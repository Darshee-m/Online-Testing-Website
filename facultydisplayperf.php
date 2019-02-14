<?php 
session_start();

if($_SESSION["usertype"] != "faculty") {
	echo "<script type='text/javascript'>alert('You are not authorized to visit this page!');
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
}else{
	echo " connection"; 
}

mysqli_select_db($con, 'website');

if(!isset($_SESSION["topic"])) {
	echo "<script type='text/javascript'>alert('You have not selected topic yet!');
	window.location = 'facultytopic.php';
	</script>";
}

$topic = $_SESSION["topic"];
$email = $_SESSION["email"];
$q1 = "select * from subjectselected where email = '$email' ";
$q2 = mysqli_query($con, $q1);
$q3 = mysqli_fetch_array($q2);
$subject = $q3['short'];
$semester = $q3['semester'];
$branch = $q3['branch'];
$division = $q3['division'];

$q = "update records set display = 'visible' where branch = '$branch' && subject = '$subject' && division = '$division' && topic = '$topic' ";
mysqli_query($con, $q);

header('location:facultyactivity.php');

?>
