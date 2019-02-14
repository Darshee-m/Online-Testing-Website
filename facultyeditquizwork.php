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
else {
	$email = $_SESSION["email"];
	$q1 = "select * from subjectselected where email = '$email' ";
	$q2 = mysqli_query($con, $q1);
	$q4 = mysqli_num_rows($q2);
	if($q4 == 0) {
		echo "<script type='text/javascript'>alert('You have not selected subject and/or division yet!'); 
		window.location='facultyhome.php';
		</script>";
	}
	else if((!isset($_SESSION["topic"])) && ($_SESSION["editquizoption"] != "addquiz")) {
		echo "<script type='text/javascript'>alert('You have not selected the topic. Please select topic first!'); 
		window.location='facultyactivity.php';
		</script>";
	}
	else if(!isset($_SESSION["editquizoption"])) {
		echo "<script type='text/javascript'>alert('You have selected which option of the quiz is to be edited'); 
		window.location='facultyactivity.php';
		</script>";
	}
}

//added restriction part



$work = $_SESSION["editquizoption"];
$email = $_SESSION["email"];


if($work == "changedate") {
	$topic = $_SESSION["topic"];
	$q1 = "select * from subjectselected where email = '$email' ";
	$q2 = mysqli_query($con, $q1);
	$q3 = mysqli_fetch_array($q2);
	$branch = $q3['branch'];
	$division = $q3['division'];
	$subject = $q3['short'];
	$day = $_POST["date"];
	$month = $_POST["month"];
	$year = $_POST["year"];
	$q = "update test set date = '$year-$month-$day' where topic = '$topic' && subject = '$subject' && branch = '$branch' && division = '$division' ";
	mysqli_query($con, $q);
}
if($work == "changestarttime") {
	$topic = $_SESSION["topic"];
	$q1 = "select * from subjectselected where email = '$email' ";
	$q2 = mysqli_query($con, $q1);
	$q3 = mysqli_fetch_array($q2);
	$branch = $q3['branch'];
	$division = $q3['division'];
	$subject = $q3['short'];
	$minute = $_POST["startminute"];
	$hour = $_POST["starthour"];
	$sec = 0;
	$q = "update test set start_time = '$hour:$minute:$sec' where topic = '$topic' && subject = '$subject' && branch = '$branch' && division = '$division' ";
	mysqli_query($con, $q);
}
	
if($work == "changeendtime") {
	$topic = $_SESSION["topic"];
	$q1 = "select * from subjectselected where email = '$email' ";
	$q2 = mysqli_query($con, $q1);
	$q3 = mysqli_fetch_array($q2);
	$branch = $q3['branch'];
	$division = $q3['division'];
	$subject = $q3['short'];
	$minute = $_POST["endminute"];
	$hour = $_POST["endhour"];
	$sec = 0;
	$q = "update test set end_time = '$hour:$minute:$sec' where topic = '$topic' && subject = '$subject' && branch = '$branch' && division = '$division' ";
	mysqli_query($con, $q);
}

if($work == "changetopic") {
	$topic = $_SESSION["topic"];
	$q1 = "select * from subjectselected where email = '$email' ";
	$q2 = mysqli_query($con, $q1);
	$q3 = mysqli_fetch_array($q2);
	$branch = $q3['branch'];
	$division = $q3['division'];
	$subject = $q3['short'];
	$newtopic =$_POST["topic"];
	$q = "update test set topic = '$newtopic' where topic = '$topic' && subject = '$subject' && branch = '$branch' && division = '$division' ";
	mysqli_query($con, $q);
	$q = "update records set topic = '$newtopic' where topic = '$topic' && subject = '$subject' && branch = '$branch' && division = '$division' ";
	mysqli_query($con, $q);
	$q = "update questions set topic = '$newtopic' where topic = '$topic' && subject = '$subject' && branch = '$branch' && division = '$division' ";
	mysqli_query($con, $q);
	$q = "update options set topic = '$newtopic' where topic = '$topic' && subject = '$subject' && branch = '$branch' && division = '$division' ";
	mysqli_query($con, $q);
	$q = "update answers set topic = '$newtopic' where topic = '$topic' && subject = '$subject' && branch = '$branch' && division = '$division' ";
	mysqli_query($con, $q);
	}
	
if($work == "changetime") {
	$topic = $_SESSION["topic"];
	$q1 = "select * from subjectselected where email = '$email' ";
	$q2 = mysqli_query($con, $q1);
	$q3 = mysqli_fetch_array($q2);
	$branch = $q3['branch'];
	$division = $q3['division'];
	$subject = $q3['short'];
	$time = $_POST["time"];
	$q = "update test set timelimit = '$time' where topic = '$topic' && subject = '$subject' && branch = '$branch' && division = '$division' ";
	mysqli_query($con, $q);
}

if($work == "addquiz") {
	$q1 = "select * from subjectselected where email = '$email' ";
	$q2 = mysqli_query($con, $q1);
	$q3 = mysqli_fetch_array($q2);
	$branch = $q3['branch'];
	$division = $q3['division'];
	$subject = $q3['short'];
	$semester = $q3['semester'];
	$topic = $_POST["topic"];
	$timer = $_POST["time"];
	$day = $_POST["date"];
	$month = $_POST["month"];
	$year = $_POST["year"];
	$minute_start = $_POST["startminute"];
 	$minute_end = $_POST["endminute"];
	$hour_start = $_POST["starthour"];
	$hour_end = $_POST["endhour"];
	$sec = 0;
	$q = "insert into test(topic,subject,branch,division,semester,timelimit,date,start_time,end_time) values('$topic','$subject','$branch','$division','$semester','$timer','$year-$month-$day','$hour_start:$minute_start:$sec','$hour_end:$minute_end:$sec') ";
	mysqli_query($con, $q);
}
	
	
header('location:facultyactivity.php');
	
?>
