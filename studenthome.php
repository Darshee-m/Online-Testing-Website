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
$email = $_SESSION['email'];
$q1 = "select * from student where email = '$email'";
$q2 = mysqli_query($con, $q1);
$q3 = mysqli_fetch_array($q2);
$name = $q3['name'];
//$division = $q3['division'];
//$branch = $q3['branch'];
//$semester = $q3['semester'];
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Student Home</title>
		<link rel="stylesheet" type="text/css" href="bootstrap.css">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<style type="text/css">
	
		/* The grid: Three equal columns that floats next to each other */
		.column {
    		float: left;
    		width: 33%;
    		padding: 50px;
    		text-align: center;
    		font-size: 30px;
    		cursor: pointer;
    		color: black;
    		border-style: solid;
    		border-width: 1px;
		}

		.containerTab {
    		text-align: center;
    		padding: 20px;
    		color: black;
		}
		
		/* Clear floats after the columns */
		.row:after {
    		content: "";
    		display: table;
    		clear: both;
		}
			
		.rules
		{
			border:1px solid #888;
			box-shadow: 2px 2px #aaa;
			width:80%;
			margin:2px auto;
		}

		/* Closable button inside the container tab */
		.closebtn {
    		float: right;
    		color: black;
    		font-size: 35px;
    		cursor: pointer;
		}

		#imagerule
		{
			float:left;
		}

		form
		{
			margin: 40px 450px;
		}

		#container {height: 100%; width:100%; font-size: 0;margin :20px auto;font-size: 30px;}
		#sub1, #sub2, #sub3, #sub4{display: inline-block; *display: inline; zoom: 1; vertical-align: top; font-size: 15px;}
		
		#sub1{width: 24%;height:400px; border:1px solid black; margin:1px 2px; padding:4px;}
		#sub2{width: 24%;height:400px; border:1px solid black; margin:1px 2px; padding:4px;}
		#sub3{width: 24%;height:400px; border:1px solid black; margin:1px 2px; padding:4px;}
		#sub4{width: 24%;height:400px; border:1px solid black; margin:1px 2px; padding:4px;}

		#sub1:hover{box-shadow: 2px 2px 2px 2px #888;}
		#sub2:hover{box-shadow: 2px 2px 2px 2px #888;}
		#sub3:hover{box-shadow: 2px 2px 2px 2px #888;}
		#sub4:hover{box-shadow: 2px 2px 2px 2px #888;}

	
</style>

	</head>	

	<body style="background:linear-gradient(#8ACBFA,white 80%);">
		<nav class="navbar navbar-inverse" style="margin:0; font-size:20px;">
  			<div class="container-fluid">
    				<div class="navbar-header">
      					<a class="navbar-brand" href="#">Somaiya Quiz Centre</a>
    				</div>
    				<ul class="nav navbar-nav">
      					<li><a href="index.html">Home</a></li>
      					<li><a href="#">Login</a></li>
					<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1 						<span class="caret"></span></a>
        					<ul class="dropdown-menu">
          						<li><a href="#">Page 1-1</a></li>
          						<li><a href="#">Page 1-2</a></li>
          						<li><a href="#">Page 1-3</a></li>
        					</ul>
      					</li>
    				</ul>
				<ul class="nav navbar-nav navbar-right">
      					<li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    				</ul>
  			</div>
		</nav> <br>


		<br><h1 style="text-align:center;">Welcome <?php echo $name;?></h1><br>
		<div class="rules" style="background:#71C3F9;">
			<div>
			<img id="imagerule" src="images/teacher.jpg">
			</div>
			<div style="margin-left:320px;"><h4>Rules and Regulations Regarding The Test</h4>
			<ol>
				<li>There are in all 4 Subjects.</li>
				<li>The student can choose to attempt the test for any of these subjects.</li>
				<li>The test contains 10 questions each for any subject.</li>
				<li>Each question is a multiple choice question with 4 options.</li>
				<li>Only one of the four options is correct for any of the question.</li>
				<li>The test must be completed by the student in a given time limit.</li>
				<li>If the student fails to complete the test within the alloted time,his score will be considered as zero.</li>
				<li>The result of the test will be displayed once the student presses the submit button.</li>
				<li>The marks scored by student in the first attempt will be considered as final.</li>
			</ol>	
			</div>
		</div><br>	

<!-- Three columns -->
<div class="row">
  	<div class="column" onclick="openTab('b1');" style="background:#66FFFF;">
    Attend Test
  	</div>
  
  	<div class="column" onclick="openTab('b2');" style="background:#66FFFF;">
    View performances
  	</div>

	<div class="column" onclick="openTab('b3');" style="background:#66FFFF;">
    Upcoming tests
  	</div>
</div>

<!-- Full-width columns: (hidden by default) -->

