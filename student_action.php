<?php
include('database_connection.php');
if($_POST["action"] == "Edit")
			{
				$student_id = $_POST["student_id"];
				$student_name = $_POST["student_name"];
				$student_roll = $_POST["student_roll_number"];
				$student_mobo = $_POST["student_mobo"];
				$student_dob = $_POST["student_dob"];
				$student_class = $_POST["student_class"];
				$student_gender = $_POST["gender"];
				$student_email = $_POST["student_email"];			
				$student_password = $_POST["student_password"];
				if (empty($_FILES['student_image']['name'])) {
					echo "no";
					echo $student_id ."<br>";
					echo $student_name ."<br>";
					echo $student_roll ."<br>";
					echo $student_dob ."<br>";
					echo $student_class ."<br>";
					echo $student_gender ."<br>";
					echo $student_mobo ."<br>";
					echo $student_email ."<br>";
					echo $student_password ."<br>";
					echo "no image";
				
					$qu = "UPDATE `students` SET `s_roll` = '$student_roll', `s_name` = '$student_name', `s_gender` = '$student_gender', `s_dob` = '$student_dob', `s_class` = '$student_class', `s_mobile` = '$student_mobo', `s_email` = '$student_email', `s_password` = '$student_password' WHERE `students`.`s_id` = '$student_id'";
					$query=mysqli_query($conn,$qu);
					if ($query){
						header("Location: student.php?update=1");
					}
					else {
						header("Location: student.php?update=0");
					}

				}
				else{
					 $student_image=$_FILES["student_image"];
					 $filename=$student_image['name'];
					 $fileext=explode('.',$filename);
					 $filecheck=strtolower(end($fileext));
					 $fileextedd=array('png','jpg','jpeg');
					if (in_array($filecheck,$fileextedd)) {
						   $destinationfile='upload/'.$filename;
						   move_uploaded_file($student_image['tmp_name'],$destinationfile);
						   echo $student_name ."<br>";
						   echo $student_roll ."<br>";
						   echo $student_dob ."<br>";
						   echo $student_class ."<br>";
						   echo $student_gender ."<br>";
						   echo $student_email ."<br>";
						   echo $student_password ."<br>";
						   echo "image is there";
						   echo '<img src="'.$destinationfile.'" alt="">';
   						 $qu = "UPDATE `students` SET `s_roll` = '$student_roll', `s_name` = '$student_name', `s_gender` = '$student_gender', `s_dob` = '$student_dob', `s_class` = '$student_class', `s_mobile` = '$student_mobo', `s_email` = '$student_email', `s_password` = '$student_password', `s_image` = '$destinationfile' WHERE `students`.`s_id` = $student_id";
							$query=mysqli_query($conn,$qu);
							if ($query){
								header("Location: student.php?update=1");
							}
							else {
								header("Location: student.php?update=0");
							}
					  }
				}
			}
if($_POST["action"] == "edit_fetch")
	{ $idd=$_POST["student_id"];
		$q1="SELECT * FROM students WHERE s_id='$idd'";
            $query1=mysqli_query($conn,$q1);
            while ($result=mysqli_fetch_array($query1)) {

				$output["student_name"] = $result["s_name"];
				$output["student_roll_number"] =  $result["s_roll"];
				$output["student_dob"] = $result["s_dob"];
				$output["student_class"] =  $result["s_class"];
				$output["student_id"] =  $result["s_id"];
				$output["student_gender"] = $result["s_gender"];
				$output["student_mobo"] =  $result["s_mobile"];
				$output["student_email"] = $result["s_email"];
				$output["student_password"] = $result["s_password"];
				$output["student_photo"] =  $result["s_image"];
			}
			echo json_encode($output);
		
	}
	if($_POST["action"] == 'Add')
	{		
		
			$student_name = $_POST["student_name"];
			$student_roll = $_POST["student_roll_number"];
			$student_mobo = $_POST["student_mobo"];
			$student_dob = $_POST["student_dob"];
			$student_class = $_POST["student_class"];
			$student_gender = $_POST["gender"];
			$student_email = $_POST["student_email"];			
			$student_password = $_POST["student_password"];
			$student_image=$_FILES["student_image"];

        	$filename=$student_image['name'];
      		$fileext=explode('.',$filename);
    		$filecheck=strtolower(end($fileext));
       		$fileextedd=array('png','jpg','jpeg');
       		if (in_array($filecheck,$fileextedd)) {
           		 $destinationfile='upload/'.$filename;
           		 move_uploaded_file($student_image['tmp_name'],$destinationfile);
				echo $student_name ."<br>";
				echo $student_roll ."<br>";
				echo $student_dob ."<br>";
				echo $student_class ."<br>";
				echo $student_gender ."<br>";
				echo $student_email ."<br>";
				echo $student_password ."<br>";
				echo '<img src="'.$destinationfile.'" alt="">';
$q="INSERT INTO `students`( `s_roll`, `s_name`, `s_gender`, `s_dob`, `s_class`, `s_mobile`, `s_email`, `s_password`, `s_image`) VALUES ('$student_roll','$student_name','$student_gender','$student_dob','$student_class','$student_mobo','$student_email','$student_password','$destinationfile')";
				$query=mysqli_query($conn,$q);
				if ($query){
					header("Location: student.php?insert=1");
				}
				else {
					header("Location: student.php?insert=0");
				}
			   }
	}
	if($_POST["action"] == "delete")
	{	$student_id = $_POST["student_id"];
		$q_dele = "DELETE FROM students WHERE s_id ='$student_id'";
		// echo $student_id.$q_dele;
		$query=mysqli_query($conn,$q_dele);
		if ($query)
		{
			header("Location: student.php?delete=1");
		}
		else 
		{
			header("Location: student.php?delete=0");
		}
	}
	
// echo $_POST["student_class_id"];
// echo $_POST["student_email"];
?>