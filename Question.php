<?php

session_start();
/*if(!isset($_SESSION['username'])){
header('location:login.php');
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

$email = $_SESSION["email"];
$q1 = "select * from student where email = '$email' ";
$q2 = mysqli_query($con, $q1);
$q3 = mysqli_fetch_array($q2);

$name = $q3['name'];
$semester = $q3['semester'];
$branch = $q3['branch'];
$division = $q3['division'];
$topic = $_SESSION["topic"];
$subject = $_SESSION["subject"];

$e1 = "Select * from records where email = '$email' && subject = '$subject' && topic = '$topic' ";
$e2 = mysqli_query($con, $e1);
$e3 = mysqli_fetch_array($e2);
if($e3['given'] == "yes") {
	header('location:studenthome.php');
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Student Home</title>
	<link rel="stylesheet" type="text/css" href="bootstrap.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	 <link href="https://fonts.googleapis.com/css?family=Montserrat|Open+Sans" rel="stylesheet">
	<link rel='stylesheet' href='http://codepen.io/assets/libs/fullpage/jquery-ui.css'>
<style>
p {
  text-align: center;
  font-size: 45px;
  margin-top:0px;
}

.column {
	float : left;
}
</style>


	
</head>
<body style="background:linear-gradient(#8ACBFA,white 80%); height:1000px;"">
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
  			</div>
		</nav> <br>


<!------------------TIMER---------------->

<script>
function redirect() {
	window.location="check.php";
}
</script>

<!----------------------TIMER------------------>

<div class="container">


	<br> <h1 class="text-center text-primary"> Somaiya Quiz Centre </h1><br>
	
	<h2 class="text-center text-success"> Welcome <?php echo $name; ?> </h2> <br>

<div class="col-lg-8 m-auto d-block">
	<div class="card" >

		<p id="divCounter"></p>
			
    <script type="text/javascript">

/*if(localStorage.getItem("countera")) {
	if(localStorage.getItem("countera") < 0) {
        //redirect();
    }
	else {
		var value = localStorage.getItem("countera");
    }
}
else {
	var value = 600;
}*/

value = localStorage.getItem("countera");


var counter2 = function (){
	value = parseInt(value)-1;
	if(value == 0) {
		redirect();
	}
    localStorage.setItem("countera", value);
	document.getElementById('divCounter').innerHTML = (value-value%60)/60 + "m " + value%60 + "s ";
}
	
var interval2 = setInterval(function (){counter2();}, 1000);
	
  </script>
	
	
		<h3 class="text-center card-header">  Welcome <?php echo $name; ?>, you have to select only one out of 4. Best of Luck :)  </h3>
		<div class="column">
		<a href="#q1"><img src="images/q1.png" width="50px" height="50px"></a>
		<a href="#q2"><img src="images/q2.png" width="50px" height="50px" ></a>
		<a href="#q3"><img src="images/q3.png" width="50px" height="50px" ></a>
		<a href="#q4"><img src="images/q4.png" width="50px" height="50px" ></a>
		<a href="#q5"><img src="images/q5.png" width="50px" height="50px" ></a>
		<a href="#q6"><img src="images/q6.png" width="50px" height="50px" ></a>
		<a href="#q7"><img src="images/q7.png" width="50px" height="50px" ></a>
		<a href="#q8"><img src="images/q8.png" width="50px" height="50px" ></a>
		<a href="#q9"><img src="images/q9.png" width="50px" height="50px" ></a>
		<a href="#q10"><img src="images/q10.png" width="60px" height="50px" ></a>
		<a href="#q11"><img src="images/q11.png" width="50px" height="50px" ></a>
		<a href="#q12"><img src="images/q12.png" width="50px" height="50px" ></a>
		<a href="#q13"><img src="images/q13.png" width="50px" height="50px" ></a>
		<a href="#q14"><img src="images/q14.png" width="50px" height="50px" ></a>
		<a href="#q15"><img src="images/q15.png" width="50px" height="50px" ></a>
		
		</div>
		<p id="demo"></p>

	 </div><br>

	 <form action="check.php" method="post">

	 <?php
	 /*$qu1 = " select * from Questions where division = '$divs' && subject = '$sub' ";
	    $result = mysqli_query($con,$qu1);
	    $questioncount = mysqli_num_rows($result);
	 for($i=1 ; $i <=$questioncount ; $i++){
	 $q = " select * from Questions where subject = '$sub' && division = '$divs' && number = '$i' ";
	 $query = mysqli_query($con, $q);*/
	 
	 $r1 = "select * from questions where branch = '$branch' && subject = '$subject' && division = '$division' && topic = '$topic' ";
	 $r2 = mysqli_query($con, $r1);
	 

	 while ($r3 = mysqli_fetch_array($r2) ) {
	 	?>
	 	
	 	<div class="card">
	 		<h4 id="q<?php echo $r3['number']; ?>" class="card-header"> <?php echo $r3['number']; $questnum = $r3['number']; echo ". "; echo $r3['quests']  ?>  </h4>


	 		<?php
	 			 $s1 = " select * from options where number = '$questnum' && division = '$division' && subject = '$subject' && topic = '$topic' && branch = '$branch' ";
				 $s2 = mysqli_query($con, $s1);

				 while ($s3 = mysqli_fetch_array($s2) ) {
				 	?>

				 	<div class="card-body">
				 		
				 		<input type="radio" name="quizcheck[<?php echo $s3['number']; ?>]" value="<?php echo $s3['option_number']; ?>"> 
				 		<?php echo $s3['answers']; ?>

				 	</div>
<?php
	 }
	 }

	 ?>

	 <input type="submit" name="submit" value="Submit" class="btn btn-success m-auto d-block">

	 </form>
</div>
</div><br><br>

	 <br>

	 <div>
	 	<h5 class="text-center">  Thank You! </h5>
	 </div><br><br>
</div>
</body>
</html>





















