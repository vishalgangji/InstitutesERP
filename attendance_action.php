<?php
  include('database_connection.php');
  session_start();
  if(!isset($_SESSION["t_log"]))
  { 
    header('location:login.php');
  }
  if($_POST["action"] == 'Add')
	{		
		
			$teacher_id = $_SESSION["t_id"];
			$attendance_date = $_POST["attendance_date"];
      echo $attendance_date;
      $q2 = "SELECT * FROM `attendance` WHERE `attendance_date` ='$attendance_date' AND `teacher_id` ='$teacher_id'";
      echo $q2;
      $query2 = mysqli_query($conn, $q2);
      $result1 = mysqli_fetch_array($query2);
      // echo $result1[0];
      if($result1[0]>0)
      {
        header("Location: attendance.php?date=1");
      }
    

            foreach ($_POST['student_id'] as $key => $value) {
                $student_id = $value;
                // echo $student_id."<br>";
                // echo $teacher_id."<br>";
                // echo $attendance_date."<br>";
                // echo $_POST['attendance_status'.$value]."<br>";
               $attendance_status=$_POST['attendance_status'.$value];
                $q="INSERT INTO `attendance`(`student_id`, `attendance_status`, `attendance_date`, `teacher_id`) VALUES ('$student_id','$attendance_status','$attendance_date','$teacher_id')";
				$query=mysqli_query($conn,$q);
				if ($query){
					header("Location: attendance.php?insert=1");
				}
				else {
					header("Location: attendance.php?insert=0");
				}
            }
			

			   }
         if($_POST["action"] == "Edit")
         {
           
        //   <input type="hidden" name="attendance_id" id="att_id"/>
        //   <input type="hidden" name="attendance_tid" id="att_tid"/>
        //   <input type="hidden" name="attendance_sid" id="att_sid"/>
        // </td>
        // <td>attendance_date
        //   <input type="radio" id="rp"name="attendance_status" value="Present" />
        // </td>
           $attendance_id = $_POST["attendance_id"];
           $attendance_date = $_POST["attendance_date"];
           $attendance_status = $_POST["attendance_status"];
          
             echo $attendance_id ."<br>";
             echo $attendance_date ."<br>";
             echo $attendance_status ."<br>";

                   $qu = "UPDATE `attendance` SET `attendance_status` = '$attendance_status', `attendance_date` = '$attendance_date' WHERE `attendance`.`attendance_id` = $attendance_id;";
                 $query=mysqli_query($conn,$qu);
                 if ($query){
                   header("Location: attendance.php?update=1");
                 }
                 else {
                   header("Location: attendance.php?update=0");
                 }
               
           }
         
   if($_POST["action"] == "edit_fetch")
     { $idd=$_POST["attendance_id"];
       $q1="SELECT * FROM attendance WHERE attendance_id='$idd'";
               $query1=mysqli_query($conn,$q1);
               while ($result=mysqli_fetch_array($query1)) {
   
           $output["att_id"] = $result["attendance_id"];
           $output["att_st"] =  $result["attendance_status"];
           $output["att_d"] = $result["attendance_date"];
           $output["t_id"] =  $result["teacher_id"];
           $output["s_id"] =  $result["student_id"];
 
         }
         echo json_encode($output);
       
     }
?>