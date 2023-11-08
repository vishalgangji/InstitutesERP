
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="js/bootstrap.min.css">
    <title>SMS</title>
  </head>
  <body style="
    background: azure;
">
<?php
session_start();
include "nav.php";
?>
    <h1 align="center" style="
    margin: 18px 3px;
">Institute's ERP</h1>
    <div class="text-center">
  <img src="sms_image.png" class="rounded" style="width: 350px;" alt="...">
</div>
  <div class="d-flex align-items-center justify-content-center" style="
    margin-bottom: 50px;
">
        <div class="p-2 bd-highlight col-example"><a href="admin_login.php" class="btn btn-primary mx-4">Admin Login</a></div>
        <div class="p-2 bd-highlight col-example"> <a href="login.php" class="btn btn-primary mx-4">Teacher Login</a></div>
        <div class="p-2 bd-highlight col-example"> <a href="slogin.php" class="btn btn-primary mx-4">Student Login</a></div>
      </div>
<?php

include "footer.php";
?>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
    <script src="js/bootstrap.bundle.min.js"></script>
  </body>
</html>