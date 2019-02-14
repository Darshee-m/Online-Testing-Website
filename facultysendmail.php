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
	else if(!isset($_SESSION["topic"])) {
		echo "<script type='text/javascript'>alert('You have not selected the topic. Please select topic first!'); 
		window.location='facultyactivity.php';
		</script>";
	}
}

//added restriction part


date_default_timezone_set("Asia/Kolkata");
//echo date_default_timezone_get();
$email = $_SESSION['email'];
$q1 = "select * from subjectselected where email = '$email' ";
$q2 = mysqli_query($con, $q1);
$q3 = mysqli_fetch_array($q2);
$branch = $q3['branch'];
$division = $q3['division'];
$semester = $q3['semester'];
$subject =$q3['short'];
	
$t1 = "select DAY(date) as day, MONTH(date) as month, MINUTE(start_time) as minute, HOUR(start_time) as hour, YEAR(date) as year, topic from test where division='$division' && branch='$branch' && subject = '$subject' && semester = '$semester' ";
$s1 = "select * from student where division='$division' && semester = '$semester' && branch='$branch' ";
$s2 = mysqli_query($con, $s1);
$t2 = mysqli_query($con, $t1);
$num = mysqli_num_rows($t2);
if($num == 0) {
	//echo "<h4>You have no upcoming tests. Sit back & relax!</h4>";
}
else {
	while($t3 = mysqli_fetch_array($t2)) {
		$i = 0;
		$topic = $t3['topic'];
		$day = $t3['day'];
		$month = $t3['month'];
		$year = $t3['year'];				
		$date = getDate();
		$qday = $date['mday'];
		$qmonth = $date['mon'];
		$qyear = $date['year'];
		$startmin = $t3['minute'];
		$starthour = $t3['hour'];
					
		if($year == $date['year']) {
			if($month == $date['mon']) {
				if(($day - $date['mday'] < 5) && ($day - $date['mday'] >= 0)) {
					$sub= "Welcome to Somaiya Quiz Centre";
					$message = "Hello,
						
									This is a reminder that on $qday / $qmonth / $qyear you have a test on $subject-$topic starting at $starthour:$startmin:00 . We hope you're prepared!

									If you have any questions, feedback or need a hand with anything feel free to email us anytime.

																Cheers and All the Best!,
																Somaiya Quiz Centre";
					
					while( $recepient = mysqli_fetch_array($s2)) {
						$to = $recepient['email'];
						$i++;
						$headers = "From : 07pulinshah@gmail.com";
						if( mail($to, $sub, $message, $headers)) {
							
						}
						else {
							echo "<script type='text/javascript'>alert('Mail sending failed after $i students'); 
							window.location='facultyactivity.php';
							</script>";
						}	
					}
					echo "<script type='text/javascript'>alert('Mail sent to $i students successfully'); 
					</script>";
				}
				else {
					echo "<script type='text/javascript'>alert('Cannot send mail as test is more than 5 days due'); 
					window.location='facultyactivity.php';
					</script>";
				}
			}
		}
	}
	echo "<script type='text/javascript'> 
	window.location='facultyactivity.php';
	</script>";
}
?>