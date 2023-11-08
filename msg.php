<?php
  include('database_connection.php');
  session_start();
  $class_id=null;
  $class_name=null;
  $user_id=null;
  $user_d=null;
  if(isset($_SESSION["t_log"]))
  {
    $class_name=$_SESSION['t_class'];
    $class_id=$_SESSION['t_cid'];
    $user_id=$_SESSION['t_id'];
    $user_d=1;//teacher login here
  }

else if(isset($_SESSION["s_log"]))
{
  $class_name=$_SESSION['s_class'];
  $class_id=$_SESSION['s_cid'];
  $user_id=$_SESSION['s_id'];
  $user_d=2;//teacher login here
}
else if(isset($_SESSION["a_log"]))
{  $class_id=1;
  if (isset($_GET["class"])) 
  {
  $class_id= $_GET["class"];
  $_SESSION['a_cid']=$class_id;
  }
  $q1 = "SELECT * FROM `class` WHERE id='$class_id'";
  $query1 = mysqli_query($conn, $q1);
  while ($result = mysqli_fetch_array($query1))
  {
  $class_name=$result['name'];
  }
  $user_id=$_SESSION['a_id'];
  $user_d=0;//teacher login here
}
else
{
  header('location:index.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chat</title>
  <link rel="stylesheet" href="js/bootstrap.min.css"  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
 
</head>
<body>
<?php
include "nav.php";
if ($user_dd==0) {
  // header('Location: student.php');
}
else if ($user_dd==1) {
  // header('Location: attendance.php');
}
else if ($user_dd==2) {
  // header('Location: msg.php');
}
else {
  header('Location: index.php');
}
?>
<?php

echo '<h3 align="center"style="margin: 25px 4px;
">Class : '.$class_name.'</h3>';
?>
<div class="container rounded bg-dark  w-50 my-2 text-white px-3" style="height: 440px;overflow-x: hidden;overflow-y: auto;padding: 16px 16px;" id="show">
<?php
// echo $tid; 
?>
</div>
<div class="form-group d-flex justify-content-center"style="
    margin-bottom: 40px;
">
    <textarea class="form-control w-50 " rows="1"id="msg" rows="3"></textarea>
  </div>
<?php
include "footer.php";
?>
</body>
</html>
<script src="js/jquery.min.js"></script>
<!-- <script src="js/bootstrap.min.js"></script> -->
<script src="js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() 
    {
        setInterval(function() {
            $("#show").load("_msg.php")
            }, 1000);
    });
        $("#msg").keyup(function(e)
        {
            if (e.keyCode==13) 
            {
              cn="<?php echo $class_name;?>";
              cid="<?php echo $class_id;?>";
              uid="<?php echo $user_id;?>";
              ud="<?php echo $user_d;?>";
                var msg=$("#msg").val();
                // console.log(msg);
                $.ajax({
                url:"_insert_msg.php",   
                type: "post",
                data: {msg: msg,cn: cn,cid: cid,uid: uid,ud: ud},
                success:function(result)
                {
                        $("show").load("_msg.php");
                        $("#msg").val("");
                }
                });    
            }
                
    });
    </script>
</body>
</html>