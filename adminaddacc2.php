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
}
mysqli_select_db($con, 'website');



if(isset($_POST["email"])) {
	$usertype = $_POST["usertype"];
	$email = $_POST["email"];
	$branch = $_POST["branch"];
}
else {
	$usertype = $_SESSION["usertype2"];
	$email = $_SESSION["email2"];
	$branch = $_SESSION["branch2"];
}

if($usertype == "student") {
	$division = $_POST["division"];
	$q = "insert into student(email,branch,division) values('$email','$branch','$division') ";
	mysqli_query($con, $q);
	header('location:adminhome.php');
}
else {
	$_SESSION["email2"] = $email;
	$_SESSION["usertype2"] = $usertype;
	$_SESSION["branch2"] = $branch;
}

$admin_work = "add_account";
$_SESSION["admin_work"] = $admin_work;

?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Add faculty or student</title>
		<link rel="stylesheet" type="text/css" href="bootstrap.css">
		<link rel='stylesheet' href='http://codepen.io/assets/libs/fullpage/jquery-ui.css'>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   		<link rel="stylesheet" href="css/loginstyle.css" media="screen" type="text/css" />
		<link rel="stylesheet" href="css/adminstyle.css" type="text/css"/>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>	
	</head>	

	<body>
		<div id="header">
        		<div class="navbar-header">
      					<a class="navbar-brand" href="#" style="font-size:30px;">Admin Panel</a>
    			</div>
			<ul class="nav navbar-nav navbar-right" style="font-size:20px; margin-right:10px;">
      					<li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    			</ul>
    		</div>


    		<div id="container">

        		<div class="sidebar">
            		<ul id="nav" style="font-size:18px;">
               			<li>
                    			<a href="adminhome.php">Home</a>
                		</li>
                		<li>
                    			<a class="selected" href="#">Add Account</a>
                		</li>
                		<li>
                    			<a href="adminremoveacc.php">Remove Account</a>
                		</li>
				<li>
                    			<a href="adminaddsubject.php">Add Subject</a>
                		</li>
				<li>
                    			<a href="adminremovesubject.php">Remove Subject</a>
                		</li>
				<li>
                    			<a href="adminsetreopendate.php">Set Re-open date</a>
                		</li>
            		</ul>

        	</div>

        	<div class="content">
			
            		<h2 style="margin-left:40px;">Add Account to Somaiya KJSCE Group</h2>
			<form action="adminaddacc3.php" method="POST" style="margin-left:40px; font-size:18px;"><br>
		
				<div id="semester">
					Semester &nbsp &nbsp &nbsp &nbsp
					<select name="semester">
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
					</select><br><br>
				</div>
				<input type="submit" name="login" class="login login-submit" value="Submit">
			</form>
            		

        	</div>


		</div>
	</body>	
</html>
