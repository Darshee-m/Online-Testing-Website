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

?>



<!DOCTYPE html>
<html>
<head>
<title>Preview Quiz</title>
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

	<nav class="navbar navbar-inverse" style="margin:0; font-size:20px;">
  			<div class="container-fluid">
    				<div class="navbar-header">
      					<a class="navbar-brand" href="#">Somaiya Quiz Centre</a>
    				</div>
    				<ul class="nav navbar-nav">
      					<li><a href="facultyactivity.php">Home</a></li>
						<li><a href="facultytopic.php">Change topic</a></li>
						<li><a href="facultyhome.php">Change subject</a></li>
      					<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" >View Performance<span class="caret"></span></a>
        					<ul class="dropdown-menu">
          						<li class="active">View Performance</li>
								<li><a href="facultyviewperformancedetailed.php">View detailed performance</a></li>
        					</ul>
      					</li>
						<li><a href="export.php">Export Results</a></li>
						<li><a href="facultyremovequiz.php">Delete Quiz</a></li>
    				</ul>
    				<ul class="nav navbar-nav navbar-right">
      					<li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    				</ul>
  			</div>
	</nav><br>

	
      <?php
      
      $email = $_SESSION["email"];
	  $topic = $_SESSION["topic"];
	  $q1 = "select * from subjectselected where email = '$email' ";
	  $q2 = mysqli_query($con, $q1);
	  $q3 = mysqli_fetch_array($q2);
	  $branch = $q3['branch'];
	  $division = $q3['division'];
	  $subject = $q3['short'];
	  $q1 = "select * from records r INNER JOIN student s on r.email = s.email && r.branch = '$branch' && r.division = '$division' && r.subject = '$subject' && r.topic = '$topic' ";
	  $q2 = mysqli_query($con, $q1);
	  $num = mysqli_num_rows($q2);
	  echo $num;
	 //just took 3 columns below for testing,if needed we can add more.. 
	  ?>
	  
      <table border="2" style= "background-color: #84ed86; color: #761a9b; margin: 0 auto;" >
      <thead>
      
		<tr>
          <th>Email-ID</th>
		  <th>Roll Number</th>
          <th>DIVISION</th>
          <th>MARKS</th>
          
        </tr>
      </thead>
      <tbody>
        <?php
          while($q3 = mysqli_fetch_array($q2)) {
            echo
            "<tr>
              <td>{$q3['email']}</td>
			  <td>{$q3['rollnumber']}</td>
              <td>{$q3['division']}</td>
              <td>{$q3['marks']}</td>
            </tr>\n";
          }
        ?>
      </tbody>
    </table>

	<div align="center">
	<form action="facultyviewperformancedetailed.php" method="POST">
		<input type="submit" value="Show Detailed Result" onclick="submit();" class="btn btn-success m-auto d-block"></h4>
	</form></div><br>
     <?php mysqli_close($con); ?>
    </body>
    </html>