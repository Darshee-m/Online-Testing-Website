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

<script>
	$.noConflict();
	function checksome() {
		var temp1 = document.getElementById("num_options");
		var numopt = temp1.options[temp1.selectedIndex].value;
		if(numopt == 3) {
			jQuery("#3opt").show();
			jQuery("#4opt").hide();
		}
		if(numopt == 4) {
			jQuery("#4opt").show();
			jQuery("#3opt").show();
		}
		if(numopt == 2) {
			jQuery("#3opt").hide();
			jQuery("#4opt").hide();
		}
	}
	
	function setoption() {
		var temp1 = document.getElementById("num_options");
		var numopt = temp1.options[temp1.selectedIndex].value;
		var x = document.getElementById("5");
		x.setAttribute("max",numopt);
		x.setAttribute("min","1");
		x.setAttribute("value",numopt);
	}
	
	jQuery(document).ready(function() {
		jQuery("#3opt").hide();
		jQuery("#4opt").hide();
		jQuery(".numopts").change(function() {
			checksome();
			setoption();
		});
	});
</script>

<script>
function checkform(form) {
		if(form.question.value == "") {
			alert("Error : Question cannot be blank");
			form.question.focus();
			return false;
		}
		if(form.number.value == "") {
			alert("Error : Question number cannot be blank");
			form.number.focus();
			return false;
		}
		else if(form.number.value < form.number.min || form.number.value > form.number.max) {
			alert("Error : Question number not in range");
			form.number.focus();
			return false;
		}
		if(form.option1.value == "") {
			alert("Error : Option 1 value cannot be blank");
			form.option1.focus();
			return false;
		}
		if(form.option2.value == "") {
			alert("Error : Option 2 value cannot be blank");
			form.option2.focus();
			return false;
		}
		var temp1 = document.getElementById("num_options");
		var numopt = temp1.options[temp1.selectedIndex].value;
		if(numopt == 3) {
			if(form.option3.value == "") {
				alert("Error : Option 3 value cannot be blank");
				form.option3.foucs();
				return false;
			}
		}
		if(numopt == 4) {
			if(form.option4.value == "") {
				alert("Error : Option 4 value cannot be blank");
				form.option4.focus();
				return false;
			}
		}
		if(form.marks.value == "") {
			alert("Error : Marks cannot be blank");
			form.marks.focus();
			return false;
		}
		else if(form.marks.value < 0 || form.marks.value > 9) {
			alert("Error : Marks out of range (Range: 0-9)");
			form.marks.focus();
			return false;
		}
		if(form.correctans.value == "") {
			alert("Error : Correct answer value cannot be blank");
			form.correctans.focus();
			return false();
		}
		else if(form.correctans.value < form.correctans.min || form.correctans.value > form.correctans.max) {
			alert("Error : Correct answer value out of range");
			alert(form.correctans.max);
			alert(form.correctans.min);
			form.correctans.focus();
			return false();
		}
	}

</script>

</head>

<body style="background:linear-gradient(#8ACBFA,white 100%); height:700px;">
	<nav class="navbar navbar-inverse" style="margin:0; font-size:20px;">
  			<div class="container-fluid">
    				<div class="navbar-header">
      					<a class="navbar-brand" href="#">Somaiya Quiz Centre</a>
    				</div>
    				<ul class="nav navbar-nav">
      					<li><a href="facultyactivity.php">Home</a></li>
						<li><a href="facultytopic.php">Change Topic</a></li>
						<li><a href="facultyhome.php">Change Subject</a></li>
      					<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" >Edit Quiz <span class="caret"></span></a>
        					<ul class="dropdown-menu">
          						<li><a href="facultypreviewquiz.php">Preview</a></li>
          						<li><a href="facultychangequizdetails.php">Change date/time</a></li>
          						<li class="active"><a href="facultyaddquestion.php">Add questions</a></li>
								<li><a href="facultyremovequestion.php">Remove questions</a></li>
        					</ul>
      					</li>
      					
    				</ul>
    				<ul class="nav navbar-nav navbar-right">
      					<li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    				</ul>
  			</div>
	</nav><br>

	<?php
		$topic = $_SESSION["topic"];
		$q1 = "select * from subjectselected where email = '$email' ";
		$q2 = mysqli_query($con, $q1);
		$q3 = mysqli_fetch_array($q2);
		$branch = $q3['branch'];
		$division = $q3['division'];
		$subject = $q3['short'];
		$q1 = "select * from test where subject = '$subject' && branch = '$branch' && division = '$division' && topic = '$topic' ";
		$q2 = mysqli_query($con, $q1);
		$q3 = mysqli_fetch_array($q2);
		$numq = $q3['number_questions'];
		$numq = $numq + 1;
	?>
		
	
	<div class="rules" style="text-align:center;">
		<form onsubmit="return checkform(this);" action="facultyaddquestion2.php" method="POST"  ><br>
        		Question : &nbsp &nbsp &nbsp
        			<textarea id="question" name="question"  cols="50" ></textarea><br><br>
					<?php
						$q1 = "select * from test where topic = '$topic' && subject = '$subject' && branch = '$branch' && division = '$division' ";
						$q2 = mysqli_query($con, $q1);
						$q4 = mysqli_fetch_array($q2);
						$numq = $q4['number_questions'];
						$numq = $numq + 1;
					?>
				Question no. : &nbsp &nbsp &nbsp
					<input id="1" type="number" name="number"  value="<?php echo $numq; ?>" min="<?php echo $numq; ?>" max="<?php echo $numq; ?>" ><br><br>
					
				Select number of options : &nbsp &nbsp &nbsp
					<select name="num_options" id="num_options" class="numopts">
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
					</select>
				<div id="1opt">
				1st option :&nbsp &nbsp &nbsp
					<input id="1" type="text" name="option1" ><br><br>
				</div>
				<div id="2opt">
				2nd option :&nbsp &nbsp &nbsp
					<input id="2" type="text" name="option2" ><br><br>
				</div>
				<div id="3opt">
				3rd option :&nbsp &nbsp &nbsp
					<input id="3" type="text" name="option3" ><br><br>
				</div>
				<div id="4opt">
				4th option :&nbsp &nbsp &nbsp
					<input id="4" type="text" name="option4" ><br><br>
				</div>
				Marks alloted :&nbsp &nbsp &nbsp
					<input id="marks" type="number" name="marks" >
				Correct answer (type option number)
					<input id="5" type="number" name="correctans" min="1" max="2"><br><br>
					
				<input type="submit" value="Submit" class="btn btn-success m-auto d-block">
			</form>
		</div><br>

	<div style="text-align:center;" class="m-auto d-block">
		<a href="logout.php" class="btn btn-primary "> LOGOUT </a>
	</div>
</body>
</html> 

