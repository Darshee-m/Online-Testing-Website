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
//connected

$name= $_FILES['file']['name'];

$tmp_name= $_FILES['file']['tmp_name'];

$submitbutton= $_POST['submit'];

$position= strpos($name, "."); 

$fileextension= substr($name, $position + 1);

$fileextension= strtolower($fileextension);

$description= $_POST['description_entered'];

if (isset($name)) {

$path= 'uploads/';

if (!empty($name)){
if (move_uploaded_file($tmp_name, $path.$name)) {
echo 'Uploaded!';

$email = $_SESSION["email"];
$topic = $_SESSION["topic"];
$q1 = "select * from subjectselected where email = '$email' ";
$q2 = mysqli_query($con, $q1);
$q3 = mysqli_fetch_array($q2);

$subject = $q3['short'];
$branch = $q3['branch'];
$division = $q3['division'];
$semester = $q3['semester'];

$q = "insert into files(filename) values('$name') ";
mysqli_query($con, $q);


}
}
}
?>

<?php include("wordread.php"); ?>
<?php 
	$obj = new DocxConversion("uploads/Topic.docx");
	$str = $obj->read_docx();
	echo $str;
	$quest = "QNo:-";
	$question_mark = "?";
	$slash = "/";
	$marks = "Marks:-";
	$space = " ";
	$option1 = "1).";
	$option2 = "2).";
	$option3 = "3).";
	$option4 = "4).";
	$correct = "Correct Answer:-";
	for($i=0 ; $i < strlen($str)-1; $i++) {
		if($str[$i] == "Q") {
			$temp = 0;
			for($j=0 ; $j < strlen($quest) ; $j++) {
				$temp = $temp + strcasecmp($quest[$j],$str[$i + $j]);
			}
			if($temp == 0) {
				$i = $i + 5;
				while(strcmp($str[$i],$space) == 0) {
					$i++;
				}
				$number = $str[$i];
				$q = "insert into questions(number,branch,subject,topic,division) values('$number','$branch','$subject','$topic','$division') ";
				mysqli_query($con, $q);
				$q1 = "select * from test where topic = '$topic' && branch = '$branch' && subject = '$subject' && division = '$division' ";
				$q2 = mysqli_query($con, $q1);
				$q3 = mysqli_fetch_array($q2);
				$numq = $q3['number_questions'];
				$numq = $numq + 1;
				$q = "update test set number_questions = '$numq' where topic = '$topic' && branch = '$branch' && subject = '$subject' && division = '$division' ";
				mysqli_query($con, $q);
			}
		}
		else if(strcmp($str[$i],$space) == 0) {
			while(strcmp($str[$i],$space) == 0) {
				$i++;
			}
			if($str[$i] == "Q") {
				$temp = 0;
				for($j=0 ; $j < strlen($quest) ; $j++) {
					$temp = $temp + strcasecmp($quest[$j],$str[$i + $j]);
				}
				if($temp == 0) {
					$i = $i + 5;
					while(strcmp($str[$i],$space) == 0) {
						$i++;
					}
					$number = $str[$i];
					$q = "insert into questions(number,branch,subject,topic,division) values('$number','$branch','$subject','$topic','$division') ";
					mysqli_query($con, $q);
				}
			}
			else if($str[$i] == "M") {
				$temp = 0;
				echo $i;
				echo " is I here";
				for($j = 0; $j < strlen($marks) ; $j++) {
					$temp = $temp + strcasecmp($marks[$j],$str[$i + $j]);
				}
				if($temp == 0) {
					$i = $i + 7;
					while(strcmp($str[$i],$space) == 0) {
						$i++;
					}
					echo "marks is :";
					$marks2 = $str[$i];
					$q = "update questions set marks = '$marks2' where number = '$number' && branch = '$branch' && subject = '$subject' && topic = '$topic' && division = '$division' ";
					mysqli_query($con, $q);
				}
			}
			else if($str[$i] == "1") {
				$temp = 0;
				for($j=0 ; $j <strlen($option1) ; $j++) {
					if(($i + $j) >= strlen($str)) {
						$temp = 15;
						break;
					}
					$temp = $temp + strcasecmp($option1[$j],$str[$i + $j]);
				}
				if($temp == 0) {
					$i = $i + 3;
					while(strcmp($str[$i],$space) == 0) {
						$i++;
					}
					$start = $i;
					while(strcmp($str[$i],$slash) != 0) {
						$i++;
					}
					$end = $i;
					$num_words = $end - $start;
					$opt1 = substr($str,$start,$num_words);
					$q = "insert into options(number,option_number,branch,subject,topic,division,answers) values('$number','1','$branch','$subject','$topic','$division','$opt1') ";
					mysqli_query($con, $q);
				}
			}
			else if($str[$i] == "2") {
				$temp = 0;
				for($j=0 ; $j <strlen($option2) ; $j++) {
					$temp = $temp + strcasecmp($option2[$j],$str[$i + $j]);
				}
				if($temp == 0) {
					$i = $i + 3;
					while(strcmp($str[$i],$space) == 0) {
						$i++;
					}
					$start = $i;
					while(strcmp($str[$i],$slash) != 0) {
						$i++;
					}
					$end = $i;
					$num_words = $end - $start;
					$opt2 = substr($str,$start,$num_words);
					$q = "insert into options(number,option_number,branch,subject,topic,division,answers) values('$number','2','$branch','$subject','$topic','$division','$opt2') ";
					mysqli_query($con, $q);
				}
			}
			else if($str[$i] == "3") {
				$temp = 0;
				for($j=0 ; $j <strlen($option3) ; $j++) {
					$temp = $temp + strcasecmp($option3[$j],$str[$i + $j]);
				}
				if($temp == 0) {
					$i = $i + 3;
					while(strcmp($str[$i],$space) == 0) {
						$i++;
					}
					$start = $i;
					while(strcmp($str[$i],$slash) != 0) {
						$i++;
					}
					$end = $i;
					$num_words = $end - $start;
					$opt3 = substr($str,$start,$num_words);
					$q = "insert into options(number,option_number,branch,subject,topic,division,answers) values('$number','3','$branch','$subject','$topic','$division','$opt3') ";
					mysqli_query($con, $q);
				}
			}
			else if($str[$i] == "4") {
				$temp = 0;
				for($j=0 ; $j <strlen($option4) ; $j++) {
					$temp = $temp + strcasecmp($option4[$j],$str[$i + $j]);
				}
				if($temp == 0) {
					$i = $i + 3;
					while(strcmp($str[$i],$space) == 0) {
						$i++;
					}
					$start = $i;
					while(strcmp($str[$i],$slash) != 0) {
						$i++;
					}
					$end = $i;
					$num_words = $end - $start;
					$opt4 = substr($str,$start,$num_words);
					$q = "insert into options(number,option_number,branch,subject,topic,division,answers) values('$number','4','$branch','$subject','$topic','$division','$opt4') ";
					mysqli_query($con, $q);
				}
			}
			else if($str[$i] == "C") {
				$temp = 0;
				for($j=0 ; $j < strlen($correct) ; $j++) {
					$temp = $temp + strcasecmp($correct[$j],$str[$i + $j]);
				}
				if($temp == 0) {
					$i = $i + 16;
					while(strcmp($str[$i],$space) == 0) {
						$i++;
					}
					$correctans = $str[$i];
					$q = "insert into answers(number,branch,subject,topic,division,correct_answer) values('$number','$branch','$subject','$topic','$division','$correctans') ";
					mysqli_query($con, $q);
				}
			}	
			else {
				$start = $i;
				//echo $i;
				while(strcmp($str[$i],$question_mark) != 0) {
					$i++;
				}
				$end = $i;
				$num_words = $end - $start + 1;
				$question = substr($str,$start,$num_words);
				$q = "update questions set quests = '$question' where number = '$number' && branch = '$branch' && subject = '$subject' && topic = '$topic' && division = '$division' ";
				mysqli_query($con, $q);
			}
		}
	}
	echo $number;
	echo " is qnumber";
	echo $question;
	echo " is question";
	echo $marks2;
	echo " is marks";
	echo $opt1;
	echo " is option1";
	echo $opt2;
	echo " is option2";
	//echo $opt3;
	//echo " is option3";
	//echo $opt4;
	//echo " is option4";
	echo $correctans;
	echo " is correct answer";
?>