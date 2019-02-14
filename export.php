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

//adding restrictions part
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

//added restriction part


$topic = $_SESSION["topic"];
$email = $_SESSION["email"];
$q1 = "select * from subjectselected where email = '$email' ";
$q2 = mysqli_query($con, $q1);
$q3 = mysqli_fetch_array($q2);
$branch = $q3['branch'];
$division = $q3['division'];
$semester = $q3['semester'];
$subject = $q3['short'];

$xls_filename = 'export_'.date('Y-m-d').'.xls';
$r1 = "select * from records where branch = '$branch' && division = '$division' && subject = '$subject' && topic = '$topic' ";
$result = mysqli_query($con, $r1);
$numrows = mysqli_num_rows($result);
if($numrows == 0) {
	echo "<script type='text/javascript'>alert('No records found'); 
	window.location='facultyactivity.php';
	</script>";
}



 /* 
  $DB_Server = "localhost"; // MySQL Server
  $DB_Username = "root"; // MySQL Username
  $DB_Password = ""; // MySQL Password
  $DB_DBName = "website"; // MySQL Database Name
  $DB_TBLName = "records"; // MySQL Table Name
  $xls_filename = 'export_'.date('Y-m-d').'.xls'; // Define Excel (.xls) file name
  $topic = $_POST["topic"]; 
  
  // Create MySQL connection
  $sql = "Select * from $DB_TBLName where topic= $topic";
  $Connect = mysqli_connect($DB_Server, $DB_Username, $DB_Password);
	if($Connect == NULL){
	echo "connection failed";
}
  // Select database
  $Db = mysqli_select_db($Connect, $DB_DBName); */
  // Execute query
  //$result = mysqli_query($con, $sql);
   
  // Header info settings
  header("Content-Type: application/xls");
  header("Content-Disposition: attachment; filename=$xls_filename");
  header("Pragma: no-cache");
  header("Expires: 0");
   
  /***** Start of Formatting for Excel *****/
  // Define separator (defines columns in excel &amp; tabs in word)
  $sep = "\t"; // tabbed character
  $num= mysqli_num_rows($result); 
  echo $num;
  // Start of printing column names as names of MySQL fields
  //for ($i = 0; $i<$num; $i++) {
    //$finfo = mysqli_fetch_field($result);
	//echo  $finfo->name . "\t";
  //}
  while($finfo = mysqli_fetch_field($result)) {
	  echo $finfo->name . "\t";
  }
  print("\n");
  // End of printing column names
   
  // Start while loop to get data
  while($row = mysqli_fetch_array($result))
  {
    $schema_insert = "";
    for($j=0; $j < 22; $j++)
    {
      if(!isset($row[$j])) {
        $schema_insert .= "NULL".$sep;
      }
      elseif ($row[$j] != "") {
        $schema_insert .= "$row[$j]".$sep;
      }
      else {
        $schema_insert .= "".$sep;
      }
    }
    //$schema_insert = str_replace($sep."$", "", $schema_insert);
   // $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
    $schema_insert .= "\t";
    print(trim($schema_insert));
	
    print "\n";
  }
?>