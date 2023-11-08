<?php
  include('database_connection.php');
  $log=0;
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $sql = "SELECT * FROM students WHERE s_email='$email' AND s_Password='$pass'";
    $result = mysqli_query($conn, $sql);
    $numrow = mysqli_num_rows($result);
    // echo $numrow;
    if ($numrow > 0) {
        $row = mysqli_fetch_row($result);
        echo "loged";
        
        $sql1 = "SELECT * FROM `class` WHERE id='$row[5]'";
        $result1 = mysqli_query($conn, $sql1);
        $row1 = mysqli_fetch_row($result1);
        session_start();
        $_SESSION['s_log'] = true;
        $_SESSION['s_id'] = $row[0];
        $_SESSION['s_name'] = $row[2];
        $_SESSION['s_class'] = $row1[1];
        $_SESSION['s_cid'] = $row[5];
        // echo $_SESSION['t_class'];
        header('Location: msg.php');
    } else {
      $log=1;
    }
}
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="js/bootstrap.min.css">
</head>

<body>
<?php

session_start();
include "nav.php";

?>
  <div class="jumbotron text-center" style="margin-bottom:0">
  <h1>Institute's ERP</h1>
</div>

<div class="container my-5" style="width: 600px;">
    <h1 align="center">Student Login</h1>
    <form action="" method="POST">
  <div class="mb-3">
    <label class="form-label">Email address</label>
    <input type="email"class="form-control"  name="email" required>
  </div>
  <div class="mb-3">
    <label  class="form-label">Password</label>
    <input type="password" class="form-control" name="pass"required>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
<?php
  if($log==1){
    echo'<h1 align="center" style="color: red;">Worng User Id or Password</h1>';
  }
?>
</div>
</body>
</html>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>