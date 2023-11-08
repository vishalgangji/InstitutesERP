<?php
include "database_connection.php";
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST["action"] == 'Add') {
      
        $file_cid = $_POST["f_cid"];
        $file_uid = $_POST["f_uid"];
        $file_ud = $_POST["f_ud"];
        $file_name = $_POST["f_name"];
        $file_file = $_FILES["f_file"];
        $filename = $file_file['name'];


        $temp = explode(".", $_FILES["f_file"]["name"]);
        $newfilename = round(microtime(true)) . '.' . end($temp);
        $destinationfile = 'resource/' . $newfilename;
        move_uploaded_file($_FILES["f_file"]["tmp_name"], $destinationfile);
        // echo '<a href="'.$destinationfile.'">go</a>';
        echo $_SERVER["REQUEST_URI"];
        $q = "INSERT INTO `file`(`file_name`, `file_class`, `file_file`, `file_uid`, `file_ud`) VALUES ('$file_name','$file_cid','$destinationfile','$file_uid','$file_ud')";

        $query = mysqli_query($conn, $q);
        if ($query) {
            if($file_ud==0)
            {
                header("Location: resource.php?class=$file_cid&insert=1");
            }
            else
            {
                header("Location: resource.php?insert=1");
            }
        } else {
            header("Location: dbfile.php?insert=0");
        }
    } else if ($_POST["action"] == "delete") {
        $file_id = $_POST["file_id"];
        $file_file = $_POST["file_file"];
        $file_ud = $_POST["file_ud"];
        $file_cid = $_POST["file_cid"];
        echo $file_id.$file_file.$file_ud.$file_cid;
        $q_dele = "DELETE FROM file WHERE file_id ='$file_id'";
        $query = mysqli_query($conn, $q_dele);
        if ($query) {

            unlink($file_file);
            if($file_ud==0)
            {
                header("Location: resource.php?class=$file_cid&delete=1");
            }
            else
            {
                header("Location: resource.php?delete=1");
            }
        } else {
            header("Location: resource.php?delete=0");
        }
    }
}
?>