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

//unset the topic session variable
unset($_SESSION["topic"]);

?>

<!DOCTYPE html>
<html>
<head>
<title>Activity Page</title>
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

<body style="background:linear-gradient(#8ACBFA,white 100%); height:1600px;">

	<nav class="navbar navbar-inverse" style="margin:0; font-size:16px;">
  			<div class="container-fluid">
    				<div class="navbar-header">
      					<a class="navbar-brand" href="#">Somaiya Quiz Centre</a>
    				</div>
    				<ul class="nav navbar-nav">
      					<li class="active"><a href="facultyactivity.php">Home</a></li>
      					<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" >Edit Quiz <span class="caret"></span></a>
        					<ul class="dropdown-menu">
          						<li><a href="facultypreviewquiz.php">Preview</a></li>
          						<li><a href="facultychangequizdetails.php">Change date/time</a></li>
          						<li><a href="facultyaddquestion.php">Add questions</a></li>
								<li><a href="facultyremovequestion.php">Remove questions</a></li>
        					</ul>
      					</li>
      					<li><a href="facultyaddquiz.php">Create Quiz</a></li>
						<li><a href="facultyremovequiz.php">Delete Quiz</a></li>
						<li><a href="facultysendmail.php">Send Quiz Reminder</a></li>
						<li><a href="export.php">Export Records</a></li>
						<li><a href="facultyviewperformance.php">View Students Performance</a></li>
    				</ul>
    				<ul class="nav navbar-nav navbar-right">
      					<li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    				</ul>
  			</div>
	</nav><br>
	
	<?php
		$email = $_SESSION["email"];
		$q1 = "select * from subjectselected where email = '$email' ";
		$q2 = mysqli_query($con, $q1);
		$q3 = mysqli_fetch_array($q2);
		$branch = $q3['branch'];
		$division = $q3['division'];
		$subject = $q3['short'];
		$q1 = "select * from test where subject = '$subject' && branch = '$branch' && division = '$division' ";
		$q2 = mysqli_query($con, $q1);
		
	?>

	<div align="center">
	<form action="facultyactivity.php" method="POST">
		<h4>Select topic &nbsp &nbsp &nbsp &nbsp
			<select name="topic">
				<?php while($q3 = mysqli_fetch_array($q2)) { ?>
				<option value="<?php echo $q3['topic']; ?>"><?php echo $q3['topic']; ?></option>
				<?php } ?>
			</select><br><br>
		<input type="submit" value="Submit" onclick="submit();" class="btn btn-success m-auto d-block"></h4>
	</form></div><br>	


<br><div style="text-align:center;" class="m-auto d-block">
	<a href="logout.php" class="btn btn-primary "> LOGOUT </a>
	</div>
</body>
</html> 

