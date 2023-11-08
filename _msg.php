<?php
 include('database_connection.php');
session_start();
$class_id=null;
$class_name=null;
$user_id=null;
$user_name=null;
$user_d=null;
$msg_user=null;
$msg_m=null;
if(isset($_SESSION["t_log"]))
{
  $class_id=$_SESSION['t_cid'];
  $class_name=$_SESSION['t_class'];
  $user_id=$_SESSION['t_id'];
  $user_name=$_SESSION['t_name'];
  $user_d=1;//teacher login here

}

else if(isset($_SESSION["s_log"]))
{
    $class_name=$_SESSION['s_class'];
    $class_id=$_SESSION['s_cid'];
    $user_id=$_SESSION['s_id'];
    $user_d=2;//teacher login here
    $user_name=$_SESSION['s_name'];
}
else if(isset($_SESSION["a_log"]))
{  
    
    $class_id=$_SESSION['a_cid'];
    $user_id=$_SESSION['a_id'];
    $user_d=0;//teacher login here
    $user_name=$_SESSION['a_name'];
}

$sql = "SELECT * FROM msg WHERE `msg_class`='$class_id'";
//msg	msg_class	msg_uid	msg_ud
    $result = mysqli_query($conn, $sql);
   while( $row = mysqli_fetch_row($result))
   {
       if ($row[4]==0) {
        $sql1 = "SELECT * FROM `admin` WHERE s_no='$row[3]'";
        $result1 = mysqli_query($conn, $sql1);
        $row2 = mysqli_fetch_row($result1);
        $msg_user = $row2[1];
        $msg_m="A";
      }
      else if($row[4]==1) {
        $sql1 = "SELECT * FROM `teachers` WHERE t_id='$row[3]'";
        $result1 = mysqli_query($conn, $sql1);
        $row2 = mysqli_fetch_row($result1);
        $msg_user = $row2[1];
        $msg_m="T";
      }
      else if($row[4]==2) {
        $sql1 = "SELECT * FROM `students` WHERE s_id='$row[3]'";
        $result1 = mysqli_query($conn, $sql1);
        $row2 = mysqli_fetch_row($result1);
        $msg_user = $row2[2];
        $msg_m="S";
        }
 
    if ($user_name == $msg_user) {
        echo     '<p class="pp"align ="right"style="color: yellow;    font-size: 18px;
        font-family: cursive;">You : <span style="color:white;font-size: 16px;"> ' . $row[1] . "</span></p>" . "<br>";
    
      } else {
        echo     '<p class="pp" style="color: yellow;    font-size: 18px;
        font-family: cursive;">'.$msg_m." : " . $msg_user . ' : <span style="color:white;font-size: 16px;"> ' . $row[1] . "</span></p>" . "<br>";
      }
   }
 
?>