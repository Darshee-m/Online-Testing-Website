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

//adding restriction part
if($_SESSION["usertype"] != "faculty") {
	echo "<script type='text/javascript'>alert('You are not authorized to this page!'); 
	window.location='logout.php';
	</script>";
}
//added restriction part

//deleting all data
$email = $_SESSION["email"];
$q1 = "delete from subjectselected where email = '$email' ";
$q2 = "delete from temp where email = '$email' ";
mysqli_query($con, $q1);
mysqli_query($con, $q2);


?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Faculty Home</title>
		<link rel="stylesheet" type="text/css" href="bootstrap.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<style type="text/css">
		
		
	
		.rules
		{
			border:1px solid #888;
			box-shadow: 2px 2px #aaa;
			width:80%;
			margin:2px auto;
		}

		#imagerule
		{
			float:left;
		}

		form
		{
			margin: 40px 450px;
		}

		hr
		{
			
		
		}

		#container {height: 100%; font-size: 0;font-size: 30px;}
		#sub1, #sub2, #sub3{display: inline-block; *display: inline; zoom: 1;margin:2px 300px; vertical-align: top; font-size: 12px;}
		
		#sub1{width: 30%;height:400px; border:1px solid black; margin:1px 2px; padding:4px;}
		#sub2{width: 30%;height:400px; border:1px solid black; margin:1px 2px; padding:4px;}
		#sub3{width: 30%;height:400px; border:1px solid black; margin:1px 2px; padding:4px;}
		

		#sub1:hover{box-shadow: 2px 2px 2px 2px #888;}
		#sub2:hover{box-shadow: 2px 2px 2px 2px #888;}
		#sub3:hover{box-shadow: 2px 2px 2px 2px #888;}
		

		p
		{
			font-size: 16px;
		}
		</style>
	</head>	
	
<body style="background:linear-gradient(#8ACBFA,white 100%); height:100%">
	<nav class="navbar navbar-inverse" style="margin:0; font-size:17px;">
  			<div class="container-fluid">
    				<div class="navbar-header">
      					<a class="navbar-brand" href="#">Somaiya Quiz Centre</a>
    				</div>
    				<ul class="nav navbar-nav">
      					<li class="active"><a href="facultyhome.php">Home</a></li>
      					<li><a href="facultyhome.php">Change Subject</a></li>
					</ul>
				<ul class="nav navbar-nav navbar-right">
      					<li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    				</ul>
  			</div>
		</nav> <br>

	<?php 
		$email=$_SESSION['email'];
		$q = "select * from faculty where email='$email'";
		$result = mysqli_query($con, $q);	
		$row = mysqli_fetch_array($result);
		$name = $row['name'];
	?>	

	<br><h1 style="text-align:center;">Welcome <?php echo "$name";?></h1><br>
		<div class="rules" style="margin-left:200px; border:1px solid #888;
			box-shadow: 2px 2px #aaa; margin-right:180px; background:#71C3F9;">
			<div>
			<img id="imagerule" src="images/teacher.jpg">
			</div>
			<div style="margin-left:320px;"><h4>Rules and Regulations Regarding Conduction Of The Test</h4>
			<ol>
				<li>Each faculty can post questions for any one subject only.</li>
				<li>Each faculty can submit a maximum of 10 questions per test.</li>
				<li>Every question must be given four options.</li>
				<li>The questions should be such that they have only one correct answer.</li>
				<li>The correct answer for each question must be given by the faculty.</li>
				<li>Marking Scheme for each question must be decided by the faculty.</li>
				<li>The faculty must specify the duration of the test.</li>
				<li>The faculty can view the results of all the students who have attempted the test.</li>
			</ol>	
			</div>
		</div>	
		<form action="facultyhome2.php" method="POST">
			Select semester :- <br>
			<select name="semester" class="sem_change" id="sem_id">
				<?php 
					$email = $_SESSION["email"];
					$q1 = "select * from faculty where email = '$email' ";
					$q2 = mysqli_query($con, $q1);
					while($q3 = mysqli_fetch_array($q2)) {
				?>
				<option value="<?php echo $q3['semester']; ?>"><?php echo $q3['semester']; ?></option>
					<?php } ?>
			</select>
			<br>
			<input type="submit" name="sem_submit" class="login login-submit" value="Submit" id="sem_submit">
		</form>
		
		<hr>

		<h1 align="center"> The Faculty Can Now </h1>
		<div id="container" style="height:100%; width:100%" >


		<div align="center">
        	<div id="sub1" style="background:#66FFFF;">
            	<h2 align="center">Create Tests</h2>
            	<img src="images/fachome2.png">
            	<p>Create Tests with set Questions or have Questions selected at random from your Question bank.</p>
        	</div>

        	<div id="sub2" style="background:#66FFFF;">
            	<h2 align="center">View Results</h2>
            	<img src="images/fachome1.png">
            	<p>Results are graded instantly. Provide individual Question feedback and overall Test feedback in real time to Test takers.</p>
        	</div>

        	<div id="sub3" style="background:#66FFFF;">
            	<h2 align="center">Analyze Statistics</h2>
            	<img src="images/fachome3.png">
            	<p>Break down individual and Group performance by Test, Questions with our Quiz maker tool.</p>
        	</div>
    	</div>
	</body>	
</html>
