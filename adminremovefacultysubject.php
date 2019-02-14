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

if(!isset($_SESSION["email2"])) {
	echo "<script type='text/javascript'>alert('Email not set!');
	window.location = 'adminchangefacultysubject.php';
	</script>";
}
else if(!isset($_SESSION["work2"])) {
	echo "<script type='text/javascript'>alert('Particular option not selected!');
	window.location = 'adminchangefacultysubject.php';
	</script>";
}

$admin_work = "remove_faculty_subject";
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
					<form action="adminactivity.php" method="POST">
						<select name="subjectremove">
						<?php 
							$email = $_SESSION["email2"];
							$branch = $_SESSION["branch2"];
							$q1 = "select * from faculty where email = '$email' && branch = '$branch' ";
							$q2 = mysqli_query($con, $q1);
							while($q3 = mysqli_fetch_array($q2)) {
						?>
						<option value="<?php echo $q3['subject']; echo "-"; echo $q3['division']; ?>"><?php echo "Sem "; echo $q3['semester']; echo " - "; echo $q3['subject']; echo " - Div "; echo $q3['division']; ?></option>
							<?php } ?>
						<input type="submit" name="login" class="login login-submit" value="Submit">
					</form>
		</div>
		<!-- #container -->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

		<script src="js/admin.js"></script>
		
	</body>	
</html>
