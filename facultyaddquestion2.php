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
	else if(!isset($_SESSION["topic"])) {
		echo "<script type='text/javascript'>alert('You have not selected the topic. Please select topic first!'); 
		window.location='facultyactivity.php';
		</script>";
	}
	else if(!isset($_POST["correctans"])) {
		echo "<script type='text/javascript'>alert('You haven't entered the details necessary for adding question!'); 
		window.location='facultyaddquestion.php';
		</script>";
	}
}
//added restriction part

$topic = $_SESSION["topic"];
$email = $_SESSION["email"];
$q1 = "select * from subjectselected where email = '$email' ";
$q2 = mysqli_query($con, $q1);
$q3 = mysqli_fetch_array($q2);
$subject = $q3['short'];
$branch = $q3['branch'];
$division = $q3['division'];

$quest = $_POST["question"];
$quest_num = $_POST["number"];
$num_opt = $_POST["num_options"];
$option1 = $_POST["option1"];
$option2 = $_POST["option2"];
$marks = $_POST["marks"];
$answer = $_POST["correctans"];
$q = "insert into questions(number,branch,subject,topic,division,quests,marks) values('$quest_num','$branch','$subject','$topic','$division','$quest','$marks') ";
mysqli_query($con, $q);
$q = "insert into answers(number,branch,subject,topic,division,correct_answer) values('$quest_num','$branch','$subject','$topic','$division','$answer') ";
mysqli_query($con, $q);
if($num_opt == 2) {
	$q = "insert into options(number,option_number,branch,subject,topic,division,answers) values('$quest_num',1,'$branch','$subject','$topic','$division','$option1') "; 
	mysqli_query($con, $q);
	$q = "insert into options(number,option_number,branch,subject,topic,division,answers) values('$quest_num',2,'$branch','$subject','$topic','$division','$option2') ";
	mysqli_query($con, $q);
}
if($num_opt == 3) {
	$option3 = $_POST["option3"];
	$q = "insert into options(number,option_number,branch,subject,topic,division,answers) values('$quest_num','1','$branch','$subject','$topic','$division','$option1'),('$quest_num','2','$branch','$subject','$topic','$division','$option2'),('$quest_num','3','$branch','$subject','$topic','$division','$option3') ";
	mysqli_query($con, $q);
}
if($num_opt == 4) {
	$option3 = $_POST["option3"];
	$option4 = $_POST["option4"];
	$q = "insert into options(number,option_number,branch,subject,topic,division,answers) values('$quest_num','1','$branch','$subject','$topic','$division','$option1'),('$quest_num','2','$branch','$subject','$topic','$division','$option2'),('$quest_num','3','$branch','$subject','$topic','$division','$option3'),('$quest_num','4','$branch','$subject','$topic','$division','$option4') ";
	mysqli_query($con, $q);
}
$q1 = "select * from test where topic = '$topic' && branch = '$branch' && division = '$division' && subject = '$subject' ";
$q2 = mysqli_query($con, $q1);
$q3 = mysqli_fetch_array($q2);
$numq = $q3['number_questions'];
$numq = $numq + 1;
$q1 = "update test set number_questions = '$numq' where topic = '$topic' && subject = '$subject' && branch = '$branch' && division = '$division' ";
mysqli_query($con, $q1);
header('location:facultyaddquestion.php');
?>
