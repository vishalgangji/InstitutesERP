<?php
session_start();
echo "logging you out....";
session_destroy();
header("location: index.php");
?>