<?php

session_start();
/*if(!isset($_SESSION['username'])){
header('location:login.html');
}*/
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "website";

$con = mysqli_connect($servername, $username, $password, $dbname);

if($con == NULL){
	echo" connection failed";
}

mysqli_select_db($con, 'website');

$email = $_SESSION['email'];
$q1 = "select * from student where email = '$email' ";
$q2 = mysqli_query($con, $q1);
$q3 = mysqli_fetch_array($q2);
$division = $q3['division'];
$branch = $q3['branch'];
$semester = $q3['semester'];
$topic = $_POST["topic"];

$r1 = "select * from subject where branch = '$branch' && semester = '$semester' ";
$r2 = mysqli_query($con, $r1);
//$r3 = mysqli_fetch_array($r2);

$s1 = "select * from test where topic = '$topic' && branch = '$branch' && division = '$division' ";
$s2 = mysqli_query($con, $s1);
//$s3 = mysqli_fetch_array($s2);

while($s3 = mysqli_fetch_array($s2)) {
	while($r3 = mysqli_fetch_array($r2)) {
		if($s3['subject'] == $r3['short']) {
			$subject = $s3['subject'];
		}
	}
}

$e1 = "Select * from records where email = '$email' && subject = '$subject' && topic = '$topic' ";
$e2 = mysqli_query($con, $e1);
$e3 = mysqli_num_rows($e2);
if($e3 !=0) {
	//error
}
else {
$q1 = "select DAY(date) as day, MONTH(date) as month, YEAR(date) as year, MINUTE(start_time) as minstart, MINUTE(end_time) as minend, HOUR(start_time) as hourstart, HOUR(end_time) as hourend from test where topic = '$topic' && branch = '$branch' && division = '$division' && subject = '$subject' ";

$q2 = mysqli_query($con, $q1);
$q3 = mysqli_fetch_array($q2);
$q4 = mysqli_num_rows($q2);
echo $q4;

date_default_timezone_set("Asia/Kolkata");
$date = getDate();
echo $date['mday'];
$day = $q3['day'];
$month = $q3['month'];
$year = $q3['year'];
$minutes_start = $q3['minstart'];
$minutes_end = $q3['minend'];
$hours_start = $q3['hourstart'];
$hours_end = $q3['hourend'];

if($year == $date['year']) {
	if($month == $date['mon']) {	
		if($day == $date['mday']) {
			$timex = localtime();
			$minutes_now = $timex[1];
			$hours_now = $timex[2];
			if($hours_start == $hours_now) {
				if($minutes_now >= $minutes_start) {
					$q = "insert into records(email, branch, subject, topic, division) values('$email','$branch','$subject','$topic','$division') ";
					mysqli_query($con, $q);
					$_SESSION["topic"] = $topic;
					$_SESSION["subject"] = $subject; 
					$r1 = "select * from test where branch = '$branch' && topic = '$topic' && semester = '$semester' && subject = '$subject' && division = '$division' ";
					$r2 = mysqli_query($con, $r1);
					$r3 = mysqli_fetch_array($r2);
					$timelimit = $r3['timelimit'];
					$timelimit = $timelimit * 60;
					?>
					<script>
					var x = <?php echo $timelimit; ?>;
					x = parseInt(x);
					localStorage.removeItem("countera");
					localStorage.setItem("countera", x);
					window.location = 'Question.php';
					</script>
					<?php
					//header('location:Question.php');
				}
				else {
					echo "<script type='text/javascript'>alert('Quiz Not Open (Reason : Still some minutes left to open)'); 
					window.location='studenthome.php';
					</script>";
				}
			}
			else {
				if($hours_start < $hours_now) {
					if($hours_end > $hours_now) {
						$q = "insert into records(email, branch, subject, topic, division) values('$email','$branch','$subject','$topic','$division') ";
						mysqli_query($con, $q);
						$_SESSION["topic"] = $topic;
						$_SESSION["subject"] = $subject;
						$r1 = "select * from test where branch = '$branch' && topic = '$topic' && semester = '$semester' && subject = '$subject' && division = '$division' ";
						$r2 = mysqli_query($con, $r1);
						$r3 = mysqli_fetch_array($r2);
						$timelimit = $r3['timelimit'];
						$timelimit = $timelimit * 60;
						?>
						<script>
						var x = <?php echo $timelimit; ?>;
						x = parseInt(x);
						//alert(x);
						localStorage.removeItem("countera");
						localStorage.setItem("countera", x);
						var y = localStorage.getItem("countera");
						//alert(y);
						window.location = 'Question.php';
						</script>
						<?php
						//header('location:Question.php');
					}
					else {
						if($hours_end == $hours_now) {
							if($minutes_now < $minutes_end) {
								$q = "insert into records(email, branch, subject, topic, division) values('$email','$branch','$subject','$topic','$division') ";
								mysqli_query($con, $q);
								$_SESSION["topic"] = $topic;
								$_SESSION["subject"] = $subject;
								$r1 = "select * from test where branch = '$branch' && topic = '$topic' && semester = '$semester' && subject = '$subject' && division = '$division' ";
								$r2 = mysqli_query($con, $r1);
								$r3 = mysqli_fetch_array($r2);
								$timelimit = $r3['timelimit'];
								$timelimit = $timelimit * 60;
								?>
								<script>
								var x = <?php echo $timelimit; ?>;
								x = parseInt(x);
								localStorage.removeItem("countera");
								localStorage.setItem("countera", x);
								window.location = 'Question.php';
								</script>
								<?php
								//header('location:Question.php');
							}
							else {
								echo "<script type='text/javascript'>alert('Quiz Closed (Reason : Current minutes are past ending minutes)'); 
								window.location='studenthome.php';
								</script>";
							}
						}
					}
				}
				else {
					echo "<script type='text/javascript'>alert('Quiz Not Open (Reason : Still some hours to go before quiz opens)'); 
					window.location='studenthome.php';
					</script>";
				}
			}
		}
		else {
			echo "<script type='text/javascript'>alert('Quiz Not Open (Reason : Date does not match)'); 
			window.location='studenthome.php';
			</script>";
		}
	}
	else {
		echo "<script type='text/javascript'>alert('Quiz Not Open (Reason : Month does not match)'); 
		window.location='studenthome.php';
		</script>";
	}
}
else {
	echo "<script type='text/javascript'>alert('Quiz Not Open (Reason : Year does not match)'); 
	window.location='studenthome.php';
	</script>";
}

}

?>