<?php
	date_default_timezone_set("Asia/Kolkata");
	//echo date_default_timezone_get();
	$email = $_SESSION["email"];
	$q1 = "select * from student where email = '$email' ";
	$q2 = mysqli_query($con, $q1);
	$q3 = mysqli_fetch_array($q2);
	$branch = $q3['branch'];
	$division = $q3['division'];
	$semester = $q3['semester'];
	$q1 = "select DAY(date) as day, MONTH(date) as month, YEAR(date) as year, topic, subject from subject s inner join test t on s.short = t.subject where s.branch = '$branch' && s.branch = t.branch && s.semester = '$semester' && t.division = '$division' ";
	$q2 = mysqli_query($con, $q1);
	$num = mysqli_num_rows($q2);	
?>

<div id="b1" class="containerTab" style="display:none;">
  	<span onclick="this.parentElement.style.display='none'" class="closebtn">&times;</span>
  	<h2>Attending Test :</h2>
  		<div class="rules">
			<form method="POST" action="reattend.php">
			Select Any Subject :- 
			<select name="topic">
			<?php 	$q4 = mysqli_num_rows($q2);
					if($q4 != 0) {
						while($q3 = mysqli_fetch_array($q2)) {
							$date = getDate();
							$day = $q3['day'];
							$month = $q3['month'];
							$year = $q3['year'];
							if($year == $date['year']) {
								if($month == $date['mon']) {
									if(($day == $date['mday'])) {
			?>
				<option value="<?php echo $q3['topic']; ?>"><?php echo $q3['subject']; echo " - "; echo $q3['topic']; ?></option>
			<?php 
									}	
								}
							}
						}
					}
					else {
						echo "No tests soon";
					}
			?>
			</select>	
			<input type="submit" name="GO"  value="GO">
		</form>
		</div><br><br>
	<div id="container" style="height:100%; width:100%" >

        	<div id="sub1">
            	<h4 align="center">Data Structures</h2>
            	<img src="images/ds.jpg"><br><br>
            	<p>A data structure is a data organization and storage format that enables efficient access and modification.More precisely, a data structure is a collection of data values and the operations that can be applied to the data.</p>
        	</div>

        	<div id="sub2">
            	<h4 align="center">Data Communication Networks</h2>
            	<img src="images/networking.jpg"><br><br>
            	<p>A computer network, or data network, is a digital telecommunications network which allows nodes to share resources. In computer networks, computing devices exchange data with each other using connections (data links) between nodes. </p>
        	</div>

        	<div id="sub3">
            	<h4 align="center">Algorithms</h2>
            	<img src="images/algo.jpg"><br><br>
            	<p>In mathematics and computer science, an algorithm is an unambiguous specification of how to solve a class of problems. Algorithms can perform calculation, data processing and automated reasoning tasks.</p>
        	</div>

        	<div id="sub4">
            	<h4 align="center">DataBase Management Systems</h2>
            	<img src="images/db.jpg"><br><br>
            	<p>A database-management system (DBMS) is a computer-software application that interacts with end-users, other applications, and the database itself to capture and analyze data. (Sometimes a DBMS is loosely referred to as a "database".) </p>
        	</div>
    	</div>
</div>


<div id="b2" class="containerTab" style="display:none;">
  	<span onclick="this.parentElement.style.display='none'" class="closebtn">&times;</span>
  	<h2>Your performances :</h2>
		<div>
			<?php
				//$div = $_SESSION['div'];
				//$email=$_SESSION['email'];
				$q3 = " select * from records where division='$division' && email='$email' && branch = '$branch' && display = 'visible' ";
				$result = mysqli_query($con, $q3);
				$num = mysqli_num_rows($result);
			?>
			<h3>Performance table for <?php echo "$num";?> test:</h3><br>
			<?php 
			if(mysqli_num_rows($result) > 0)
				{
				echo "<table class='w3-table-all'>
    				<thead>
      					<tr class='w3-light-grey'>
        					<th>Subject</th>
						<th>Topic</th>
						<th>Marks</th>
        					<th>Q. 1</th>
        					<th>Q. 2</th>
						<th>Q. 3</th>
						<th>Q. 4</th>
						<th>Q. 5</th>
						<th>Q. 6</th>
						<th>Q. 7</th>
						<th>Q. 8</th>
						<th>Q. 9</th>
						<th>Q. 10</th>
						<th>Q. 11</th>
						<th>Q. 12</th>
						<th>Q. 13</th>
						<th>Q. 14</th>
						<th>Q. 15</th>
      					</tr>
    				</thead>";
					while($rows = mysqli_fetch_array($result)) {
						echo "<tr>";
						echo "<td>" . $rows['subject'] . "</td>";
						echo "<td>" . $rows['topic'] . "</td>";
						echo "<td>" . $rows['marks'] . "</td>";
						echo "<td>" . $rows['q1'] . "</td>";
						echo "<td>" . $rows['q2'] . "</td>";
						echo "<td>" . $rows['q3'] . "</td>";
						echo "<td>" . $rows['q4'] . "</td>";
						echo "<td>" . $rows['q5'] . "</td>";
						echo "<td>" . $rows['q6'] . "</td>";
						echo "<td>" . $rows['q7'] . "</td>";
						echo "<td>" . $rows['q8'] . "</td>";
						echo "<td>" . $rows['q9'] . "</td>";
						echo "<td>" . $rows['q10'] . "</td>";
						echo "<td>" . $rows['q11'] . "</td>";
						echo "<td>" . $rows['q12'] . "</td>";
						echo "<td>" . $rows['q13'] . "</td>";
						echo "<td>" . $rows['q14'] . "</td>";
						echo "<td>" . $rows['q15'] . "</td>";
						echo "</tr>";
					} 
				}else {
					echo "0 results.";
				}
			echo "</table>";
			?>
			
		</div>
