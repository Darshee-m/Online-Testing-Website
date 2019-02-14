<?php
session_start();

   $con = mysqli_connect('localhost','root');
 
   	mysqli_select_db($con,'website');
   ?>


<!DOCTYPE html>
<html>
   <head>
      <title></title>
      <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<style type="text/css">
	.animateuse{
			animation: leelaanimate 0.5s infinite;
		}

@keyframes leelaanimate{
			0% { color: red },
			10% { color: yellow },
			20%{ color: blue }
			40% {color: green },
			50% { color: pink }
			60% { color: orange },
			80% {  color: black },
			100% {  color: brown }
		}
</style>

   </head>
   <body>
     <div class="container text-center" >
     	<br><br>
    	<h1 class="text-center text-success text-uppercase " >  Somaiya Quiz Centre </h1>
    	<br><br><br><br>
      <table class="table text-center table-bordered table-hover">
      	<tr>
      		<th colspan="2" class="bg-dark"> <h1 class="text-white"> Results </h1></th>
      		
      	</tr>
      	<tr>
		      	<td>
		      		Questions Attempted
		      	</td>

	         <?php
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

			//$sub = $_SESSION["subject_selected"];
			//$divs = $_SESSION["division"];		
			//$name = $_SESSION["username"];

	
         // $counter = 0;
         $Resultans = 0;
            if(isset($_POST['submit'])){
            if(!empty($_POST['quizcheck'])) {
            // Counting number of checked checkboxes.
            $checked_count = count($_POST['quizcheck']);
            // print_r($_POST);
            ?>

        	<td>
            <?php
	    //counting number of questions
	    $qu1 = " select * from questions where division = '$division' && subject = '$subject' && branch = '$branch' && topic = '$topic'	";
	    $result = mysqli_query($con,$qu1);
	    $questioncount = mysqli_num_rows($result);
            echo "Out of ".$questioncount.", You have attempted ".$checked_count." questions."; 
	    //echo $sub;
	    //echo $divs;
		?>
            </td>
        
          	
            <?php
            // Loop to store and display values of individual checked checkbox.
            $selected = $_POST['quizcheck'];
            
            $q1 = " select * from answers where division = '$division' && subject = '$subject' && branch = '$branch' && topic = '$topic' ";
            $queryresult = mysqli_query($con,$q1);
            $i = 1;
            while(($rows = mysqli_fetch_array($queryresult)) && ($rows2 = mysqli_fetch_array($result))) {
            	$flag = $rows['correct_answer'] == $selected[$i];
            	
            			if($flag){
            				// echo "correct ans is ".$rows['ans']."<br>";				
            				// $counter++;
            				$Resultans = $Resultans + $rows2['marks'];
            				// echo "Well Done! your ". $counter ." answer is correct <br><br>";
            			}else{
            				// $counter++;
            				// echo "Sorry! your ". $counter ." answer is innncorrect <br><br>";
            			}					
            		$i++;		
            	}
            	?>
            	
		
	<?php
		//settings records table
		//echo $name;
		$xx = 'q';
		$qu1 = " insert into records(email,branch,subject,topic,division) values('$email','$branch','$subject','$topic','$division') ";
		mysqli_query($con,$qu1);
		for($i=1 ; $i <= $questioncount ; $i++){
			$xxx = $xx.$i;
			$qu2 = "update records set $xxx = '$selected[$i]' where email = '$email' && division = '$division' && subject = '$subject' && branch = '$branch' && topic = '$topic' ";
 			mysqli_query($con,$qu2);
		}    		
	?>	

    		<tr>
    			<td>
    				Your Total score
    			</td>
    			<td colspan="2">
	    	<?php 
	            echo " Your score is ". $Resultans.".";
	            }
	            else{
	            echo "<b>Please Select Atleast One Option.</b>";
	            }
	            } 
	          ?>
	          </td>
            </tr>

            <?php 
            //$name = $_SESSION['username'];
            $finalresult = " update records set marks = '$Resultans' where email = '$email' && division = '$division' && subject = '$subject' && branch = '$branch' && topic = '$topic' ";
            $queryresult= mysqli_query($con,$finalresult);
			$finalresult = " update records set given = 'yes' where email = '$email' && division = '$division' && subject = '$subject' && branch = '$branch' && topic = '$topic' ";
            mysqli_query($con,$finalresult);
            // if($queryresult){
            // 	echo "successssss";
            // }
            ?>
      </table>

      	<a href="logout.php" class="btn btn-success"> LOGOUT </a>
      </div>
   </body>
</html>
