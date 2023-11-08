<?php
 include('database_connection.php');
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //msg: msg,cn: cn,cid: cid,uid: uid,ud: ud
    $msg = $_POST['msg'];
    $cn= $_POST['cn'];
    $cid = $_POST['cid'];
    $uid = $_POST['uid'];
    $ud = $_POST['ud'];
    if ($msg=="") {
      echo "msg blank";
    }
    else
    {
    $sql = "INSERT INTO `msg`(`msg`, `msg_class`, `msg_uid`, `msg_ud`) VALUES ('$msg','$cid','$uid','$ud')";
    $result = mysqli_query($conn, $sql);
  }
  }
?>