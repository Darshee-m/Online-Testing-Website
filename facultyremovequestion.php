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
}
//added

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$topic = $_SESSION['topic'];
	$email = $_SESSION["email"];
	$number = $_POST['number'];
	$r1 = "select * from subjectselected where email = '$email' ";
	$r2 = mysqli_query($con, $r1);
	$r3 = mysqli_fetch_array($r2);
	$subject = $r3['short'];
	$branch = $r3['branch'];
	$division = $r3['division'];
	$semester = $r3['semester'];
	
	$q1 = "select * from test where topic='$topic' && subject = '$subject' && branch = '$branch' && division = '$division' && semester = '$semester' ";
	$q2 = mysqli_query($con, $q1);
	$q3 = mysqli_fetch_array($q2);
	
	$num = mysqli_num_rows($q2);
	
	if($num == 1) {
		$no = $q3['number_questions'];
		$no1 = $no - 1;
		$q4 = "update test set number_questions='$no1' where topic='$topic' && subject = '$subject' && branch = '$branch' && division = '$division' && semester = '$semester' ";
		$result = mysqli_query($con, $q4);
		$q4 = "delete from questions where topic='$topic' && branch='$branch' && subject='$subject' && division='$division' && number='$number'";
		$result = mysqli_query($con, $q4);
		$q4 = "select * from questions where topic='$topic' && branch='$branch' && subject='$subject' && division='$division' && number>'$number'";
		$result = mysqli_query($con, $q4);
		while($rows = mysqli_fetch_array($result)) {
			$n = $rows['number'];
			$n1 = $n - 1;
			$q4 = "update questions set number='$n1' where number='$n' && branch = '$branch' && subject = '$subject' && topic = '$topic' && division = '$division' ";
			mysqli_query($con,$q4);
		}

		$q4 = "delete from options where topic='$topic' && branch='$branch' && subject='$subject' && division='$division' && number='$number'";
		$result = mysqli_query($con,$q4);
		$q4 = "select * from options where topic='$topic' && branch='$branch' && subject='$subject' && division='$division' && number>'$number'";
		$result = mysqli_query($con,$q4);
		while($rows = mysqli_fetch_array($result)) {
			$n = $rows['number'];
			$n1 = $n - 1;
			$q4 = "update options set number='$n1' where number='$n' && branch = '$branch' && subject = '$subject' && topic = '$topic' && division = '$division' ";
			mysqli_query($con,$q4);
		}

		$q4 = "delete from answers where topic='$topic' && branch='$branch' && subject='$subject' && division='$division' && number='$number'";
		$result = mysqli_query($con,$q4);
		$q4 = "select * from answers where topic='$topic' && branch='$branch' && subject='$subject' && division='$division' && number>'$number' ";
		$result = mysqli_query($con,$q4);
		while($rows = mysqli_fetch_array($result)) {
			$n = $rows['number'];
			$n1 = $n - 1;
			$q4 = "update answers set number='$n1' where number='$n' && branch = '$branch' && subject = '$subject' && topic = '$topic' && division = '$division' ";
			mysqli_query($con,$q4);
		}
			

		/*echo "<script type='text/javascript'>alert('Question deleted.'); 
			window.location='facultyactivity.php';
			</script>";
		}else {
			echo "<script type='text/javascript'>alert('You cannot delete question of any other subject.'); 
			window.location='facultyremovequiz.php';
			</script>";
		}*/
	}/*else {
		echo "<script type='text/javascript'>alert('There are no tests(questions) on this topic.'); 
		window.location='facultyremovequiz.php';
		</script>";
	}*/ 
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Remove Question</title>
<link rel="stylesheet" type="text/css" href="bootstrap.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
* {
    box-sizing: border-box;
}

body {
    margin: 0;
    font-family: Arial;
}

/* The grid: Three equal columns that floats next to each other */
.column {
    float: left;
    width: 50%;
    padding: 50px;
    text-align: center;
    font-size: 30px;
    cursor: pointer;
    color: black;
    border-style: solid;
    border-width: 1px;
}

.rules {
	border:1px solid #888;
	box-shadow: 2px 2px #aaa;
	width:75%;
	margin:2px auto;
}

label {
    padding: 12px 12px 12px 0;
    display: inline-block;
}

.containerTab {
    text-align: center;
    padding: 20px;
    color: black;
}

.col-25 {
    float: left;
    margin-top: 6px;
}

.col-75 {
    float: left;
    margin-top: 6px;
}

/* Clear floats after the columns */
.row:after {
    content: "";
    display: table;
    clear: both;
}

/* Closable button inside the container tab */
.closebtn {
    float: right;
    color: black;
    font-size: 35px;
    cursor: pointer;
}
</style>
</head>

<body style="background:linear-gradient(#8ACBFA,white 100%); height:1000px;">
	<nav class="navbar navbar-inverse" style="margin:0; font-size:20px;">
  			<div class="container-fluid">
    				<div class="navbar-header">
      					<a class="navbar-brand" href="#">Somaiya Quiz Centre</a>
    				</div>
    				<ul class="nav navbar-nav">
      					<li><a href="facultyactivity.php">Home</a></li>
						<li><a href="facultytopic.php">Change Topic</a></li>
						<li><a href="facultyhome.php">Change Subject</a></li>
      					<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" >Edit Quiz 						<span class="caret"></span></a>
        					<ul class="dropdown-menu">
          						<li><a href="facultypreviewquiz.php">Preview</a></li>
          						<li><a href="facultychangequizdetails.php">Change date/time</a></li>
          						<li><a href="facultyaddquestion.php">Add questions</a></li>
								<li class="active">Remove questions</li>
        					</ul>
      					</li>
      					
    				</ul>
    				<ul class="nav navbar-nav navbar-right">
      					<li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    				</ul>
  			</div>
	</nav><br>


	<div align="center" style="margin:40px;">
	<h2> To Remove Question </h2>

	<div>
		<iframe src="facultypreviewquiz.php" height="500" width="900"></iframe>
	</div>
	
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
		<br><h4>Enter Question Number &nbsp &nbsp &nbsp</h4><input type="number" name="number" max="<?php echo $no;?>" min=1 placeholder="Type number of the question"><br><br>
		<input type="submit" value="Submit" onclick="submit();" class="btn btn-success m-auto d-block">
	</form>	
	</div>

	<div style="text-align:center;" class="m-auto d-block">
		<a href="logout.php" class="btn btn-primary "> LOGOUT </a>
	</div>
</body>
</html> 