</div>

<div id="b3" class="containerTab" style="display:none;">
  	<span onclick="this.parentElement.style.display='none'" class="closebtn">&times;</span>
  	<h2>Upcoming tests for you</h2><br>
	<div class="rules">
		<?php
			//$branch = $_SESSION['branch'];
			$q1 = "select * from student where email = '$email'";
			$q2 = mysqli_query($con, $q1);
			$q3 = mysqli_fetch_array($q2);
			$sem = $q3['semester'];
			$division = $q3['division'];
			$branch = $q3['branch'];
			$q = "select * from test where division='$division' and branch='$branch' and semester='$sem'";
			$result = mysqli_query($con, $q);
			$num=mysqli_num_rows($result);
			if($num == 0)
			{
				echo "<h4>You have no upcoming tests. Sit back & relax!</h4>";
			}else{			
			while($rows = mysqli_fetch_array($result)) 
			{
				$testdate = $rows['date'];
				$subject = $rows['subject'];
				$date = date('Y-m-d');
				//$diff = date_diff(date_create($date),date_create($testdate));
				//$days=$diff->days;
				$diff = strtotime($testdate) - strtotime($date);
				$years = floor($diff / (365*60*60*24));
				$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
				$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
				if($diff<0)
				{
					echo "<h4>You have no upcoming tests. Sit back & relax!</h4>";				
					continue;}
				if($days == 0) {
					$time = date("H:i:s");
					$testtime = $rows['end_time'];
					$timeleft = strtotime($testtime) - strtotime($time);
					if($timeleft>0) {
						$hrs = floor($timeleft / (60*60));
						$min = floor(($timeleft - $hrs*60*60) / 60);
						$sec = floor($timeleft - $hrs*60*60 - $min*60);
						echo $hrs. " Hrs ".$min." minutes ".$sec." seconds left for ".$subject." test";
						echo "<table class='w3-table-all'>
		    				<thead>
		      					<tr class='w3-light-grey'>
								<th>Subject</th>
								<th>Topic</th>
								<th>Number of Questions</th>
								<th>Date</th>
								<th>Start Time</th>
								<th>End Time</th>
		      					</tr>
		    				</thead>";
							echo "<tr>";
							echo "<td>" . $rows['subject'] . "</td>";
							echo "<td>" . $rows['topic'] . "</td>";
							echo "<td>" . $rows['number_questions'] . "</td>";
							echo "<td>" . $rows['date'] . "</td>";
							echo "<td>" . $rows['start_time'] . "</td>";
							echo "<td>" . $rows['end_time'] . "</td>";
							echo "</tr>";
						echo "</table>";
						echo "<br><br>";
					}else 
					{echo "<h4>You have no upcoming tests. Sit back & relax!</h4>";					}
				}
				elseif($days<15) {
					echo $days. " Days left for ".$subject." test";
					echo "<table class='w3-table-all'>
	    				<thead>
	      					<tr class='w3-light-grey'>
							<th>Subject</th>
							<th>Topic</th>
							<th>Number of Questions</th>
							<th>Date</th>
							<th>Start Time</th>
							<th>End Time</th>
	      					</tr>
	    				</thead>";
						echo "<tr>";
						echo "<td>" . $rows['subject'] . "</td>";
						echo "<td>" . $rows['topic'] . "</td>";
						echo "<td>" . $rows['number_questions'] . "</td>";
						echo "<td>" . $rows['date'] . "</td>";
						echo "<td>" . $rows['start_time'] . "</td>";
						echo "<td>" . $rows['end_time'] . "</td>";
						echo "</tr>";
					echo "</table>";
					echo "<br><br>";
				}else {
					echo "<h4>You have no upcoming tests. Sit back & relax!</h4>";	
				}	
			}
		}
		?>
	</div>
	
</div><br><br>

	<div style="text-align:center;">
		<a href="logout.php" class="btn btn-success"> LOGOUT </a>
	</div>
	</body>	

<script>
function openTab(tabName) {
  var i, x;
  x = document.getElementsByClassName("containerTab");
  for (i = 0; i < x.length; i++) {
     x[i].style.display = "none";
  }
  document.getElementById(tabName).style.display = "block";
}
</script>
</html>
