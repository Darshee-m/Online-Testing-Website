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
	else if(!(isset($_SESSION["topic"]) || (isset($_POST["topic"])))) {
		echo "<script type='text/javascript'>alert('You have not selected topic yet!'); 
		window.location='facultytopic.php';
		</script>";
	}
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Activity Page</title>
<link rel="stylesheet" type="text/css" href="bootstrap.css">
<link rel="stylesheet" type="text/css" href="fac_act.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>

<body style="background:linear-gradient(#8ACBFA,white 100%); height:1600px;">

	<nav class="navbar navbar-inverse" style="margin:0; font-size:16px;">
  			<div class="container-fluid">
    				<div class="navbar-header">
      					<a class="navbar-brand" href="#">Somaiya Quiz Centre</a>
    				</div>
    				<ul class="nav navbar-nav">
      					<li class="active"><a href="facultyactivity.php">Home</a></li>
						<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" > Change Topic/Subject <span class="caret"></span></a>
        					<ul class="dropdown-menu">
          						<li><a href="facultytopic.php">Change Topic</a></li>
          						<li><a href="facultyhome.php">Change Subject</a></li>
        					</ul>
      					</li>
      					<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" >Edit Quiz <span class="caret"></span></a>
        					<ul class="dropdown-menu">
          						<li><a href="facultypreviewquiz.php">Preview</a></li>
          						<li><a href="facultychangequizdetails.php">Change date/time</a></li>
          						<li><a href="facultyaddquestion.php">Add questions</a></li>
								<li><a href="facultyremovequestion.php">Remove questions</a></li>
								<li><a href="facultyremovequiz.php">Delete Quiz</a></li>
        					</ul>
      					</li>
      					<li><a href="facultyaddquiz.php">Create Quiz</a></li>
						<li><a href="facultysendmail.php">Send Quiz Reminder</a></li>
						<li><a href="facultydisplayperf.php">Display Performance</a></li>
						<li><a href="facultyviewperformance.php">View Performance</a></li>
    				</ul>
    				<ul class="nav navbar-nav navbar-right">
      					<li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    				</ul>
  			</div>
	</nav><br>
	
	<!--<div class="content_1">
    <div class="arrow_1">
      <div class="curve_1"></div>
      <div class="point_1"></div>
    </div>
  </div> -->
  
  <div class="things">
			  <div class="content">
				<div class="arrow">
				  <div class="curve"></div>
				  <div class="point"></div>
				  
				</div>
				 
			   </div>
			</div>
			
	<div class="things_2">		
	<div class="content_2">
    <div class="arrow_2">
      <div class="curve_2"></div>
      <div class="point_2"></div>
    </div>
  </div>
   </div>
	
  <div class="content">
    <div class="arrow">
      <div class="curve"></div>
      <div class="point"></div>
    </div>
  </div> 

  <div class="content_sl">
    <div class="arrow_sl">
      <div class="curve_sl"></div>
      <div class="point_sl"></div>
    </div>
  </div> 
  
  <div class="content_l">
    <div class="arrow_l">
      <div class="curve_l"></div>
      <div class="point_l"></div>
    </div>
  </div> 
  
  <div class="info one">
  Don't Want Your Students to miss out on your test ? Send them a reminder ! 
  </div>
  <div class="info two">
  Want To see how the students fared in your test ? Click here.. 
  </div>
  <div class="info three">
  You can now view the detailed performance of all the students just by clicking here.. 
  </div>
  <div class="info four">
  You can now change the Edit an already existing test just by clicking here.. 
  </div>
  
  
  
	
	<?php
		if(isset($_POST["topic"])) {
			$topic = $_POST["topic"];
			$_SESSION["topic"] = $topic;
			//echo $topic;
		}
	?>


<br><div style="text-align:center;" class="m-auto d-block">
	<a href="logout.php" class="btn btn-primary "> LOGOUT </a>
	</div>
</body>
</html> 

