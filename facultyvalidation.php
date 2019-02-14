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

mysqli_select_db($con, 'website');

//adding restriction part
if($_SESSION["usertype"] != "faculty") {
	echo "<script type='text/javascript'>alert('You are not authorized to this page!'); 
	window.location='logout.php';
	</script>";
}
else if(!isset($_POST["division"])) {
	echo "<script type='text/javascript'>alert('You have not selected division yet!'); 
	window.location='facultyhome.php';
	</script>";
}
//added restriction part


$email = $_SESSION["email"];
$division = $_POST["division"];
$q1 = "select * from temp where email = '$email' ";
$q2 = mysqli_query($con, $q1);
$q3 = mysqli_fetch_array($q2);
$branch = $q3['branch'];
$semester = $q3['semester'];
$short = $q3['short'];
$subject = $q3['subject'];

$q = "insert into subjectselected(short,name,email,branch,division,semester) values('$short','$subject','$email','$branch','$division','$semester') ";
mysqli_query($con, $q);

$q = "delete from temp where email = '$email' ";
mysqli_query($con, $q);

header('location:facultytopic.php');


?>


