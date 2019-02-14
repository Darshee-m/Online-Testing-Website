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
	//echo " connection"; 
}

mysqli_select_db($con, 'website');

?>




<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Log-in</title>
	<link rel='stylesheet' href='http://codepen.io/assets/libs/fullpage/jquery-ui.css'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" href="css/loginstyle.css" media="screen" type="text/css" />
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.8/jquery.validate.min.js"></script>
	<script src='http://codepen.io/assets/libs/fullpage/jquery_and_jqueryui.js'></script>
	<link rel="stylesheet" href="css/css_forms.css" type="text/css" //>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	
</head>

<?php
if(isset($_SESSION['email'])) {
	$usertype = $_SESSION["usertype"];
	if($usertype == "faculty") {
		header('location:facultyhome.php');
	}
	else if($usertype == "student") {
		header('location:studenthome.php');
	}
	else {
		header('location:adminhome.php');
	}
}

?>
<body class="bodyfull">


	<nav class="navbar navbar-inverse" style="margin:0; font-size:20px;">
  			<div class="container-fluid">
    				<div class="navbar-header">
      					<a class="navbar-brand" href="#">Somaiya Quiz Centre</a>
    				</div>
    				<ul class="nav navbar-nav">
      					<li><a href="index.html">Home</a></li>
      					<li class="active"><a href="login.php">Login</a></li>
    				</ul>
  			</div>
		</nav> <br>

		<div id="header">
		<div class="t_and_logo"><img src="images/kjsce.png"></div>
		<div class="t_and_logo"><h1 class="h1title" align="center" id="title">Somaiya Quiz Centre</h1></div>
		</div>  
	
	<br><br><br><br>
  	<div class="login-card">
  		<h1>Log-in</h1><br>
  		<form method="post" action="validation.php">
    			<input type="text" placeholder="Email" name="email">
    			<input type="password" name="password" placeholder="Password" name="password">

    			<input type="submit" name="login" class="login login-submit" value="Login">
  		</form>
	</div>
</body>

</html>
