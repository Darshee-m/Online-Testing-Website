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

if(isset($_SESSION["admin_work"])) {
	echo "<script type='text/javascript'>alert('You cannot access this page!');
	window.location = 'adminhome.php';
	</script>";
}

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
		<script>
			$(document).ready(function(){
				$(".user-type").change(function(){
					$("#division").toggle();
				});
			});
		</script>

		<script>
				function checkForm(form)
		  {
			
			re = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/ ;
			if (!re.test(form.email.value))
			{
				alert("You have entered an invalid email address!");
				form.email.focus();
				return (false);
			}
			
		  }

		</script>
		
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
				<button type="button"><a href="adminaddacc2.php">Add another subject</a></button>
				<button type="button"><a href="adminhome.php">Return</a></button>
        		</div>


		</div>
		<!-- #container -->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

		<script src="js/admin.js"></script>
		
	</body>	
</html>
