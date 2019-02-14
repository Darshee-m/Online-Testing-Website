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

?>


<html>

<head>
	<meta charset="UTF-8">
	<title>Credentials</title>
	<link rel='stylesheet' href='http://codepen.io/assets/libs/fullpage/jquery-ui.css'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" href="css/loginstyle.css" media="screen" type="text/css" />
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.8/jquery.validate.min.js"></script>
	<script src='http://codepen.io/assets/libs/fullpage/jquery_and_jqueryui.js'></script>
	<link rel="stylesheet" href="css/css_forms.css" media="screen" type="text/css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<script>
				function checkForm(form)
		  {
			  if(form.name.value == "") {
			  alert("Error: Username cannot be blank!");
			  form.name.focus();
			  return false;
			}
			re = /^\w+$/;
			if(!re.test(form.name.value)) {
			  alert("Error: Username must contain only letters, numbers and underscores!");
			  form.name.focus();
			  return false;
			}
			
			var usertype= "<?php echo $_SESSION["usertype"]?>" ;
			//alert "x";
			if (usertype=="student"){
			  if(form.roll.value.length != 7) {
				alert("Error: Roll No. must contain exactly seven digits!");
				form.roll.focus();
				return false;
			  }
			}  
			
			  
			if(form.password.value != "" && form.password.value == form.pwd2.value) 
			{
			  if(form.password.value.length < 6) {
				alert("Error: Password must contain at least six characters!");
				form.password.focus();
				return false;
			  }
			  if(form.password.value == form.name.value) {
				alert("Error: Password must be different from Username!");
				form.password.focus();
				return false;
			  }
			  re = /[0-9]/;
			  if(!re.test(form.password.value)) {
				alert("Error: password must contain at least one number (0-9)!");
				form.password.focus();
				return false;
			  }
			  re = /[a-z]/;
			  if(!re.test(form.password.value)) {
				alert("Error: password must contain at least one lowercase letter (a-z)!");
				form.password.focus();
				return false;
			  }
			  re = /[A-Z]/;
			  if(!re.test(form.password.value)) {
				alert("Error: password must contain at least one uppercase letter (A-Z)!");
				form.password.focus();
				return false;
			  }
			} 
			else 
			{
			  alert("Error: Please check that you've entered and confirmed your password!");
			  form.password.focus();
			  return false;
			}
		  }

</script>

<body class="bodyfull" style="height:1000px;">
	<nav class="navbar navbar-inverse" style="margin:0; font-size:20px;">
  			<div class="container-fluid">
    				<div class="navbar-header">
      					<a class="navbar-brand" href="#">Somaiya Quiz Centre</a>
    				</div>
    				<ul class="nav navbar-nav">
      					<li><a href="index.html">Home</a></li>
      					<li class="active"><a href="#">Login</a></li>
					<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1<span class="caret"></span></a>
        					<ul class="dropdown-menu">
          						<li><a href="#">Page 1-1</a></li>
          						<li><a href="#">Page 1-2</a></li>
          						<li><a href="#">Page 1-3</a></li>
        					</ul>
      					</li>
    				</ul>
  			</div>
		</nav> <br>

	<div id="header">
		<div class="t_and_logo"><img src="images/kjsce.png"></div>
		<div class="t_and_logo"><h1 class="h1title" align="center" id="title">Somaiya Quiz Centre</h1></div>
		</div>     
	
  	<br><br><br><br>
  	<div class="login-card" style="width:30%;">
  		<h1>Set credentials</h1><br>
		<h2>If faculty, you need not enter roll number. Leave it blank</h2><br>
  			<form onsubmit="return checkForm(this);" method="post" action="updateStudentData.php">
				<input type="text" placeholder="Name " name="name">
    			<input type="text" placeholder="Roll No. " name="roll">
    			<input type="password" name="password" placeholder="Password" name="password">
				<input type="password" name="pwd2" placeholder="Confirm Password" name="pwd2">

    			<input type="submit" name="login" class="login login-submit" value="Login">
  		</form>
	</div>
</body>

</html>
