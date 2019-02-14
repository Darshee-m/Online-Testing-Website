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
}else{
	echo " connection"; 
}

mysqli_select_db($con, 'website');



if($_SESSION["admin_work"] == "add_account") {
	if($_SESSION["usertype2"] == "faculty") {
		$subject = $_POST["subject"];
		$email = $_SESSION["email2"];
		$division = $_POST["division"];
		$branch = $_SESSION["branch2"];
		$semester = $_SESSION["semester2"];
		$r1 = "select * from faculty where email = '$email' ";
		$r2 = mysqli_query($con, $r1);
		$r3 = mysqli_num_rows($r2);
		if($r3 == 0) {
			$q1 = "insert into faculty(email,subject,semester,branch,division) values('$email','$subject','$semester','$branch','$division') ";
			mysqli_query($con, $q1);
			header('location:adminaddacc4.php');
		}
		else {
			$r4 = mysqli_fetch_array($r2);
			$password = $r4['password'];
			$name = $r4['name'];
			$q1 = "insert into faculty(name,email,password,subject,semester,branch,division) values('$name','$email','$password','$subject','$semester','$branch','$division') ";
			mysqli_query($con, $q1);
			header('location:adminaddacc4.php');
		}
	}
	else {
		header('location:adminhome.php');
	}
}
else {
	if($_SESSION["admin_work"] == "add_subject") {
		$subject_name = $_POST["subject_name"];
		$subject_short = $_POST["subject_short"];
		$semester = $_POST["semester"];
		$branch = $_POST["branch"];
		$q = "insert into subject(name,short,branch,semester) values('$subject_name','$subject_short','$branch','$semester') ";
		mysqli_query($con, $q);
		header('location:adminhome.php');
	}
	else {
		if($_SESSION["admin_work"] == "remove_account") {
			$email = $_POST["email"];
			$q1 = "select * from student where email = '$email' ";
			$q2 = "select * from faculty where email = '$email' ";
			$r1 = mysqli_query($con, $q1);
			$r2 = mysqli_query($con, $q2);
			$num1 = mysqli_num_rows($r1);
			$num2 = mysqli_num_rows($r2);
			if($num1 == 1) {
				$usertype = "student";
			}
			else {
				if($num2 == 1) {
					$usertype = "faculty";
				}
				else {
					//display error message;
				}
			}
			$q1 = "delete from $usertype where email = '$email' ";
			mysqli_query($con, $q1);
			if($usertype == "student") {
				$q = "delete from records where email = '$email' ";
				mysqli_query($con, $q);
			}
			header('location:adminhome.php');
		}
		else {
			if($_SESSION["admin_work"] == "remove_subject") {
				$branch = $_SESSION["branch2"];
				$semester = $_SESSION["semester2"];
				$subject_short = $_POST["subject"];
				$q = "delete from subject where branch = '$branch' && semester = '$semester' && short = '$subject_short' ";
				mysqli_query($con, $q);
				$q = "delete from subjectselected where branch = '$branch' && semester = '$semester' && short = '$subject_short' ";
				mysqli_query($con, $q);
				$q = "delete from test where branch = '$branch' && subject = '$subject_short' ";
				mysqli_query($con, $q);
				$q = "delete from questions where branch = '$branch' && subject = '$subject_short' ";
				mysqli_query($con, $q);
				$q = "delete from answers where branch = '$branch' && subject = '$subject_short' ";
				mysqli_query($con, $q);
				$q = "delete from options where branch = '$branch' && subject = '$subject_short' ";
				mysqli_query($con, $q);
				echo "<script type='text/javascript'>alert('Subject deleted');
				window.location = 'adminhome.php';
				</script>";
				//header('location:adminhome.php');
			}
			else {
				if($_SESSION["admin_work"] == "set_reopen") {
					$date = $_POST["date"];
					$month = $_POST["month"];
					$year = $_POST["year"];
					$q1 = "select * from reopen" ;
					$q2 = mysqli_query($con, $q1);
					$q3 = mysqli_num_rows($q2);
					if($q3 == 0) {
						if($month >= 6) {
							$semester = "odd";
						}
						else {
							$semester = "even";
						}
						$q = "insert into reopen(date,month,year,semester) values('$date','$month','$year','$semester') ";
						mysqli_query($con, $q);
					}
					else {
						if($month >= 6) {
							$semester = "odd";
						}
						else {
							$semester = "even";
						}
						$q4 = mysqli_fetch_array($q2);
						$tempyear = $q4['year'];
						$q = "update reopen set date = '$date' where year = '$tempyear' ";
						mysqli_query($con, $q);
						$q = "update reopen set month = '$month' where year = '$tempyear' ";
						mysqli_query($con, $q);
						$q = "update reopen set year = '$year' where date = '$date' ";
						mysqli_query($con, $q);
					}
					
					header('location:adminhome.php');
				}
				else {
					if($_SESSION["admin_work"] == "remove_faculty_subject") {
						$email = $_SESSION["email2"];
						$branch = $_SESSION["branch2"];
						$subjectdiv = $_POST["subjectremove"];
						$subject = substr($subjectdiv, -15, -2);
						$division = substr($subjectdiv, -1, 2);
						//echo $subject;
						//echo $div;
						$q1 = "delete from faculty where email = '$email' && branch = '$branch' && subject = '$subject' && division = '$division' ";
						mysqli_query($con, $q1);
						header('location:adminhome.php');
					}
				}
			}
		}
	}
}
unset($_SESSION["admin_work"]);


?>
